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
use Microsoft\Kiota\Http\KiotaClientFactory;
use Microsoft\Kiota\Http\Middleware\KiotaMiddleware;
use Microsoft\Kiota\Http\Middleware\UserAgentHandler;
use Microsoft\Kiota\Http\Middleware\Options\UserAgentHandlerOption;
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
     * @param \Http\Promise\Promise<mixed> $promise
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

        // The pinned Kiota runtime frequently drops the response body for a
        // non-2xx without a spec error-mapping (401/402/429/5xx), folding the
        // problem+json into getMessage() instead. Recover that embedded JSON so
        // the typed exception's `body` still carries the server detail /
        // `retry_after` a caller inspects (parity with the Python/Ruby facades —
        // 190-08 fix). Never overwrite a body the transport DID preserve.
        if ($body === '' && $message !== '') {
            $start = strpos($message, '{');
            $end   = strrpos($message, '}');
            if ($start !== false && $end !== false && $end > $start) {
                $candidate = substr($message, $start, $end - $start + 1);
                if (is_array(json_decode($candidate, true))) {
                    $body = $candidate;
                }
            }
        }

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
     * Throw the {@see GhostCrawlError} subclass matching an HTTP status — the
     * public entry the search-job poll ({@see SearchPoll::pollSearchJob()}) uses
     * to route a poll-path 4xx/5xx through the SAME typed error hierarchy as the
     * modeled calls.
     *
     * @return never
     */
    public static function raiseStatus(int $status, string $message, string $body): void
    {
        throw self::forStatus($status, $message, $body);
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
     * @return HttpPromise<string>
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
        private readonly GuzzleRequestAdapter $adapter,
    ) {}

    /**
     * Resume a paused/interrupted crawl run.
     * Delegates to POST /v1/crawl-runs/{run_id}/resume through the shared authenticated
     * adapter (the generated core has no resume builder).
     *
     * @return array<string, mixed>
     */
    public function resume(string $runId): array
    {
        return AdapterRequest::json(
            $this->adapter,
            'POST',
            '/v1/crawl-runs/' . rawurlencode($runId) . '/resume',
        );
    }

    /**
     * Start a new crawl run from a seed URL.
     * Delegates to POST /v1/crawl-runs via the generated CrawlRunsRequestBuilder.
     *
     * @param string    $url                 Seed URL.
     * @param int       $maxDepth            Maximum crawl depth (default 2).
     * @param int       $maxPages            Maximum pages (default 100).
     * @param array<string, mixed> $extra    Additional request fields.
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
    public function __construct(
        private readonly V1RequestBuilder $v1,
        private readonly GuzzleRequestAdapter $adapter,
    ) {}

    /**
     * Pin a session to keep it warm (POST /v1/sessions/{session_id}/pin).
     *
     * @return array<string, mixed>
     */
    public function pin(string $sessionId): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($sessionId) . '/pin');
    }

    /**
     * Terminate a session immediately (POST /v1/sessions/{session_id}/terminate).
     *
     * @return array<string, mixed>
     */
    public function terminate(string $sessionId): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($sessionId) . '/terminate');
    }

    /**
     * Take over a live session for interactive control (POST /v1/sessions/{session_id}/takeover).
     *
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    public function takeover(string $sessionId, array $extra = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($sessionId) . '/takeover', $extra ?: null);
    }

    /**
     * Mint a short-lived takeover token (POST /v1/sessions/{session_id}/takeover_token).
     *
     * @return array<string, mixed>
     */
    public function takeoverToken(string $sessionId): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($sessionId) . '/takeover_token');
    }

    /**
     * Release an interactive takeover back to automation (POST /v1/sessions/{session_id}/takeover_release).
     *
     * @return array<string, mixed>
     */
    public function takeoverRelease(string $sessionId): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($sessionId) . '/takeover_release');
    }

    /**
     * Start recording a session (POST /v1/sessions/{profile_id}/recording/start).
     *
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    public function recordingStart(string $profileId, array $extra = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($profileId) . '/recording/start', $extra ?: null);
    }

    /**
     * Stop recording a session (POST /v1/sessions/{profile_id}/recording/stop).
     *
     * @return array<string, mixed>
     */
    public function recordingStop(string $profileId): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/sessions/' . rawurlencode($profileId) . '/recording/stop');
    }

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
     * Two creation modes (pass exactly one — passing both is a server-side
     * validation error):
     *   - profile-based: pass $profileName to rehydrate a saved identity profile
     *     (the org must already own a profile of that name, else the API 404s).
     *   - engine-based (ad-hoc): omit $profileName and the API opens a fresh
     *     session on $engine ("chrome"/"firefox"/"webkit"/"auto"; default "auto")
     *     with no saved profile required — the zero-setup path that works on a
     *     brand-new key with no profiles.
     *
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    public function create(?string $profileName = null, ?string $engine = null, array $extra = []): array
    {
        $body = new \GhostCrawl\Models\SessionCreateRequest();
        $base = $profileName !== null
            ? ['profile' => $profileName]
            : ['engine' => $engine ?? 'auto'];
        $body->setAdditionalData(array_merge($base, $extra));
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
     * @param array<string, mixed> $config
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
     * @param array<string, mixed> $config
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
    public function __construct(
        private readonly V1RequestBuilder $v1,
        private readonly GuzzleRequestAdapter $adapter,
    ) {}

    /**
     * List delivery attempts for a webhook (GET /v1/webhooks/{webhook_id}/deliveries).
     *
     * @return array<string, mixed>
     */
    public function listDeliveries(string $webhookId): array
    {
        return AdapterRequest::json($this->adapter, 'GET', '/v1/webhooks/' . rawurlencode($webhookId) . '/deliveries');
    }

    /**
     * Alias of {@see listDeliveries()} for the canonical `deliveries` surface name.
     *
     * @return array<string, mixed>
     */
    public function deliveries(string $webhookId): array
    {
        return $this->listDeliveries($webhookId);
    }

    /**
     * Retry a failed webhook delivery (POST /v1/webhooks/{webhook_id}/deliveries/{delivery_id}/retry).
     *
     * @return array<string, mixed>
     */
    public function retryDelivery(string $webhookId, string $deliveryId): array
    {
        return AdapterRequest::json(
            $this->adapter,
            'POST',
            '/v1/webhooks/' . rawurlencode($webhookId) . '/deliveries/' . rawurlencode($deliveryId) . '/retry',
        );
    }

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
     * @param list<string>|null    $eventTypes
     * @param array<string, mixed> $extra
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
     * @param array<string, mixed> $task
     * @param array<string, mixed> $extra
     * @param array<string, mixed>|null $jobParams
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
     * @param array<string, mixed> $extra
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
     * @param list<array<string, mixed>> $rows
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
    public function __construct(
        private readonly V1RequestBuilder $v1,
        private readonly GuzzleRequestAdapter $adapter,
    ) {}

    /**
     * Live visual-recording sub-client for a session.
     * Reaches /v1/recordings/{session_id}/visual/{start,stop,frames} + the envelope.
     */
    public function visual(string $sessionId): RecordingsVisualClient
    {
        return new RecordingsVisualClient($this->adapter, $sessionId);
    }

    /**
     * Convenience live-view helper — one snapshot of a session's visual frames
     * (mirrors {@see RecordingsVisualClient::watch()}).
     *
     * @return array<string, mixed>
     */
    public function watch(string $sessionId, int $limit = 100): array
    {
        return $this->visual($sessionId)->watch($limit);
    }

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
        if (is_object($value) && method_exists($value, 'getAdditionalData')) {
            $data = $value->getAdditionalData();
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }
}

/**
 * Shared authenticated-request seam over the canonical Kiota {@see GuzzleRequestAdapter}.
 *
 * Routes an ad-hoc JSON request (Bearer token + base URL + branded UA + transport all
 * come from the SAME adapter the generated V1 builders use) for the customer routes that
 * have no generated builder — the PHP analog of java's `rawJsonRequest` / ruby's
 * `json_request!`. Every facade sub-client (cdp/page/downloads/storage-states/visual and
 * the sessions/webhooks/crawl-runs lifecycle extensions) delegates here rather than opening
 * a raw HTTP client, satisfying FACADE-PATTERN MANDATORY DELEGATION.
 *
 * @internal
 */
final class AdapterRequest
{
    /**
     * Issue `$method $path` through the canonical adapter and return the decoded body.
     *
     * @param array<string, mixed>|null $body JSON body (omitted for null / GET).
     * @return array<string, mixed>
     */
    public static function json(
        GuzzleRequestAdapter $adapter,
        string $method,
        string $path,
        ?array $body = null,
    ): array {
        $ri = new \Microsoft\Kiota\Abstractions\RequestInformation();
        $ri->urlTemplate = '{+baseurl}' . $path;
        $ri->pathParameters = ['baseurl' => $adapter->getBaseUrl()];
        $ri->httpMethod = $method;
        $ri->tryAddHeader('Accept', 'application/json');
        if ($body !== null && $method !== 'GET') {
            // Attach the exact JSON object as a raw PSR-7 stream (not a Kiota-serialized
            // scalar, which would double-encode) — the canonical way to carry an arbitrary
            // JSON body for an unbuilt route while still riding the authenticated adapter.
            $ri->setStreamContent(
                \GuzzleHttp\Psr7\Utils::streamFor((string) json_encode($body)),
                'application/json'
            );
        }
        $result = ErrorMapper::wait(
            $adapter->sendPrimitiveAsync($ri, \Psr\Http\Message\StreamInterface::class, null)
        );
        return ResponseHelper::toArray($result);
    }

    /**
     * Append a query string built from non-null params to a path.
     *
     * @param array<string, mixed> $params
     */
    public static function withQuery(string $path, array $params): string
    {
        $filtered = array_filter($params, static fn ($v) => $v !== null);
        if ($filtered === []) {
            return $path;
        }
        return $path . '?' . http_build_query($filtered);
    }
}

// ---------------------------------------------------------------------------
// First-class low-level sub-clients (cdp/page/downloads/storage-states/visual)
//
// Each closes a family of the coverage matrix by exposing every customer route
// as a first-class method delegating through the shared authenticated adapter
// (AdapterRequest::json) — no raw HTTP. cdp/* and page/* are first-class customer
// surface.
// ---------------------------------------------------------------------------

/**
 * Low-level CDP primitives for a live session — /v1/cdp.
 */
final class CdpClient
{
    public function __construct(private readonly GuzzleRequestAdapter $adapter) {}

    /**
     * Drive a CDP `frame` command against the live page (POST /v1/cdp/frame).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function frame(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/cdp/frame', $params);
    }

    /**
     * Navigate / read the live page URL over CDP (POST /v1/cdp/url).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function url(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/cdp/url', $params);
    }

    /**
     * Dispatch a CDP `Input` event to the live page (POST /v1/cdp/input).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function input(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/cdp/input', $params);
    }
}

/**
 * High-level page primitives for a live session — /v1/page.
 */
final class PageClient
{
    public function __construct(private readonly GuzzleRequestAdapter $adapter) {}

    /**
     * Read cookies from the live page (GET /v1/page/cookies).
     *
     * @return array<string, mixed>
     */
    public function getCookies(): array
    {
        return AdapterRequest::json($this->adapter, 'GET', '/v1/page/cookies');
    }

    /**
     * Set cookies on the live page (POST /v1/page/cookies).
     *
     * @param list<array<string, mixed>> $cookies
     * @param array<string, mixed>       $extra
     * @return array<string, mixed>
     */
    public function setCookies(array $cookies, array $extra = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/cookies', array_merge(['cookies' => $cookies], $extra));
    }

    /**
     * Delete cookies from the live page (DELETE /v1/page/cookies).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function deleteCookies(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'DELETE', '/v1/page/cookies', $params ?: null);
    }

    /**
     * Capture a DOM snapshot of the live page (POST /v1/page/dom_snapshot).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function domSnapshot(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/dom_snapshot', $params);
    }

    /**
     * Trigger / capture a file download on the live page (POST /v1/page/download).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function download(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/download', $params);
    }

    /**
     * Evaluate an expression in the live page context (POST /v1/page/eval).
     *
     * @param array<string, mixed> $extra
     * @return array<string, mixed>
     */
    public function eval(string $expression, array $extra = []): array
    {
        // §0.6 facade-drift fix: the API EvalBody field is `script`, NOT `expression`
        // (the SDK surface contract / page_routes.py EvalBody). The method arg
        // stays $expression for ergonomics; the wire body must send `script`.
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/eval', array_merge(['script' => $expression], $extra));
    }

    /**
     * Capture the live page's network HAR log (POST /v1/page/har).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function har(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/har', $params);
    }

    /**
     * Scroll the live page (POST /v1/page/scroll).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function scroll(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/scroll', $params);
    }

    /**
     * Attach a file to a file input on the live page (POST /v1/page/upload).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function upload(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/upload', $params);
    }

    /**
     * Wait for a condition on the live page (POST /v1/page/wait).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function wait(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/wait', $params);
    }

    /**
     * Replay a mouse op-stream on the live page (POST /v1/page/mouse).
     *
     * $ops is an ordered list of {"kind":"move|down|up|wheel|dwell", ...} driven natively
     * on the live page — engine-agnostic.
     */
    public function mouse(array $ops, array $extra = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/mouse', array_merge(['ops' => $ops], $extra));
    }

    /**
     * Arrive at dest_url through a native link click from source_url (POST /v1/page/arrival).
     *
     * The live page's document.referrer, Referer and Sec-Fetch-* are produced natively by
     * the click (engine-agnostic).
     */
    public function arrival(string $destUrl, string $sourceUrl, array $extra = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/arrival', array_merge(['dest_url' => $destUrl, 'source_url' => $sourceUrl], $extra));
    }

    /**
     * Open a background tab, read it, and close it (Chrome engine only) (POST /v1/page/tab-visit).
     */
    public function tabVisit(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/tab-visit', $params);
    }

    /**
     * Dismiss overlay popups on the live page (POST /v1/page/close-popups).
     */
    public function closePopups(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/close-popups', $params);
    }

    /**
     * Replay a touch op-stream on the live page (POST /v1/page/touch).
     *
     * $ops is an ordered list of native tap/gesture ops (engine-agnostic).
     */
    public function touch(array $ops, array $extra = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/page/touch', array_merge(['ops' => $ops], $extra));
    }
}

/**
 * Manage captured file downloads — /v1/downloads.
 */
final class DownloadsClient
{
    public function __construct(private readonly GuzzleRequestAdapter $adapter) {}

    /**
     * List captured downloads (GET /v1/downloads).
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        return AdapterRequest::json($this->adapter, 'GET', '/v1/downloads');
    }

    /**
     * Get a single download's metadata (GET /v1/downloads/{download_id}).
     *
     * @return array<string, mixed>
     */
    public function get(string $downloadId): array
    {
        return AdapterRequest::json($this->adapter, 'GET', '/v1/downloads/' . rawurlencode($downloadId));
    }

    /**
     * Delete a captured download (DELETE /v1/downloads/{download_id}).
     *
     * @return array<string, mixed>
     */
    public function delete(string $downloadId): array
    {
        return AdapterRequest::json($this->adapter, 'DELETE', '/v1/downloads/' . rawurlencode($downloadId));
    }
}

/**
 * Manage reusable storage states (cookies/localStorage) — /v1/storage-states.
 *
 * Exposed as the `$storageStates` sub-client. The legacy top-level
 * {@see GhostCrawlClient::storageStates()} method (a plain list) is retained for
 * back-compat alongside this property — PHP keeps property and method namespaces
 * separate, so both `$client->storageStates` and `$client->storageStates()` work.
 */
final class StorageStatesClient
{
    public function __construct(private readonly GuzzleRequestAdapter $adapter) {}

    /**
     * List saved storage states (GET /v1/storage-states).
     *
     * @return array<string, mixed>
     */
    public function list(): array
    {
        return AdapterRequest::json($this->adapter, 'GET', '/v1/storage-states');
    }

    /**
     * Attach a storage state to a profile (POST /v1/storage-states/{id_or_name}/attach).
     *
     * @return array<string, mixed>
     */
    public function attach(string $idOrName, string $profileId): array
    {
        return AdapterRequest::json(
            $this->adapter,
            'POST',
            '/v1/storage-states/' . rawurlencode($idOrName) . '/attach',
            ['profile_id' => $profileId],
        );
    }

    /**
     * Detach the storage state from a profile (POST /v1/storage-states/detach).
     *
     * @return array<string, mixed>
     */
    public function detach(string $profileId): array
    {
        return AdapterRequest::json($this->adapter, 'POST', '/v1/storage-states/detach', ['profile_id' => $profileId]);
    }
}

/**
 * Live visual-recording sub-client for a session — /v1/recordings/{session_id}/visual.
 * Reached via {@see RecordingsClient::visual()}.
 */
final class RecordingsVisualClient
{
    public function __construct(
        private readonly GuzzleRequestAdapter $adapter,
        private readonly string $sessionId,
    ) {}

    private function base(): string
    {
        return '/v1/recordings/' . rawurlencode($this->sessionId) . '/visual';
    }

    /**
     * Start a live visual recording (POST .../visual/start).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function start(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', $this->base() . '/start', $params);
    }

    /**
     * Stop the live visual recording (POST .../visual/stop).
     *
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public function stop(array $params = []): array
    {
        return AdapterRequest::json($this->adapter, 'POST', $this->base() . '/stop', $params);
    }

    /**
     * Get the visual recording envelope (GET .../visual).
     *
     * @return array<string, mixed>
     */
    public function get(): array
    {
        return AdapterRequest::json($this->adapter, 'GET', $this->base());
    }

    /**
     * List captured visual frames (GET .../visual/frames).
     *
     * @return array<string, mixed>
     */
    public function frames(int $cursor = 0, int $limit = 100): array
    {
        $path = AdapterRequest::withQuery($this->base() . '/frames', ['cursor' => $cursor, 'limit' => $limit]);
        return AdapterRequest::json($this->adapter, 'GET', $path);
    }

    /**
     * Convenience live-view helper: one snapshot of the current visual-frame set.
     * (The blocking-native PHP client returns the latest frames page rather than an
     * async stream — drive it in a loop for a continuous view.)
     *
     * @return array<string, mixed>
     */
    public function watch(int $limit = 100): array
    {
        return $this->frames(0, $limit);
    }
}

// ---------------------------------------------------------------------------
// Typed-but-array-accessible result models
//
// Every scrape/search/crawl response is wrapped in one of these OWNED types so
// the raw Kiota-generated builders NEVER reach the user surface. Each
// result implements ArrayAccess + IteratorAggregate (delegating to the decoded
// response array) so 100% of existing callers that read $result['content'] keep
// working unchanged — while new code gets discoverable, typed properties named
// for the EXACT canonical field names.
//
// Field names are shared across the GhostCrawl SDKs so results read uniformly.
// ---------------------------------------------------------------------------

/**
 * Base typed result — an array-accessible, iterable, JSON-serializable view over
 * a decoded response array. Subclasses declare the canonical lane field names as
 * typed public properties, populated from the payload on construction; the raw
 * array stays reachable by key (and any undeclared/extra server field with it).
 *
 * @implements \ArrayAccess<string, mixed>
 * @implements \IteratorAggregate<string, mixed>
 */
abstract class Result implements \ArrayAccess, \IteratorAggregate, \Countable, \JsonSerializable
{
    /** @var array<array-key, mixed> */
    protected array $data;

    /** @param array<string, mixed> $data */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * The complete decoded response array — the back-compat / undeclared-field door.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    // -- ArrayAccess (['key'] back-compat) ---------------------------------
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    // -- IteratorAggregate / Countable / JsonSerializable ------------------
    /** @return \Iterator<string, mixed> */
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    /**
     * Read a string field from a payload, or null when absent / non-string.
     *
     * @param array<string, mixed> $data
     */
    protected static function str(array $data, string $key): ?string
    {
        return isset($data[$key]) && is_string($data[$key]) ? $data[$key] : null;
    }

    /**
     * Read an int field from a payload (coercing a numeric value), or null.
     *
     * @param array<string, mixed> $data
     */
    protected static function int(array $data, string $key): ?int
    {
        return isset($data[$key]) && is_numeric($data[$key]) ? (int) $data[$key] : null;
    }

    /**
     * Read a list/array field from a payload, or null when absent / non-array.
     *
     * @param array<string, mixed> $data
     * @return array<mixed>|null
     */
    protected static function arr(array $data, string $key): ?array
    {
        return isset($data[$key]) && is_array($data[$key]) ? $data[$key] : null;
    }
}

/**
 * Result of scrape / content — category "scrape". content is the cross-format
 * alias for the rendered output (markdown/html/text), surfaced on construction.
 */
final class ScrapeResult extends Result
{
    public readonly ?string $status;
    public readonly ?string $content;
    public readonly ?string $markdown;
    public readonly ?string $html;
    public readonly ?int $status_code;
    public readonly ?int $bytes;
    public readonly ?string $url;
    public readonly ?string $format;
    /** @var array<mixed>|null */
    public readonly ?array $warnings;

    /** @param array<string, mixed> $data */
    public function __construct(array $data = [])
    {
        self::surfaceContent($data);
        parent::__construct($data);
        $this->status      = self::str($data, 'status');
        $this->content     = self::str($data, 'content');
        $this->markdown    = self::str($data, 'markdown');
        $this->html        = self::str($data, 'html');
        $this->status_code = self::int($data, 'status_code');
        $this->bytes       = self::int($data, 'bytes');
        $this->url         = self::str($data, 'url');
        $this->format      = self::str($data, 'format');
        $this->warnings    = self::arr($data, 'warnings');
    }

    /**
     * Mirror the rendered output under the canonical `content` key, in place —
     * identical semantics to {@see GhostCrawlClient::normalizeScrapeContent()},
     * so a ScrapeResult built from either scrape shape exposes ->content.
     *
     * @param array<string, mixed> $data
     */
    private static function surfaceContent(array &$data): void
    {
        if (array_key_exists('content', $data)) {
            return;
        }
        $value = null;
        $fmt = $data['format'] ?? null;
        if (is_string($fmt) && isset($data[$fmt]) && is_string($data[$fmt])) {
            $value = $data[$fmt];
        } else {
            foreach (['markdown', 'html', 'text'] as $key) {
                if (isset($data[$key]) && is_string($data[$key])) {
                    $value = $data[$key];
                    break;
                }
            }
        }
        if ($value !== null) {
            $data['content'] = $value;
        }
    }
}

/**
 * Result of search / map — category "search".
 */
final class SearchResult extends Result
{
    public readonly ?string $status;
    /** @var array<mixed>|null */
    public readonly ?array $results;
    public readonly ?string $query;

    /** @param array<string, mixed> $data */
    public function __construct(array $data = [])
    {
        if (!array_key_exists('results', $data) && isset($data['items']) && is_array($data['items'])) {
            $data['results'] = $data['items'];
        }
        // Stable shape: a cold-rotation running handle ({status:"running", job_id,
        // poll_url,...}) carries no "items"/"results". Guarantee a non-null (empty)
        // array so $result->results / $result['results'] never surprise the caller.
        // Last-line safety for ANY construction path (mirrors the Python model fix).
        if (!isset($data['results']) || !is_array($data['results'])) {
            $data['results'] = [];
        }
        parent::__construct($data);
        $this->status  = self::str($data, 'status');
        $this->results = self::arr($data, 'results');
        $this->query   = self::str($data, 'query');
    }
}

/**
 * A crawl run — category "crawl". Returned by {@see GhostCrawlClient::crawl()}.
 */
final class CrawlRun extends Result
{
    public readonly ?string $run_id;
    public readonly ?string $status;
    /** @var array<mixed>|null */
    public readonly ?array $results;

    /** @param array<string, mixed> $data */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->run_id  = self::str($data, 'run_id');
        $this->status  = self::str($data, 'status');
        $this->results = self::arr($data, 'results');
    }
}

/**
 * A single crawled/searched document — category "document".
 */
final class Document extends Result
{
    public readonly ?string $title;
    public readonly ?string $url;
    public readonly ?string $content;

    /** @param array<string, mixed> $data */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->title   = self::str($data, 'title');
        $this->url     = self::str($data, 'url');
        $this->content = self::str($data, 'content');
    }
}

/**
 * Binary lane result (pdf / screenshot) — category "pdf" / "screenshot".
 *
 * The binary methods ({@see GhostCrawlClient::pdf()} / {@see GhostCrawlClient::screenshot()})
 * return raw bytes (a string) for back-compat; this type names the shared canonical
 * fields (bytes, content_type) so the binary surface reads uniformly with the other
 * typed results across the GhostCrawl SDKs.
 */
final class BinaryResult extends Result
{
    public readonly ?string $bytes;
    public readonly ?string $content_type;

    /**
     * @param string      $bytes       Raw binary payload.
     * @param string|null $contentType Response Content-Type (e.g. application/pdf).
     */
    public function __construct(string $bytes = '', ?string $contentType = null)
    {
        parent::__construct(['bytes' => $bytes, 'content_type' => $contentType]);
        $this->bytes        = $bytes;
        $this->content_type = $contentType;
    }
}

// ---------------------------------------------------------------------------
// Search(wait) — SDK-owned bounded client-side poll
//
// Unlike crawl — whose GET /v1/crawl-runs/{id}?wait=true&timeout_s=N blocks
// SERVER-side on a completion event — the search-job contract is a CLIENT poll:
// POST /v1/search on a cold rotation returns
//
//   202 { status: "running", poll_url, deadline, poll_max_seconds, poll_terminal_on_404 }
//
// and GET {poll_url} (i.e. /v1/search/jobs/{id}) returns 202 running (with a
// Retry-After header) until a terminal 200. The SDK owns the loop so the caller
// writes zero poll code — the same wait DX crawl has, a different mechanism under
// the hood. Mirrors the Go (search_wait.go), Ruby (SearchPoll) and Python
// (_search_poll.py) references.
//
// The engine is a pure function of an injected `$get` getter (and `$sleeper`), so
// the poll contract is unit-testable with no network.
// ---------------------------------------------------------------------------

/**
 * @internal
 */
final class SearchPoll
{
    /** Terminal search-job states (mirrors the Go/Ruby/Python terminal set). */
    public const TERMINAL_STATES = ['completed', 'done', 'failed', 'cancelled', 'error'];

    /** Overall client-side wait budget (seconds) when the server gives no bound. */
    public const DEFAULT_TIMEOUT = 300;

    /** Inter-poll fallback (seconds) when the server sends no Retry-After. */
    public const DEFAULT_INTERVAL = 3;

    /**
     * True when $job is an array carrying a terminal `status`.
     *
     * @param array<string, mixed> $job
     */
    public static function isTerminal(array $job): bool
    {
        $status = $job['status'] ?? null;
        return is_string($status) && in_array($status, self::TERMINAL_STATES, true);
    }

    /**
     * Parse a Retry-After delta-seconds value to a non-negative float, or null
     * when absent/invalid. (The search-job contract advertises delta-seconds
     * only, not the HTTP-date form.)
     */
    public static function parseRetryAfter(mixed $raw): ?float
    {
        if ($raw === null) {
            return null;
        }
        $s = trim((string) $raw);
        if ($s === '' || !is_numeric($s)) {
            return null;
        }
        $f = (float) $s;
        return $f >= 0 ? $f : null;
    }

    /** Resolve a poll_url that may be absolute or base-relative. */
    public static function resolveUrl(string $baseUrl, string $pollUrl): string
    {
        if (str_starts_with($pollUrl, 'http://') || str_starts_with($pollUrl, 'https://')) {
            return $pollUrl;
        }
        return rtrim($baseUrl, '/') . '/' . ltrim($pollUrl, '/');
    }

    /**
     * Bounded-poll a cold search job to a terminal result.
     *
     * Copies the STRUCTURE of {@see CrawlRunsClient::waitForCompletion()} (deadline
     * + re-arm loop) but implements the client-poll contract: follows poll_url from
     * the 202 body, honours Retry-After between polls bounded by poll_max_seconds /
     * an explicit $timeout / {@see DEFAULT_TIMEOUT}, treats a terminal 200 (or a
     * terminal-status body) as done, treats 404 as terminal when poll_terminal_on_404
     * (default true), and returns the latest non-terminal record if the deadline
     * elapses first. When the job carries no poll_url there is nothing to poll and
     * the initial body is returned unchanged (warm path).
     *
     * @param array<string, mixed> $job          The initial (202) job body.
     * @param string               $baseUrl      Client base URL (to resolve a relative poll_url).
     * @param callable(string): array{0:int,1:array<string,mixed>,2:array<string,mixed>} $get
     *                                            One poll GET → [status, headers, body].
     * @param int|null             $timeout      Overall client-side wait budget (seconds).
     * @param float|null           $initialRetry First inter-poll delay (from the 202's Retry-After).
     * @param callable(float): void|null $sleeper Delay hook (injectable for tests).
     * @return array<string, mixed> The terminal job body (or the latest non-terminal on timeout).
     */
    public static function pollSearchJob(
        array $job,
        string $baseUrl,
        callable $get,
        ?int $timeout = null,
        ?float $initialRetry = null,
        ?callable $sleeper = null,
    ): array {
        $pollUrl = $job['poll_url'] ?? null;
        if (!is_string($pollUrl) || $pollUrl === '') {
            return $job;
        }

        $url = self::resolveUrl($baseUrl, $pollUrl);
        $budget = (float) ($timeout ?? $job['poll_max_seconds'] ?? self::DEFAULT_TIMEOUT);
        $terminalOn404 = array_key_exists('poll_terminal_on_404', $job)
            ? (bool) $job['poll_terminal_on_404']
            : true;
        $sleeper ??= static function (float $seconds): void {
            if ($seconds > 0) {
                usleep((int) ($seconds * 1_000_000));
            }
        };

        $deadline = microtime(true) + $budget;
        $retryAfter = (float) ($initialRetry ?? self::DEFAULT_INTERVAL);
        $latest = $job;

        while (true) {
            $remaining = $deadline - microtime(true);
            if ($remaining <= 0) {
                return $latest;
            }

            $delay = min($retryAfter, $remaining);
            if ($delay > 0) {
                $sleeper($delay);
            }
            if (microtime(true) > $deadline) {
                return $latest;
            }

            [$status, $headers, $data] = $get($url);

            if ($status === 404) {
                if ($terminalOn404) {
                    ErrorMapper::raiseStatus(404, 'search job not found', (string) json_encode($data));
                }
                return $latest;
            }
            if ($status >= 400) {
                ErrorMapper::raiseStatus($status, 'search poll failed', (string) json_encode($data));
            }

            if ($status === 200 || self::isTerminal($data)) {
                return $data;
            }

            if ($data !== []) {
                $latest = $data;
            }
            $ra = self::parseRetryAfter($headers['Retry-After'] ?? $headers['retry-after'] ?? null);
            if ($ra !== null) {
                $retryAfter = $ra;
            }
        }
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

    /** SDK package version — dev fallback for the branded UA when Composer metadata is absent. */
    public const VERSION = '2.3.8';

    /**
     * Default overall request timeout (seconds). Guzzle's own default is 0 =
     * "wait forever", which hangs the caller on a stalled socket or dead proxy;
     * a finite default is the single most important reliability guard. Matches
     * the Kiota default the sibling SDKs use.
     */
    public const DEFAULT_TIMEOUT_SECONDS = 100.0;

    /**
     * Default connection-establishment timeout (seconds) — bounds the TCP/TLS
     * handshake so an unreachable host fails fast instead of hanging.
     */
    public const DEFAULT_CONNECT_TIMEOUT_SECONDS = 10.0;

    private readonly V1RequestBuilder $v1;
    private readonly GuzzleRequestAdapter $adapter;
    private readonly string $token;
    private readonly float $timeout;
    private readonly float $connectTimeout;

    public readonly CrawlRunsClient     $crawlRuns;
    public readonly SessionsClient      $sessions;
    public readonly ProfilesClient      $profiles;
    public readonly WebhooksClient      $webhooks;
    public readonly SchedulesClient     $schedules;
    public readonly DatasetsClient      $datasets;
    public readonly RecordingsClient    $recordings;
    public readonly KVClient            $kv;
    public readonly CdpClient           $cdp;
    public readonly PageClient          $page;
    public readonly DownloadsClient     $downloads;
    public readonly StorageStatesClient $storageStates;

    /**
     * @param string|null $token          API key. Falls back to GHOSTCRAWL_API_KEY env var.
     * @param string|null $baseUrl        Override API base URL. Falls back to GHOSTCRAWL_BASE_URL.
     * @param float|null  $timeout        Overall per-request timeout in seconds. Null uses
     *                                    {@see DEFAULT_TIMEOUT_SECONDS} (100s). 0 disables the
     *                                    bound (wait forever) — not recommended.
     * @param float|null  $connectTimeout Connection-establishment timeout in seconds. Null uses
     *                                    {@see DEFAULT_CONNECT_TIMEOUT_SECONDS} (10s).
     */
    public function __construct(
        ?string $token = null,
        ?string $baseUrl = null,
        ?float $timeout = null,
        ?float $connectTimeout = null,
    ) {
        $resolved = $token ?? (getenv('GHOSTCRAWL_API_KEY') ?: null);
        if (empty($resolved)) {
            throw new \InvalidArgumentException(
                'token is required — pass it to GhostCrawlClient or set GHOSTCRAWL_API_KEY. '
                . 'Get your key at https://ghostcrawl.io'
            );
        }

        $this->token = $resolved;
        $this->timeout = $timeout ?? self::DEFAULT_TIMEOUT_SECONDS;
        $this->connectTimeout = $connectTimeout ?? self::DEFAULT_CONNECT_TIMEOUT_SECONDS;

        $envBase    = getenv('GHOSTCRAWL_BASE_URL') ?: null;
        $resolvedBase = rtrim($baseUrl ?? $envBase ?? self::DEFAULT_BASE_URL, '/');

        // Build the Kiota core: BaseBearerTokenAuthenticationProvider + GuzzleRequestAdapter.
        // All HTTP, auth, serialization, and URL routing delegate to the generated V1 builders.
        $authProvider = new BaseBearerTokenAuthenticationProvider(
            new StaticTokenProvider($resolved)
        );
        // Branded User-Agent: register the Kiota UserAgentHandler middleware
        // with a `ghostcrawl-php/<version>` product token at adapter construction, so every
        // request the generated builders (and the shared AdapterRequest seam) send carries
        // `User-Agent: ghostcrawl-php/<version>`. This is Kiota middleware, NOT a hand-rolled
        // per-request header.
        $uaOption = new UserAgentHandlerOption();
        $uaOption->setProductName('ghostcrawl-php');
        $uaOption->setProductVersion(self::sdkVersion());
        $handlerStack = KiotaClientFactory::getDefaultHandlerStack();
        $handlerStack->remove(UserAgentHandler::HANDLER_NAME);
        $handlerStack->push(KiotaMiddleware::userAgent($uaOption), UserAgentHandler::HANDLER_NAME);
        // Construct the Guzzle client directly (KiotaClientFactory::createWithMiddleware
        // takes no config) so we can pin finite connect/read timeouts — Guzzle's default
        // is 0 = wait forever, which hangs the caller on a stalled socket or dead proxy.
        $httpClient = new \GuzzleHttp\Client([
            'handler'                            => $handlerStack,
            \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => $this->connectTimeout,
            \GuzzleHttp\RequestOptions::TIMEOUT         => $this->timeout,
        ]);

        $adapter = new GuzzleRequestAdapter($authProvider, null, null, $httpClient);
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

        $this->crawlRuns     = new CrawlRunsClient($this->v1, $resolvedBase, $adapter);
        $this->sessions      = new SessionsClient($this->v1, $adapter);
        $this->profiles      = new ProfilesClient($this->v1);
        $this->webhooks      = new WebhooksClient($this->v1, $adapter);
        $this->schedules     = new SchedulesClient($this->v1);
        $this->datasets      = new DatasetsClient($this->v1);
        $this->recordings    = new RecordingsClient($this->v1, $adapter);
        $this->kv            = new KVClient($this->v1);
        $this->cdp           = new CdpClient($adapter);
        $this->page          = new PageClient($adapter);
        $this->downloads     = new DownloadsClient($adapter);
        $this->storageStates = new StorageStatesClient($adapter);
    }

    /**
     * Resolve the SDK package version for the branded User-Agent.
     *
     * Reads the installed Composer version of `ghostcrawl/ghostcrawl` when available,
     * falling back to the {@see VERSION} literal (kept in lock-step with the product
     * version by check_version_stamp.sh) in a dev/source checkout.
     */
    private static function sdkVersion(): string
    {
        if (class_exists(\Composer\InstalledVersions::class)) {
            try {
                $v = \Composer\InstalledVersions::getPrettyVersion('ghostcrawl/ghostcrawl');
                if (is_string($v) && $v !== '') {
                    return ltrim($v, 'v');
                }
            } catch (\Throwable) {
                // fall through to the literal below
            }
        }
        return self::VERSION;
    }

    /**
     * Named-constructor alias for the idiomatic blocking client (). PHP is
     * blocking-native: this ONE client is the intended, first-class shape — there
     * is deliberately no async twin. For concurrency, drive several instances (or
     * calls) with Guzzle async promises / sequential batching (see README).
     *
     * @param string|null $token          API key. Falls back to GHOSTCRAWL_API_KEY env var.
     * @param string|null $baseUrl        Override API base URL. Falls back to GHOSTCRAWL_BASE_URL.
     * @param float|null  $timeout        Overall per-request timeout in seconds (null = default 100s).
     * @param float|null  $connectTimeout Connection-establishment timeout in seconds (null = default 10s).
     */
    public static function create(
        ?string $token = null,
        ?string $baseUrl = null,
        ?float $timeout = null,
        ?float $connectTimeout = null,
    ): self {
        return new GhostCrawlClient($token, $baseUrl, $timeout, $connectTimeout);
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
     * @param array<string, mixed>|null $extractSchema JSON Schema for structured extraction.
     * @param array<string, mixed>      $extra         Additional request fields.
     * @param bool        $raiseOnResultError Throw a {@see ScrapeError} when the
     *                                        result reports a target-side failure
     *                                        (default true).
     * @return ScrapeResult Typed result (array-accessible: $result['content'] and
     *                       $result->content both work).
     */
    public function scrape(
        string $url,
        string $format = 'markdown',
        string $engine = 'auto',
        bool $javascript = true,
        ?array $extractSchema = null,
        array $extra = [],
        bool $raiseOnResultError = true
    ): ScrapeResult {
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
        return new ScrapeResult($this->normalizeScrapeContent($array));
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
     * On a WARM rotation the results come back synchronously (HTTP 200, no poll
     * handle) and are returned immediately. On a COLD rotation the POST returns a
     * non-terminal job carrying a `poll_url`; with `$wait = true` (the default,
     * matching crawl's wait DX) the SDK owns a bounded client-side poll of
     * /v1/search/jobs/{id} to a terminal result — honouring Retry-After and the
     * deadline — so the caller writes zero poll code. Pass `$wait = false`
     * to get the raw job handle back and poll it yourself.
     *
     * @param string      $query       Search query.
     * @param string      $engine      Search engine: "google" (default), "bing", "duckduckgo".
     * @param int         $limit       Maximum results (default 10).
     * @param array<string, mixed> $extra Additional request fields.
     * @param string|null $providerKey BYO search-backend key (sent as X-Provider-Authorization).
     * @param bool        $wait        Block until the cold-rotation job is terminal (default true).
     * @param int|null    $timeout     Overall client-side wait budget in seconds when $wait
     *                                  (default: the server's poll_max_seconds, else 300).
     * @return SearchResult Typed result (array-accessible: $result['results'] and
     *                       $result->results both work).
     */
    public function search(
        string $query,
        string $engine = 'google',
        int $limit = 10,
        array $extra = [],
        ?string $providerKey = null,
        bool $wait = true,
        ?int $timeout = null,
    ): SearchResult {
        $body = new \GhostCrawl\Models\SearchRequest();
        $body->setAdditionalData(array_merge(['query' => $query, 'engine' => $engine, 'limit' => $limit], $extra));
        $config = null;
        if ($providerKey !== null) {
            $config = new \GhostCrawl\V1\Search\SearchRequestBuilderPostRequestConfiguration(
                ['X-Provider-Authorization' => 'Bearer ' . $providerKey]
            );
        }
        $result = ErrorMapper::wait($this->v1->search()->post($body, $config));
        $job = ResponseHelper::toArray($result);

        // Warm path: results returned synchronously (no cold-rotation poll handle).
        $pollUrl = $job['poll_url'] ?? null;
        if (!$wait || !is_string($pollUrl) || $pollUrl === '') {
            return new SearchResult($this->finalizeSearch($job, $query, $engine));
        }

        // Cold path: SDK-owned bounded client-side poll to a terminal result.
        $terminal = SearchPoll::pollSearchJob(
            $job,
            $this->adapter->getBaseUrl(),
            $this->searchPollGetter($providerKey),
            $timeout,
        );
        // A timed-out poll returns the raw running handle (no "query"); finalize
        // re-injects the caller's query/engine so every search return carries a
        // STABLE shape (warm 200, wait=false handle, timed-out poll).
        return new SearchResult($this->finalizeSearch($terminal, $query, $engine));
    }

    /**
     * Guarantee a stable `search` result shape: alias `items` -> `results`
     * (default `[]`), inject the caller's `query` when the payload omits it (only
     * the SDK knows it — a bare running handle has none), and default `engine`.
     * Mirrors the Python `_finalize_search` facade helper; {@see SearchResult}
     * adds the final non-null `results` guarantee.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function finalizeSearch(array $data, string $query, string $engine): array
    {
        if (!isset($data['results']) || !is_array($data['results'])) {
            $data['results'] = (isset($data['items']) && is_array($data['items'])) ? $data['items'] : [];
        }
        // isset() is already false for a null value, so an explicit `=== null` here is
        // dead (phpstan identical.alwaysFalse); the empty-string check is the only extra case.
        if (!isset($data['query']) || $data['query'] === '') {
            $data['query'] = $query;
        }
        if (!array_key_exists('engine', $data)) {
            $data['engine'] = $engine;
        }
        return $data;
    }

    /**
     * Build the one-GET poll getter handed to {@see SearchPoll::pollSearchJob()}.
     *
     * Returns a `fn(string $url): array{0:int,1:array,2:array}` = [status, headers,
     * body] that issues a single poll of /v1/search/jobs/{id} carrying the same
     * Bearer token (and optional BYO provider key) as the modeled calls. The poll
     * leg needs the raw HTTP status + Retry-After header — which the generated
     * body-only builder path does not surface — so it uses a direct Guzzle GET
     * against the resolved poll_url. This mirrors the Go reference's net/http poll
     * (search_wait.go) and is the sole, documented departure from the generated
     * core, isolated to this read-only poll seam.
     */
    private function searchPollGetter(?string $providerKey): callable
    {
        $token = $this->token;
        $timeout = $this->timeout;
        $connectTimeout = $this->connectTimeout;
        return static function (string $url) use ($token, $providerKey, $timeout, $connectTimeout): array {
            // Finite timeouts here too — a poll GET against a stalled poll_url must
            // fail fast rather than hang the wait loop forever (Guzzle default is 0).
            $client = new \GuzzleHttp\Client([
                'http_errors'                               => false,
                \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => $connectTimeout,
                \GuzzleHttp\RequestOptions::TIMEOUT         => $timeout,
            ]);
            $headers = [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ];
            if ($providerKey !== null) {
                $headers['X-Provider-Authorization'] = 'Bearer ' . $providerKey;
            }
            $resp = $client->get($url, ['headers' => $headers]);
            $status = $resp->getStatusCode();
            $hdrs = [];
            foreach ($resp->getHeaders() as $name => $values) {
                $hdrs[$name] = $values[0] ?? '';
            }
            $decoded = json_decode((string) $resp->getBody(), true);
            return [$status, $hdrs, is_array($decoded) ? $decoded : []];
        };
    }

    /**
     * Extract structured data from a URL using a JSON Schema.
     * Delegates to POST /v1/extract via the generated ExtractRequestBuilder.
     *
     * @param string $url                 Target URL.
     * @param array<string, mixed> $schema JSON Schema describing the shape to extract.
     * @param array<string, mixed> $extra  Additional request fields.
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
     * @param array<string, mixed> $extra Additional request fields.
     * @param bool   $raiseOnResultError  Throw a {@see ScrapeError} when the result
     *                                     reports a target-side failure (default true).
     * @return CrawlRun Typed result (array-accessible: $run['run_id'] and
     *                   $run->run_id both work).
     */
    public function crawl(string $url, int $maxDepth = 2, int $maxPages = 100, array $extra = [], bool $raiseOnResultError = true): CrawlRun
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
        return new CrawlRun($array);
    }

    /**
     * Map all URLs reachable from a seed URL.
     * Delegates to POST /v1/map via the generated MapRequestBuilder.
     *
     * @param string $url   Seed URL.
     * @param array<string, mixed> $extra Additional request fields.
     * @return SearchResult Typed result (category "search"; array-accessible —
     *                       $result['results'] and $result->results both work).
     */
    public function map(string $url, array $extra = []): SearchResult
    {
        $body = new \GhostCrawl\Models\MapBody();
        $body->setAdditionalData(array_merge(['url' => $url], $extra));
        $result = ErrorMapper::wait($this->v1->map()->post($body));
        $arr = ResponseHelper::toArray($result);
        if (!isset($arr['results']) && isset($arr['links']) && is_array($arr['links'])) {
            $arr['results'] = $arr['links'];
        }
        return new SearchResult($arr);
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
     * @return ScrapeResult The rendered-content envelope (category "scrape";
     *                       array-accessible — $result['content'] and $result->content
     *                       both work).
     */
    public function content(string $url, array $extra = []): ScrapeResult
    {
        $body = array_merge(['url' => $url], $extra);
        return new ScrapeResult($this->sendJson('POST', '/v1/content', $body));
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
     * Get the authenticated account (GET /v1/me).
     * Routed through the canonical Kiota adapter (auth + base URL + branded UA).
     *
     * @return array<string, mixed>
     */
    public function me(): array
    {
        return $this->sendJson('GET', '/v1/me', null);
    }

    /**
     * Get the account's cost/usage report — the quota-visibility surface (GET /v1/me/usage).
     *
     * @param string|null $period Reporting window: "day" | "week" | "month" (server default when null).
     * @return array<string, mixed>
     */
    public function usage(?string $period = null): array
    {
        $path = AdapterRequest::withQuery('/v1/me/usage', ['period' => $period]);
        return $this->sendJson('GET', $path, null);
    }

    /**
     * Get the customer-safe persona for a running session
     * (GET /v1/me/identities/{session_id}/persona).
     *
     * Who a given session is, shaped for display: a whitelist of device_class /
     * os_class / browser_class / locale only — never a raw user-agent or any
     * internal detail. Session-scoped, distinct from the account-level me().
     * An unknown session yields a not-found error.
     *
     * @return array<string, mixed>
     */
    public function sessionPersona(string $sessionId): array
    {
        $path = '/v1/me/identities/' . rawurlencode($sessionId) . '/persona';
        return $this->sendJson('GET', $path, null);
    }

    /**
     * Scrape a batch of URLs in one call (POST /v1/scrape/batch).
     *
     * @param list<string>         $urls   Target URLs.
     * @param array<string, mixed> $params Additional request fields (format, engine, …).
     * @return array<string, mixed>
     */
    public function scrapeBatch(array $urls, array $params = []): array
    {
        return $this->sendJson('POST', '/v1/scrape/batch', array_merge(['urls' => $urls], $params));
    }

    /**
     * Fetch a search job by id (GET /v1/search/jobs/{job_id}) — the manual poll handle
     * for a cold-rotation search started with `search(..., wait: false)`.
     *
     * @return SearchResult Typed result (array-accessible — $r['results'] and $r->results).
     */
    public function searchJob(string $jobId): SearchResult
    {
        return new SearchResult($this->sendJson('GET', '/v1/search/jobs/' . rawurlencode($jobId), null));
    }

    /**
     * Get the status of a deep crawl run (GET /v1/crawl/deep/{run_id}).
     *
     * @return array<string, mixed>
     */
    public function crawlStatus(string $runId): array
    {
        return $this->sendJson('GET', '/v1/crawl/deep/' . rawurlencode($runId), null);
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
     * @param array<mixed>|null         $steps Optional explicit step list.
     * @param array<string, mixed>|null $task  Optional structured task object.
     * @param array<string, mixed>      $extra Additional request fields.
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
