<?php

declare(strict_types=1);

/**
 * GhostCrawl PHP SDK — idiomatic facade over the Kiota-generated core.
 *
 * Architecture:
 *
 *   _generated/ Kiota core  — spec-faithful request-builder (models, transport, auth)
 *   This FACADE              — thin idiomatic layer delegating to the generated builders
 *
 * All HTTP transport, URL routing, serialization, and auth come from the generated core.
 * The facade maps idiomatic calls ($client->scrape()) to generated builders via
 * BaseBearerTokenAuthenticationProvider + GuzzleRequestAdapter.
 *
 * The facade constructs the Kiota adapter + V1 builder directly (mirroring what the
 * generated GhostCrawlClient root does), avoiding a class-name conflict between
 * our facade and the generated root entry-point.
 *
 * Usage:
 * <code>
 *   require_once 'vendor/autoload.php';
 *   $client = new \GhostCrawl\GhostCrawlClient('gck_live_YOUR_KEY');
 *   $result = $client->scrape('https://example.com');
 *   echo $result['content'];
 * </code>
 */

namespace GhostCrawl;

use Http\Promise\FulfilledPromise;
use Http\Promise\Promise as HttpPromise;
use Microsoft\Kiota\Abstractions\ApiClientBuilder;
use Microsoft\Kiota\Abstractions\Authentication\BaseBearerTokenAuthenticationProvider;
use Microsoft\Kiota\Abstractions\Authentication\AccessTokenProvider;
use Microsoft\Kiota\Abstractions\Authentication\AllowedHostsValidator;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use Microsoft\Kiota\Serialization\Form\FormParseNodeFactory;
use Microsoft\Kiota\Serialization\Form\FormSerializationWriterFactory;
use Microsoft\Kiota\Serialization\Json\JsonParseNodeFactory;
use Microsoft\Kiota\Serialization\Json\JsonSerializationWriterFactory;
use Microsoft\Kiota\Serialization\Multipart\MultipartSerializationWriterFactory;
use Microsoft\Kiota\Serialization\Text\TextParseNodeFactory;
use Microsoft\Kiota\Serialization\Text\TextSerializationWriterFactory;

use GhostCrawl\V1\V1RequestBuilder;
use Microsoft\Kiota\Abstractions\ApiException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;

// ---------------------------------------------------------------------------
// Error mapper — translates transport-layer exceptions into GhostCrawlError
// ---------------------------------------------------------------------------

/**
 * Resolves a Kiota Promise and normalizes every failure into a
 * {@see GhostCrawlError} subclass, so callers only ever have to catch the
 * documented SDK exception hierarchy — never raw Guzzle/Kiota internals.
 *
 * @internal
 */
final class ErrorMapper
{
    /**
     * Run a Kiota Promise to completion, mapping any thrown transport error
     * (Kiota ApiException, Guzzle HTTP/connection errors) to the appropriate
     * GhostCrawlError subclass keyed on HTTP status.
     *
     * @param \Http\Promise\Promise $promise
     * @return mixed The resolved value (StreamInterface, Parsable, array, or null).
     */
    public static function wait(\Http\Promise\Promise $promise): mixed
    {
        try {
            return $promise->wait();
        } catch (ApiException $e) {
            // Kiota wraps non-2xx responses it can't deserialize (everything
            // except the 422 each endpoint maps) into an ApiException.
            $status = $e->getResponseStatusCode() ?? $e->getCode();
            throw self::forStatus((int) $status, $e->getMessage(), self::responseBody($e));
        } catch (BadResponseException $e) {
            // Guzzle 4xx/5xx that surfaced with a response attached.
            $response = $e->getResponse();
            $status = $response->getStatusCode();
            $body = (string) $response->getBody();
            throw self::forStatus($status, $e->getMessage(), $body);
        } catch (GuzzleException $e) {
            // Connection refused, timeout, DNS, etc. — no HTTP response.
            throw new APIError(
                'Could not reach the GhostCrawl API: ' . $e->getMessage(),
                0,
                '',
            );
        }
    }

    /**
     * Map an HTTP status code to the matching GhostCrawlError subclass, enriched
     * with the canonical error code, retryability, and request id.
     *
     * The API surfaces "our" failures as non-2xx application/problem+json bodies
     * carrying `code` and `instance` (the request id). Kiota does not always
     * preserve the response body for non-2xx without a spec error-mapping, so we
     * decode whatever body/message string IS available; when no `code` is present
     * we fall back to the canonical status->code map ({@see ErrorCodes::codeForStatus()}).
     *
     * The subclass selection stays keyed on HTTP status for back-compat; only the
     * canonical metadata (code/retryable/requestId) is layered on.
     */
    private static function forStatus(int $status, string $message, string $body): GhostCrawlError
    {
        $msg = $message !== '' ? $message : "GhostCrawl API request failed (HTTP {$status})";

        // Try to read a problem+json `code`/`instance` from the body, then the
        // message string (Kiota sometimes folds the body into the message).
        $code      = null;
        $requestId = null;
        foreach ([$body, $message] as $candidate) {
            if ($candidate === '') {
                continue;
            }
            $decoded = json_decode($candidate, true);
            // Kiota often folds the problem+json into a text-prefixed message
            // (e.g. "...no error class is registered for this code 422 {json}").
            // A whole-string decode then fails; recover the embedded JSON object.
            if (!is_array($decoded)) {
                $start = strpos($candidate, '{');
                $end   = strrpos($candidate, '}');
                if ($start !== false && $end !== false && $end > $start) {
                    $decoded = json_decode(substr($candidate, $start, $end - $start + 1), true);
                }
            }
            if (!is_array($decoded)) {
                continue;
            }
            if ($code === null && isset($decoded['code']) && is_string($decoded['code'])) {
                $code = $decoded['code'];
            }
            // problem+json `instance` carries the request id.
            if ($requestId === null && isset($decoded['instance']) && is_string($decoded['instance'])) {
                $requestId = $decoded['instance'];
            }
            if ($requestId === null && isset($decoded['request_id']) && is_string($decoded['request_id'])) {
                $requestId = $decoded['request_id'];
            }
        }

        // Fall back to the canonical status->code map when the body carried none.
        if ($code === null) {
            $code = ErrorCodes::codeForStatus($status);
        }
        $retryable = ErrorCodes::retryable($code);

        return match (true) {
            $status === 401 => new AuthenticationError($msg, $status, $body, $code, $retryable, $requestId),
            $status === 402 => new PaymentRequiredError($msg, $status, $body, $code, $retryable, $requestId),
            $status === 422 => new InvalidRequestError($msg, $status, $body, $code, $retryable, $requestId),
            $status === 429 => new RateLimitError($msg, $status, $body, $code, $retryable, $requestId),
            $status >= 500  => new APIError($msg, $status, $body, $code, $retryable, $requestId),
            default         => new GhostCrawlError($msg, $status, $body, $code, $retryable, $requestId),
        };
    }

    /**
     * Scan a successful (HTTP 200) result object for a target-side failure and,
     * if present, raise a {@see ScrapeError} — the RESULT channel.
     *
     * A failure is reported when any of the following hold:
     *  - `result_error` is an array carrying a `code`;
     *  - `ok` is explicitly `false`;
     *  - a top-level `code` is a RESULT-channel code ({@see ErrorCodes::isResultCode()}).
     *
     * The code is taken from `result_error.code` first, then a top-level RESULT
     * code; an explicit `ok: false` with no code maps to `empty_content`.
     * Retryability comes from `result_error.retryable` when set, else the catalog.
     * A genuinely-OK result never throws.
     *
     * @param array<string, mixed> $result
     */
    public static function raiseOnResultError(array $result): void
    {
        // Descend into a `results` envelope (scrape/extract wrap per-URL results) —
        // the target failure lives on the INNER result, not the envelope top level.
        if (isset($result['results']) && is_array($result['results'])) {
            foreach ($result['results'] as $item) {
                if (is_array($item)) {
                    self::raiseOnResultError($item);
                }
            }
            return;
        }

        $resultError = (isset($result['result_error']) && is_array($result['result_error']))
            ? $result['result_error']
            : null;

        $okFalse = array_key_exists('ok', $result) && $result['ok'] === false;

        // Resolve the canonical code: result_error.code wins, then a top-level
        // RESULT-channel code.
        $code = null;
        if ($resultError !== null && isset($resultError['code']) && is_string($resultError['code'])) {
            $code = $resultError['code'];
        } elseif (isset($result['code']) && is_string($result['code']) && ErrorCodes::isResultCode($result['code'])) {
            $code = $result['code'];
        }

        // The flat markdown-build envelope reports a target failure ONLY via
        // status="failed" (no ok/result_error) — don't count it as a success.
        $statusFailed = isset($result['status']) && $result['status'] === 'failed';

        // Decide whether this result represents a failure at all.
        $isFailure = $resultError !== null || $okFalse || $code !== null || $statusFailed;
        if (!$isFailure) {
            return;
        }

        // ok:false with no discernible code -> no extractable content.
        if ($code === null) {
            $code = ErrorCodes::EMPTY_CONTENT;
        }

        // Retryability: explicit result_error.retryable wins, else the catalog.
        if ($resultError !== null && array_key_exists('retryable', $resultError)) {
            $retryable = (bool) $resultError['retryable'];
        } else {
            $retryable = ErrorCodes::retryable($code);
        }

        $requestId = (isset($result['request_id']) && is_string($result['request_id']))
            ? $result['request_id']
            : null;

        // target_status (the upstream HTTP status) may live on result_error or top-level.
        $targetStatus = null;
        if ($resultError !== null && isset($resultError['target_status']) && is_int($resultError['target_status'])) {
            $targetStatus = $resultError['target_status'];
        } elseif (isset($result['target_status']) && is_int($result['target_status'])) {
            $targetStatus = $result['target_status'];
        }

        $reason = ($resultError !== null && isset($resultError['reason']) && is_string($resultError['reason']))
            ? $resultError['reason']
            : null;
        $msg = $reason ?? "Target-side failure ({$code})";

        throw new ScrapeError(
            $msg,
            200,
            (string) json_encode($result),
            $code,
            $retryable,
            $requestId,
            $targetStatus,
        );
    }

    /**
     * Best-effort extraction of a response body string from an ApiException.
     */
    private static function responseBody(ApiException $e): string
    {
        $previous = $e->getPrevious();
        if ($previous instanceof BadResponseException) {
            return (string) $previous->getResponse()->getBody();
        }
        return '';
    }
}

// ---------------------------------------------------------------------------
// Static bearer token provider — implements AccessTokenProvider
// ---------------------------------------------------------------------------

/**
 * @internal
 */
final class StaticTokenProvider implements AccessTokenProvider
{
    private readonly AllowedHostsValidator $validator;

    public function __construct(private readonly string $token)
    {
        $this->validator = new AllowedHostsValidator([]);
    }

    /**
     * Return a fulfilled Promise resolving to the static bearer token.
     * Kiota v2 AccessTokenProvider uses an async interface (Http\Promise\Promise).
     *
     * @param string $url
     * @param array<string, mixed> $additionalAuthenticationContext
     * @return HttpPromise
     */
    public function getAuthorizationTokenAsync(string $url, array $additionalAuthenticationContext = []): HttpPromise
    {
        return new FulfilledPromise($this->token);
    }

    public function getAllowedHostsValidator(): AllowedHostsValidator
    {
        return $this->validator;
    }
}

// ---------------------------------------------------------------------------
// Sub-clients — each delegates to the generated v1 request builders
// ---------------------------------------------------------------------------

/**
 * Manages crawl runs — /v1/crawl-runs.
 *
 * Non-final so the {@see fetchWaiting()} network seam can be overridden in tests
 * to exercise the event-driven {@see waitForCompletion()} loop without transport.
 */
class CrawlRunsClient
{
    /**
     * Terminal crawl-run states. A run in any of these has stopped moving;
     * results are present when the state is `completed`. Anything else is still
     * in flight. `canceled` is accepted alongside `cancelled` for the US/UK
     * spelling either side may emit.
     *
     * @var list<string>
     */
    private const TERMINAL_RUN_STATES = ['completed', 'failed', 'cancelled', 'canceled'];

    /**
     * Default per-request server-side blocking window (seconds) used by
     * {@see waitForCompletion()}. Matches the server default for `timeout_s`
     * on GET /v1/crawl-runs/{run_id}?wait=true.
     */
    public const DEFAULT_WAIT_WINDOW = 300;

    public function __construct(
        private readonly V1RequestBuilder $v1,
        private readonly string $baseUrl,
    ) {}

    /**
     * Start a new crawl run from a seed URL.
     * Delegates to POST /v1/crawl-runs via the generated CrawlRunsRequestBuilder.
     *
     * @param string    $url                 Seed URL.
     * @param int       $maxDepth            Maximum crawl depth (default 2).
     * @param int       $maxPages            Maximum pages (default 100).
     * @param array     $extra               Additional request fields.
     * @param bool      $raiseOnResultError  Throw a {@see ScrapeError} when the result
     *                                        reports a target-side failure (default true).
     * @param bool      $wait                Start-and-wait: make the START call itself
     *                                        BLOCK server-side until the run is terminal
     *                                        (completed|failed|cancelled) or the server
     *                                        window elapses — sending `wait_until: "completed"`.
     *                                        Event-driven; no client poll loop. If the
     *                                        window elapses first, the current non-terminal
     *                                        run is returned (HTTP 200) and you can hand
     *                                        `run['run_id']` to {@see waitForCompletion()}.
     * @param int|null  $timeout             Bounds the server-side blocking window for
     *                                        `$wait` (sent as `timeout_s`). Null uses the
     *                                        server default (300s).
     * @return array<string, mixed>
     */
    public function start(
        string $url,
        int $maxDepth = 2,
        int $maxPages = 100,
        array $extra = [],
        bool $raiseOnResultError = true,
        bool $wait = false,
        ?int $timeout = null,
    ): array {
        // POST /v1/crawl-runs expects `seed_urls` (list), not `url`, and forbids
        // unknown fields. `action: "start"` selects the start variant server-side.
        $body = ['action' => 'start', 'seed_urls' => [$url], 'max_depth' => $maxDepth, 'max_pages' => $maxPages];
        // Start-and-wait: the server blocks until the run is terminal (or its
        // window elapses) and returns the run inline. This is event-driven
        // server-side — there is no client-side sleep/poll loop.
        if ($wait) {
            $body['wait_until'] = 'completed';
            if ($timeout !== null) {
                $body['timeout_s'] = $timeout;
            }
        }
        $body = array_merge($body, $extra);
        $req = new \GhostCrawl\V1\CrawlRuns\CrawlRunsPostRequestBody();
        $req->setAdditionalData($body);
        $result = ErrorMapper::wait($this->v1->crawlRuns()->post($req));
        $array = ResponseHelper::toArray($result);
        if ($raiseOnResultError) {
            ErrorMapper::raiseOnResultError($array);
        }
        return $array;
    }

    /**
     * Block until a crawl run reaches a terminal state and return the final run.
     *
     * This is EVENT-DRIVEN, not a client-side sleep-poll: each iteration issues
     * `GET /v1/crawl-runs/{run_id}?wait=true&timeout_s=N`, which the server holds
     * open until the run is terminal or the window elapses. On a window timeout
     * the API returns the current non-terminal run (HTTP 200) and this re-arms
     * the next blocking window — the only waiting is the server-side block.
     *
     * The overall bound is `$timeout` (the caller's total deadline, in seconds):
     * each blocking window is capped to the remaining budget so the final request
     * never over-runs it. When `$timeout` elapses before the run is terminal, the
     * last observed non-terminal run is returned (HTTP 200 semantics) — inspect
     * `run['status']` and call again to keep waiting.
     *
     * A terminal `failed`/`cancelled` run is returned as a value (no throw) — the
     * wait succeeded in observing the outcome. Transport/API errors (auth,
     * rate-limit, 5xx) raise a {@see GhostCrawlError}.
     *
     * @param string $runId       The crawl run id (from {@see start()}).
     * @param int    $timeout     Overall deadline in seconds (default 300).
     * @param int    $pollWindow  Per-request server-side blocking window in seconds
     *                            (the `timeout_s` each long-poll arms). Capped to the
     *                            remaining budget. Default {@see DEFAULT_WAIT_WINDOW}.
     * @return array<string, mixed>
     */
    public function waitForCompletion(
        string $runId,
        int $timeout = 300,
        int $pollWindow = self::DEFAULT_WAIT_WINDOW,
    ): array {
        $deadline = microtime(true) + max(0, $timeout);
        $last = null;
        while (true) {
            $remaining = $deadline - microtime(true);
            if ($remaining <= 0) {
                // Caller deadline reached: return the last observed run, or a
                // fresh non-blocking fetch if we never issued a window.
                return $last ?? $this->get($runId);
            }
            // Cap this window to the remaining budget so the final blocking
            // request never over-runs the caller's deadline.
            $window = (int) min($pollWindow, (int) ceil($remaining));
            if ($window < 1) {
                $window = 1;
            }
            $run = $this->fetchWaiting($runId, $window);
            $last = $run;
            if (self::isTerminal($run)) {
                return $run;
            }
            // Non-terminal: the server window elapsed. Loop re-arms the next
            // blocking window (subject to the deadline) — no client-side sleep.
        }
    }

    /**
     * Issue the long-polling GET .../{run_id}?wait=true&timeout_s=N.
     *
     * The generated item builder has no query-parameter surface for this route,
     * so the fully-qualified URL (with the wait params) is supplied via withUrl(),
     * which still routes through the canonical adapter (auth + transport).
     *
     * @return array<string, mixed>
     * @internal Exposed as protected only so the wait loop can be unit-tested.
     */
    protected function fetchWaiting(string $runId, int $timeoutS): array
    {
        $rawUrl = sprintf(
            '%s/v1/crawl-runs/%s?wait=true&timeout_s=%d',
            $this->baseUrl,
            rawurlencode($runId),
            $timeoutS,
        );
        $result = ErrorMapper::wait($this->v1->crawlRuns()->byRun_id($runId)->withUrl($rawUrl)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * True when a crawl-run record has reached a terminal state.
     *
     * @param array<string, mixed> $run
     */
    private static function isTerminal(array $run): bool
    {
        $status = $run['status'] ?? null;
        return is_string($status) && in_array($status, self::TERMINAL_RUN_STATES, true);
    }

    /**
     * List crawl runs.
     * Delegates to GET /v1/crawl-runs via the generated CrawlRunsRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->crawlRuns()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get a single crawl run by ID.
     * Delegates to GET /v1/crawl-runs/{run_id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function get(string $runId): array
    {
        $result = ErrorMapper::wait($this->v1->crawlRuns()->byRun_id($runId)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Cancel a running crawl run.
     * Delegates to POST /v1/crawl-runs/{run_id}/cancel via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function cancel(string $runId): array
    {
        $result = ErrorMapper::wait($this->v1->crawlRuns()->byRun_id($runId)->cancel()->post());
        return ResponseHelper::toArray($result);
    }
}

/**
 * Manages browser sessions — /v1/sessions.
 */
final class SessionsClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * List all active sessions.
     * Delegates to GET /v1/sessions via the generated SessionsRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->sessions()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Create a new browser session.
     * Delegates to POST /v1/sessions/create via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function create(string $profileName, array $extra = []): array
    {
        $body = new \GhostCrawl\Models\SessionCreateRequest();
        $body->setAdditionalData(array_merge(['profile' => $profileName], $extra));
        $result = ErrorMapper::wait($this->v1->sessions()->create()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Extend a session's TTL.
     * Delegates to POST /v1/sessions/{id}/extend via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function extend(string $sessionId, int $durationSeconds = 300): array
    {
        $body = new \GhostCrawl\Models\ExtendBody();
        $body->setAdditionalData(['ttl_seconds' => $durationSeconds]);
        $result = ErrorMapper::wait($this->v1->sessions()->byProfile_Id($sessionId)->extend()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Release a session back to the pool.
     * Delegates to POST /v1/sessions/{id}/release via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function release(string $sessionId): array
    {
        $result = ErrorMapper::wait($this->v1->sessions()->byProfile_Id($sessionId)->release()->post());
        return ResponseHelper::toArray($result);
    }
}

/**
 * Manages identity profiles — /v1/profiles.
 */
final class ProfilesClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * List all profiles.
     * Delegates to GET /v1/profiles via the generated ProfilesRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->profiles()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get a profile by name.
     * Delegates to GET /v1/profiles/{name} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function get(string $name): array
    {
        $result = ErrorMapper::wait($this->v1->profiles()->byName($name)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Create a new profile.
     * Delegates to POST /v1/profiles via the generated ProfilesRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function create(string $name, array $config = []): array
    {
        $body = new \GhostCrawl\Models\ProfileCreateRequest();
        $body->setAdditionalData(array_merge(['name' => $name], $config));
        $result = ErrorMapper::wait($this->v1->profiles()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Update a profile.
     * Delegates to PUT /v1/profiles/{name} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function update(string $name, array $config): array
    {
        $body = new \GhostCrawl\Models\ProfileUpdateRequest();
        $body->setAdditionalData($config);
        $result = ErrorMapper::wait($this->v1->profiles()->byName($name)->put($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Delete a profile.
     * Delegates to DELETE /v1/profiles/{name} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function delete(string $name): array
    {
        ErrorMapper::wait($this->v1->profiles()->byName($name)->delete());
        return [];
    }
}

/**
 * Manages webhooks — /v1/webhooks.
 */
final class WebhooksClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * List all webhooks.
     * Delegates to GET /v1/webhooks via the generated WebhooksRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->webhooks()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get a webhook by ID.
     * Delegates to GET /v1/webhooks/{id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function get(string $webhookId): array
    {
        $result = ErrorMapper::wait($this->v1->webhooks()->byWebhook_id($webhookId)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Register a new webhook endpoint.
     * Delegates to POST /v1/webhooks via the generated WebhooksRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function create(string $url, ?array $eventTypes = null, array $extra = []): array
    {
        $body = new \GhostCrawl\Models\WebhookCreateRequest();
        $data = array_merge(['url' => $url], $extra);
        // The API field is "event_types".
        if ($eventTypes !== null) {
            $data['event_types'] = $eventTypes;
        }
        $body->setAdditionalData($data);
        $result = ErrorMapper::wait($this->v1->webhooks()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Delete a webhook.
     * Delegates to DELETE /v1/webhooks/{id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function delete(string $webhookId): array
    {
        ErrorMapper::wait($this->v1->webhooks()->byWebhook_id($webhookId)->delete());
        return [];
    }

    /**
     * Rotate the signing secret for a webhook.
     * Delegates to POST /v1/webhooks/{id}/rotate-secret via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function rotateSecret(string $webhookId): array
    {
        $result = ErrorMapper::wait($this->v1->webhooks()->byWebhook_id($webhookId)->rotateSecret()->post());
        return ResponseHelper::toArray($result);
    }
}

/**
 * Manages schedules — /v1/schedules.
 */
final class SchedulesClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * List all schedules.
     * Delegates to GET /v1/schedules via the generated SchedulesRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->schedules()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get a schedule by ID.
     * Delegates to GET /v1/schedules/{id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function get(string $scheduleId): array
    {
        $result = ErrorMapper::wait($this->v1->schedules()->bySchedule_id($scheduleId)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Create a new schedule.
     * Delegates to POST /v1/schedules via the generated SchedulesRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function create(
        string $cron,
        array $task = [],
        array $extra = [],
        ?string $name = null,
        ?string $jobType = null,
        ?array $jobParams = null,
    ): array {
        // The API's ScheduleCreateRequest requires {name, job_type, cron_expr,
        // job_params}. Accept them as first-class params; fall back to legacy
        // callers that packed them into $extra (or a $task dict) for back-compat.
        $body = new \GhostCrawl\Models\ScheduleCreateRequest();
        $data = ['cron_expr' => $cron];
        if ($name !== null)      { $data['name'] = $name; }
        if ($jobType !== null)   { $data['job_type'] = $jobType; }
        if ($jobParams !== null) { $data['job_params'] = $jobParams; }
        // Legacy: a $task dict may carry job_type/job_params/name.
        if ($task !== []) {
            $data += array_intersect_key($task, array_flip(['name', 'job_type', 'job_params']));
            if (!isset($data['job_params']) && !isset($task['job_type']) && !isset($task['name'])) {
                // Unstructured task -> treat as job_params so it still reaches the server.
                $data['job_params'] = $task;
            }
        }
        $body->setAdditionalData(array_merge($data, $extra));
        $result = ErrorMapper::wait($this->v1->schedules()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Delete a schedule.
     * Delegates to DELETE /v1/schedules/{id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function delete(string $scheduleId): array
    {
        ErrorMapper::wait($this->v1->schedules()->bySchedule_id($scheduleId)->delete());
        return [];
    }
}

/**
 * Manages datasets — /v1/datasets.
 */
final class DatasetsClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * List all datasets.
     * Delegates to GET /v1/datasets via the generated DatasetsRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->datasets()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get a dataset by name.
     * Delegates to GET /v1/datasets/{name} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function get(string $name): array
    {
        $result = ErrorMapper::wait($this->v1->datasets()->byName($name)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Create a new dataset.
     * Delegates to POST /v1/datasets via the generated DatasetsRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function create(string $name, array $extra = []): array
    {
        $body = new \GhostCrawl\V1\Datasets\DatasetsPostRequestBody();
        $body->setAdditionalData(array_merge(['name' => $name], $extra));
        $result = ErrorMapper::wait($this->v1->datasets()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Delete a dataset.
     * Delegates to DELETE /v1/datasets/{name} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function delete(string $name): array
    {
        $result = ErrorMapper::wait($this->v1->datasets()->byName($name)->delete());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get rows from a dataset.
     * Delegates to GET /v1/datasets/{name}/rows via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function rows(string $name): array
    {
        $result = ErrorMapper::wait($this->v1->datasets()->byName($name)->rows()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Append rows to a dataset.
     * Delegates to POST /v1/datasets/{name}/rows/append via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function append(string $name, array $rows): array
    {
        $body = new \GhostCrawl\V1\Datasets\Item\Rows\Append\AppendPostRequestBody();
        $body->setAdditionalData(['rows' => $rows]);
        $result = ErrorMapper::wait($this->v1->datasets()->byName($name)->rows()->append()->post($body));
        return ResponseHelper::toArray($result);
    }
}

/**
 * Manages session recordings — /v1/recordings.
 */
final class RecordingsClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * List all recordings.
     * Delegates to GET /v1/recordings via the generated RecordingsRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        $result = ErrorMapper::wait($this->v1->recordings()->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Get a recording by ID.
     * Delegates to GET /v1/recordings/{id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function get(string $recordingId): array
    {
        $result = ErrorMapper::wait($this->v1->recordings()->byRecording_Id($recordingId)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Delete a recording.
     * Delegates to DELETE /v1/recordings/{id} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function delete(string $recordingId): array
    {
        ErrorMapper::wait($this->v1->recordings()->byRecording_Id($recordingId)->delete());
        return [];
    }
}

/**
 * Key-value store — /v1/kv.
 */
final class KVClient
{
    public function __construct(private readonly V1RequestBuilder $v1) {}

    /**
     * Get a value by key.
     * Delegates to GET /v1/kv/{key} via the generated KvRequestBuilder.
     *
     * @return array<string, mixed>
     */
    public function get(string $key): array
    {
        $result = ErrorMapper::wait($this->v1->kv()->byKey($key)->get());
        return ResponseHelper::toArray($result);
    }

    /**
     * Set a key-value pair.
     * Delegates to PUT /v1/kv/{key} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function set(string $key, mixed $value): array
    {
        $body = new \GhostCrawl\V1\Kv\Item\WithKeyPutRequestBody();
        $body->setAdditionalData(['value' => $value]);
        $result = ErrorMapper::wait($this->v1->kv()->byKey($key)->put($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Delete a key.
     * Delegates to DELETE /v1/kv/{key} via the generated builder.
     *
     * @return array<string, mixed>
     */
    public function delete(string $key): array
    {
        $result = ErrorMapper::wait($this->v1->kv()->byKey($key)->delete());
        return ResponseHelper::toArray($result);
    }
}

// ---------------------------------------------------------------------------
// Response helper
// ---------------------------------------------------------------------------

/**
 * @internal
 */
final class ResponseHelper
{
    /**
     * Converts any Kiota response to a plain PHP array.
     *
     * The generated scrape/search/extract builders return StreamInterface (via
     * sendPrimitiveAsync) rather than a typed Parsable model. Read the stream
     * and JSON-decode it to get the actual response data.
     *
     * @param mixed $value
     * @return array<string, mixed>
     */
    public static function toArray(mixed $value): array
    {
        if ($value === null) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        // PSR-7 StreamInterface — generated builders for endpoints that return
        // arbitrary JSON (scrape, search, extract, etc.) use sendPrimitiveAsync
        // with StreamInterface::class; read and JSON-decode the body.
        if ($value instanceof \Psr\Http\Message\StreamInterface) {
            $json = (string) $value;
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return [];
        }
        // Typed Parsable (MeResponse, MapResponse, …): the real fields are typed
        // properties, NOT in getAdditionalData() — that bucket is empty/[] for a
        // pure-typed model. Serialize the model itself through the Kiota JSON
        // writer (which invokes the model's serialize(), emitting every typed
        // field) and decode that. Falling back to getAdditionalData() alone here
        // returned an empty [] for /v1/map. Any leftover additionalData
        // is merged in so a mixed typed+extra response is preserved.
        if ($value instanceof \Microsoft\Kiota\Abstractions\Serialization\Parsable) {
            try {
                $writer = new \Microsoft\Kiota\Serialization\Json\JsonSerializationWriter();
                $writer->writeObjectValue('', $value);
                $json = (string) $writer->getSerializedContent();
                $decoded = json_decode($json, true);
                if (is_array($decoded) && $decoded !== []) {
                    return $decoded;
                }
            } catch (\Throwable) {
                // fall through to the additionalData path below
            }
        }
        // Typed Parsable with additionalData only (or serialize() produced nothing).
        if (method_exists($value, 'getAdditionalData')) {
            $data = $value->getAdditionalData();
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }
}

// ---------------------------------------------------------------------------
// Main facade — GhostCrawlClient
// ---------------------------------------------------------------------------

/**
 * GhostCrawl idiomatic PHP API client.
 *
 * Delegates all HTTP transport, URL routing, serialization, and auth to the
 * Kiota-generated canonical core (_generated/). This facade is the shipped API.
 *
 * Constructs the Kiota adapter + V1 request builder directly (mirroring what
 * the generated GhostCrawlClient root does), so there is no class-name conflict.
 *
 * @example
 * ```php
 * $client = new \GhostCrawl\GhostCrawlClient('gck_live_YOUR_KEY');
 * $result = $client->scrape('https://example.com');
 * echo $result['content'];
 * ```
 */
class GhostCrawlClient
{
    private const DEFAULT_BASE_URL = 'https://api.ghostcrawl.io';

    private readonly V1RequestBuilder $v1;
    private readonly GuzzleRequestAdapter $adapter;

    public readonly CrawlRunsClient   $crawlRuns;
    public readonly SessionsClient    $sessions;
    public readonly ProfilesClient    $profiles;
    public readonly WebhooksClient    $webhooks;
    public readonly SchedulesClient   $schedules;
    public readonly DatasetsClient    $datasets;
    public readonly RecordingsClient  $recordings;
    public readonly KVClient          $kv;

    /**
     * @param string|null $token   API key. Falls back to GHOSTCRAWL_API_KEY env var.
     * @param string|null $baseUrl Override API base URL. Falls back to GHOSTCRAWL_BASE_URL.
     */
    public function __construct(?string $token = null, ?string $baseUrl = null)
    {
        $resolved = $token ?? (getenv('GHOSTCRAWL_API_KEY') ?: null);
        if (empty($resolved)) {
            throw new \InvalidArgumentException(
                'token is required — pass it to GhostCrawlClient or set GHOSTCRAWL_API_KEY. '
                . 'Get your key at https://ghostcrawl.io'
            );
        }

        $envBase    = getenv('GHOSTCRAWL_BASE_URL') ?: null;
        $resolvedBase = rtrim($baseUrl ?? $envBase ?? self::DEFAULT_BASE_URL, '/');

        // Build the Kiota core: BaseBearerTokenAuthenticationProvider + GuzzleRequestAdapter.
        // All HTTP, auth, serialization, and URL routing delegate to the generated V1 builders.
        $authProvider = new BaseBearerTokenAuthenticationProvider(
            new StaticTokenProvider($resolved)
        );
        $adapter = new GuzzleRequestAdapter($authProvider);
        $adapter->setBaseUrl($resolvedBase);

        // Register serializers — mirrors what the generated GhostCrawlClient.__construct does.
        ApiClientBuilder::registerDefaultSerializer(JsonSerializationWriterFactory::class);
        ApiClientBuilder::registerDefaultSerializer(TextSerializationWriterFactory::class);
        ApiClientBuilder::registerDefaultSerializer(FormSerializationWriterFactory::class);
        ApiClientBuilder::registerDefaultSerializer(MultipartSerializationWriterFactory::class);
        ApiClientBuilder::registerDefaultDeserializer(JsonParseNodeFactory::class);
        ApiClientBuilder::registerDefaultDeserializer(TextParseNodeFactory::class);
        ApiClientBuilder::registerDefaultDeserializer(FormParseNodeFactory::class);

        $pathParameters = ['baseurl' => $resolvedBase];
        $this->adapter = $adapter;
        $this->v1 = new V1RequestBuilder($pathParameters, $adapter);

        $this->crawlRuns  = new CrawlRunsClient($this->v1, $resolvedBase);
        $this->sessions   = new SessionsClient($this->v1);
        $this->profiles   = new ProfilesClient($this->v1);
        $this->webhooks   = new WebhooksClient($this->v1);
        $this->schedules  = new SchedulesClient($this->v1);
        $this->datasets   = new DatasetsClient($this->v1);
        $this->recordings = new RecordingsClient($this->v1);
        $this->kv         = new KVClient($this->v1);
    }

    // -------------------------------------------------------------------------
    // Top-level facade methods — delegate to generated builders
    // -------------------------------------------------------------------------

    /**
     * Scrape a single URL and return the rendered content.
     * Delegates to POST /v1/scrape via the generated ScrapeRequestBuilder.
     *
     * @param string      $url           Target URL to scrape.
     * @param string      $format        Output format: "markdown" (default), "html", "text".
     * @param string      $engine        Browser engine: "auto" (default), "chrome", "firefox", "webkit".
     * @param bool        $javascript    Enable JavaScript rendering (default true).
     * @param array|null  $extractSchema      JSON Schema for structured extraction.
     * @param array       $extra              Additional request fields.
     * @param bool        $raiseOnResultError Throw a {@see ScrapeError} when the
     *                                        result reports a target-side failure
     *                                        (default true).
     * @return array<string, mixed>
     */
    public function scrape(
        string $url,
        string $format = 'markdown',
        string $engine = 'auto',
        bool $javascript = true,
        ?array $extractSchema = null,
        array $extra = [],
        bool $raiseOnResultError = true
    ): array {
        $body = new \GhostCrawl\Models\ScrapeRequest();
        $data = array_merge(
            ['url' => $url, 'format' => $format, 'engine' => $engine, 'javascript_enabled' => $javascript],
            $extra
        );
        if ($extractSchema !== null) {
            $data['extract_schema'] = $extractSchema;
        }
        $body->setAdditionalData($data);
        $result = ErrorMapper::wait($this->v1->scrape()->post($body));
        $array = ResponseHelper::toArray($result);
        if ($raiseOnResultError) {
            ErrorMapper::raiseOnResultError($array);
        }
        return $this->normalizeScrapeContent($array);
    }

    /**
     * Normalize a generic `content` key onto a scrape response.
     *
     * The API returns the rendered page under a format-specific key
     * ("markdown", or "html"/"text"), but the SDK contract exposes a generic
     * `content` key. This copies the format-specific value into `content`
     * while KEEPING the original key (backward compatible). No-op when the
     * value is not an array or already carries a `content` key.
     *
     * @param array<string, mixed> $result
     * @return array<string, mixed>
     */
    private function normalizeScrapeContent(array $result): array
    {
        if (array_key_exists('content', $result)) {
            return $result;
        }
        $value = null;
        $fmt = $result['format'] ?? null;
        if (is_string($fmt) && isset($result[$fmt]) && is_string($result[$fmt])) {
            $value = $result[$fmt];
        } else {
            foreach (['markdown', 'html', 'text'] as $key) {
                if (isset($result[$key]) && is_string($result[$key])) {
                    $value = $result[$key];
                    break;
                }
            }
        }
        if ($value !== null) {
            $result['content'] = $value;
        }
        return $result;
    }

    /**
     * Search the web and return results.
     * Delegates to POST /v1/search via the generated SearchRequestBuilder.
     *
     * /v1/search requires your own search-backend API key (BYO; GhostCrawl
     * charges no markup). Pass it as $providerKey — it is sent as the
     * `X-Provider-Authorization: Bearer <providerKey>` header the backend
     * requires. Without it the API replies 401 search_backend_key_missing.
     *
     * @param string      $query       Search query.
     * @param string      $engine      Search engine: "google" (default), "bing", "duckduckgo".
     * @param int         $limit       Maximum results (default 10).
     * @param array       $extra       Additional request fields.
     * @param string|null $providerKey BYO search-backend key (sent as X-Provider-Authorization).
     * @return array<string, mixed>
     */
    public function search(string $query, string $engine = 'google', int $limit = 10, array $extra = [], ?string $providerKey = null): array
    {
        $body = new \GhostCrawl\Models\SearchRequest();
        $body->setAdditionalData(array_merge(['query' => $query, 'engine' => $engine, 'limit' => $limit], $extra));
        $config = null;
        if ($providerKey !== null) {
            $config = new \GhostCrawl\V1\Search\SearchRequestBuilderPostRequestConfiguration(
                ['X-Provider-Authorization' => 'Bearer ' . $providerKey]
            );
        }
        $result = ErrorMapper::wait($this->v1->search()->post($body, $config));
        return ResponseHelper::toArray($result);
    }

    /**
     * Extract structured data from a URL using a JSON Schema.
     * Delegates to POST /v1/extract via the generated ExtractRequestBuilder.
     *
     * @param string $url                 Target URL.
     * @param array  $schema              JSON Schema describing the shape to extract.
     * @param array  $extra               Additional request fields.
     * @param bool   $raiseOnResultError  Throw a {@see ScrapeError} when the result
     *                                     reports a target-side failure (default true).
     * @return array<string, mixed>
     */
    public function extract(string $url, array $schema, array $extra = [], bool $raiseOnResultError = true): array
    {
        $body = new \GhostCrawl\Models\ExtractRequest();
        $body->setAdditionalData(array_merge(['url' => $url, 'schema' => $schema], $extra));
        $result = ErrorMapper::wait($this->v1->extract()->post($body));
        $array = ResponseHelper::toArray($result);
        if ($raiseOnResultError) {
            ErrorMapper::raiseOnResultError($array);
        }
        return $array;
    }

    /**
     * Start a deep crawl from a seed URL.
     * Delegates to POST /v1/crawl/deep via the generated CrawlDeepRequestBuilder.
     *
     * @param string $url                 Seed URL.
     * @param int    $maxDepth            Maximum crawl depth (default 2).
     * @param int    $maxPages            Maximum pages (default 100).
     * @param array  $extra               Additional request fields.
     * @param bool   $raiseOnResultError  Throw a {@see ScrapeError} when the result
     *                                     reports a target-side failure (default true).
     * @return array<string, mixed>
     */
    public function crawl(string $url, int $maxDepth = 2, int $maxPages = 100, array $extra = [], bool $raiseOnResultError = true): array
    {
        $body = new \GhostCrawl\Models\DeepCrawlBody();
        $body->setAdditionalData(array_merge(
            ['seed_urls' => [$url], 'max_depth' => $maxDepth, 'max_urls' => $maxPages],
            $extra
        ));
        $result = ErrorMapper::wait($this->v1->crawl()->deep()->post($body));
        $array = ResponseHelper::toArray($result);
        if ($raiseOnResultError) {
            ErrorMapper::raiseOnResultError($array);
        }
        return $array;
    }

    /**
     * Map all URLs reachable from a seed URL.
     * Delegates to POST /v1/map via the generated MapRequestBuilder.
     *
     * @param string $url   Seed URL.
     * @param array  $extra Additional request fields.
     * @return array<string, mixed>
     */
    public function map(string $url, array $extra = []): array
    {
        $body = new \GhostCrawl\Models\MapBody();
        $body->setAdditionalData(array_merge(['url' => $url], $extra));
        $result = ErrorMapper::wait($this->v1->map()->post($body));
        return ResponseHelper::toArray($result);
    }

    /**
     * Render a URL to a PDF document and return the raw application/pdf bytes.
     * Delegates to POST /v1/pdf.
     *
     * /v1/pdf responds with binary, not a JSON envelope, so this returns the raw
     * bytes as a string — write them straight to a file:
     *
     *   $data = $client->pdf('https://example.com');
     *   file_put_contents('page.pdf', $data);
     *
     * PDF output is Chrome-only; a request that resolves to a Firefox or WebKit
     * identity is rejected with 400 pdf_engine_unsupported (a GhostCrawlError).
     *
     * Routed through the Kiota request adapter (the generated core has no pdf
     * builder — the route serves binary, not a modeled JSON envelope).
     *
     * @param string $url         Target URL to render.
     * @param string $paperFormat Page size: 'a4' (default), 'letter', 'legal', 'tabloid'.
     * @param bool   $landscape   Render in landscape orientation (default false).
     * @param string $engine      Browser engine (PDF is Chrome-only; default 'auto').
     * @param array<string, mixed> $extra Additional request fields.
     * @return string The raw PDF bytes.
     */
    public function pdf(
        string $url,
        string $paperFormat = 'a4',
        bool $landscape = false,
        string $engine = 'auto',
        array $extra = []
    ): string {
        $body = array_merge([
            'url' => $url,
            'paper_format' => $paperFormat,
            'landscape' => $landscape,
            'engine' => $engine,
        ], $extra);
        return $this->sendBinary('POST', '/v1/pdf', $body);
    }

    /**
     * Capture a screenshot of a URL and return the raw image/png bytes.
     * Delegates to POST /v1/screenshot.
     *
     * /v1/screenshot responds with a binary image, not a JSON envelope, so this
     * returns the raw bytes as a string — write them straight to a file:
     *
     *   $data = $client->screenshot('https://example.com');
     *   file_put_contents('page.png', $data);
     *
     * Routed through the Kiota request adapter (mirrors pdf() — the raw-bytes
     * dispatch idiom; the generated core has no screenshot builder).
     *
     * @param string      $url                Target URL to capture.
     * @param string      $format             Image format: 'png' (default), 'jpeg', 'webp'.
     * @param bool        $fullPage           Capture the full scrollable page (default false).
     * @param string|null $screenshotSelector CSS selector to clip to (optional).
     * @param array<string, mixed> $extra     Additional request fields.
     * @return string The raw image bytes.
     */
    public function screenshot(
        string $url,
        string $format = 'png',
        bool $fullPage = false,
        ?string $screenshotSelector = null,
        array $extra = []
    ): string {
        $body = array_merge([
            'url' => $url,
            'format' => $format,
            'full_page' => $fullPage,
        ], $extra);
        if ($screenshotSelector !== null) {
            $body['screenshot_selector'] = $screenshotSelector;
        }
        return $this->sendBinary('POST', '/v1/screenshot', $body, 'image/png');
    }

    /**
     * Render a URL and return the rendered-content JSON envelope as an array.
     * Delegates to POST /v1/content.
     *
     * /v1/content responds with application/json ({content, url, status, format,
     * status_code, bytes}); this returns the decoded array. Routed through the
     * canonical Kiota adapter (mirrors pdf()'s dispatch; JSON body).
     *
     * @param string      $url   Target URL to render.
     * @param array<string, mixed> $extra Additional request fields.
     * @return array<string, mixed> The rendered-content envelope (top-level content = HTML).
     */
    public function content(string $url, array $extra = []): array
    {
        $body = array_merge(['url' => $url], $extra);
        return $this->sendJson('POST', '/v1/content', $body);
    }

    /**
     * List the account's persisted session storage-states.
     * Delegates to GET /v1/storage-states through the Kiota request adapter
     * (the generated core has no builder for this route), reusing the canonical
     * auth + base URL + transport.
     *
     * @return array<string, mixed> The storage-states envelope.
     */
    public function storageStates(): array
    {
        return $this->sendJson('GET', '/v1/storage-states', null);
    }

    /**
     * Execute an agent task via POST /v1/agent.
     * The agent capability is gated per account; when it is not enabled the API
     * replies 404 not_found — this returns that problem+json body as an array
     * (carrying `detail`) rather than raising, so callers can branch on
     * isset($response['detail']).
     *
     * Routed through the Kiota request adapter (the generated core has no agent
     * builder — the route is absent from the customer-facing OpenAPI).
     *
     * @param string|null $instruction Natural-language task instruction.
     * @param string|null $url         Optional starting URL.
     * @param array|null  $steps       Optional explicit step list.
     * @param array|null  $task        Optional structured task object.
     * @param array       $extra       Additional request fields.
     * @return array<string, mixed>
     */
    public function agent(
        ?string $instruction = null,
        ?string $url = null,
        ?array $steps = null,
        ?array $task = null,
        array $extra = []
    ): array {
        $body = $extra;
        if ($instruction !== null) { $body['instruction'] = $instruction; }
        if ($url !== null)         { $body['url'] = $url; }
        if ($steps !== null)       { $body['steps'] = $steps; }
        if ($task !== null)        { $body['task'] = $task; }
        try {
            return $this->sendJson('POST', '/v1/agent', $body);
        } catch (GhostCrawlError $e) {
            // Agent is gated: a 404 not_found is the "capability disabled" answer,
            // not a transport failure. Surface the problem body as a dict.
            if ($e->statusCode === 404) {
                $decoded = json_decode($e->body, true);
                if (is_array($decoded)) { return $decoded; }
                return ['detail' => $e->getMessage(), 'code' => $e->code ?? 'not_found'];
            }
            throw $e;
        }
    }

    /**
     * Route an ad-hoc JSON request through the canonical Kiota adapter (auth +
     * base URL + transport) for endpoints the generated core has no builder for.
     *
     * @param string             $method GET/POST/PUT/DELETE.
     * @param string             $path   Absolute API path, e.g. "/v1/map".
     * @param array<mixed>|null  $body   JSON body (omitted for null/GET).
     * @return array<string, mixed>
     */
    private function sendJson(string $method, string $path, ?array $body): array
    {
        $ri = new \Microsoft\Kiota\Abstractions\RequestInformation();
        $ri->urlTemplate = '{+baseurl}' . $path;
        $ri->pathParameters = ['baseurl' => $this->adapter->getBaseUrl()];
        $ri->httpMethod = $method;
        $ri->tryAddHeader('Accept', 'application/json');
        if ($body !== null && $method !== 'GET') {
            // Send the exact JSON object (not a Kiota-serialized scalar, which would
            // double-encode the string). A raw PSR-7 stream + application/json is the
            // canonical way to attach an arbitrary JSON body for an unbuilt route.
            $ri->setStreamContent(
                \GuzzleHttp\Psr7\Utils::streamFor((string) json_encode($body)),
                'application/json'
            );
        }
        $result = ErrorMapper::wait($this->adapter->sendPrimitiveAsync($ri, \Psr\Http\Message\StreamInterface::class, null));
        return ResponseHelper::toArray($result);
    }

    /**
     * Route an ad-hoc request through the canonical Kiota adapter (auth + base
     * URL + transport) and return the response body as RAW BYTES — for endpoints
     * that serve binary (e.g. POST /v1/pdf → application/pdf) rather than JSON.
     *
     * @param string             $method GET/POST/PUT/DELETE.
     * @param string             $path   Absolute API path, e.g. "/v1/pdf".
     * @param array<mixed>|null  $body   JSON body (omitted for null/GET).
     * @param string             $accept The Accept media type (default application/pdf).
     * @return string The raw response bytes.
     */
    private function sendBinary(string $method, string $path, ?array $body, string $accept = 'application/pdf'): string
    {
        $ri = new \Microsoft\Kiota\Abstractions\RequestInformation();
        $ri->urlTemplate = '{+baseurl}' . $path;
        $ri->pathParameters = ['baseurl' => $this->adapter->getBaseUrl()];
        $ri->httpMethod = $method;
        $ri->tryAddHeader('Accept', $accept);
        if ($body !== null && $method !== 'GET') {
            $ri->setStreamContent(
                \GuzzleHttp\Psr7\Utils::streamFor((string) json_encode($body)),
                'application/json'
            );
        }
        $result = ErrorMapper::wait($this->adapter->sendPrimitiveAsync($ri, \Psr\Http\Message\StreamInterface::class, null));
        if ($result instanceof \Psr\Http\Message\StreamInterface) {
            return $result->getContents();
        }
        return is_string($result) ? $result : (string) $result;
    }
}
