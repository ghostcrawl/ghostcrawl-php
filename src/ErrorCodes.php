<?php

declare(strict_types=1);

namespace GhostCrawl;

/**
 * Canonical GhostCrawl error code catalog.
 *
 * Mirrors ghostcrawl/errors/codes.json (the single source of truth). Do not
 * hand-diverge the set.
 *
 * Two channels:
 *  - PROBLEM ("our failure"): surfaced as a non-2xx application/problem+json
 *    response; mapped to a {@see GhostCrawlError} subclass.
 *  - RESULT ("target failure"): surfaced inside an HTTP 200 result object with
 *    `ok: false` and `result_error`; mapped to {@see ScrapeError}.
 *
 * Each catalog entry records the canonical HTTP status, whether a retry is
 * worthwhile, and which channel the code belongs to.
 */
final class ErrorCodes
{
    // --- PROBLEM channel (our failure -> non-2xx problem+json) ------------

    public const BAD_REQUEST               = 'bad_request';
    public const UNAUTHORIZED              = 'unauthorized';
    public const FORBIDDEN                 = 'forbidden';
    public const PAYMENT_REQUIRED          = 'payment_required';
    public const NOT_FOUND                 = 'not_found';
    public const CONFLICT                  = 'conflict';
    public const BYO_PROXY_INVALID         = 'byo_proxy_invalid';
    public const TIER_UNAVAILABLE          = 'tier_unavailable';
    public const RATE_LIMITED              = 'rate_limited';
    public const QUOTA_BACKEND_UNAVAILABLE = 'quota_backend_unavailable';
    public const POOL_EXHAUSTED            = 'pool_exhausted';
    public const EGRESS_INTEGRITY_FAILED   = 'egress_integrity_failed';
    public const RENDER_HUNG               = 'render_hung';
    public const ENGINE_CRASHED            = 'engine_crashed';
    public const RENDER_TIMEOUT            = 'render_timeout';
    public const ENGINE_TIMEOUT             = 'engine_timeout';
    public const SERVICE_UNAVAILABLE       = 'service_unavailable';
    public const INTERNAL_ERROR            = 'internal_error';

    // --- RESULT channel (target failure -> HTTP 200 + result_error) ------

    public const TARGET_HTTP_ERROR = 'target_http_error';
    public const NAVIGATION_FAILED = 'navigation_failed';
    public const BLOCKED           = 'blocked';
    public const CAPTCHA_REQUIRED  = 'captcha_required';
    public const EMPTY_CONTENT     = 'empty_content';

    /**
     * Canonical catalog, keyed by code.
     *
     * Each entry: ['http' => int, 'retryable' => bool, 'channel' => 'problem'|'result'].
     *
     * @var array<string, array{http: int, retryable: bool, channel: string}>
     */
    public const CATALOG = [
        // PROBLEM channel
        self::BAD_REQUEST               => ['http' => 400, 'retryable' => false, 'channel' => 'problem'],
        self::UNAUTHORIZED              => ['http' => 401, 'retryable' => false, 'channel' => 'problem'],
        self::FORBIDDEN                 => ['http' => 403, 'retryable' => false, 'channel' => 'problem'],
        self::PAYMENT_REQUIRED          => ['http' => 402, 'retryable' => false, 'channel' => 'problem'],
        self::NOT_FOUND                 => ['http' => 404, 'retryable' => false, 'channel' => 'problem'],
        self::CONFLICT                  => ['http' => 409, 'retryable' => false, 'channel' => 'problem'],
        self::BYO_PROXY_INVALID         => ['http' => 422, 'retryable' => false, 'channel' => 'problem'],
        self::TIER_UNAVAILABLE          => ['http' => 400, 'retryable' => false, 'channel' => 'problem'],
        self::RATE_LIMITED              => ['http' => 429, 'retryable' => true,  'channel' => 'problem'],
        self::QUOTA_BACKEND_UNAVAILABLE => ['http' => 503, 'retryable' => true,  'channel' => 'problem'],
        self::POOL_EXHAUSTED            => ['http' => 503, 'retryable' => true,  'channel' => 'problem'],
        self::EGRESS_INTEGRITY_FAILED   => ['http' => 503, 'retryable' => true,  'channel' => 'problem'],
        self::RENDER_HUNG               => ['http' => 503, 'retryable' => true,  'channel' => 'problem'],
        self::ENGINE_CRASHED            => ['http' => 503, 'retryable' => true,  'channel' => 'problem'],
        self::RENDER_TIMEOUT            => ['http' => 504, 'retryable' => true,  'channel' => 'problem'],
        self::ENGINE_TIMEOUT             => ['http' => 504, 'retryable' => true,  'channel' => 'problem'],
        self::SERVICE_UNAVAILABLE       => ['http' => 503, 'retryable' => true,  'channel' => 'problem'],
        self::INTERNAL_ERROR            => ['http' => 500, 'retryable' => true,  'channel' => 'problem'],

        // RESULT channel
        self::TARGET_HTTP_ERROR => ['http' => 200, 'retryable' => false, 'channel' => 'result'],
        self::NAVIGATION_FAILED => ['http' => 200, 'retryable' => false, 'channel' => 'result'],
        self::BLOCKED           => ['http' => 200, 'retryable' => true,  'channel' => 'result'],
        self::CAPTCHA_REQUIRED  => ['http' => 200, 'retryable' => true,  'channel' => 'result'],
        self::EMPTY_CONTENT     => ['http' => 200, 'retryable' => false, 'channel' => 'result'],
    ];

    /**
     * Whether a retry is worthwhile for the given canonical code.
     *
     * Unknown codes are treated as non-retryable.
     */
    public static function retryable(string $code): bool
    {
        return self::CATALOG[$code]['retryable'] ?? false;
    }

    /**
     * Map an HTTP status code to the canonical PROBLEM-channel code.
     *
     * Used as the fallback when a non-2xx response body carries no `code`.
     */
    public static function codeForStatus(int $status): string
    {
        return match (true) {
            $status === 400 => self::BAD_REQUEST,
            $status === 401 => self::UNAUTHORIZED,
            $status === 402 => self::PAYMENT_REQUIRED,
            $status === 403 => self::FORBIDDEN,
            $status === 404 => self::NOT_FOUND,
            $status === 409 => self::CONFLICT,
            // 422 is the generic request-validation status; the API's default
            // 422 code is `bad_request`. `byo_proxy_invalid` is a *specific*
            // 422 that arrives with its own `code` in the body, so it must not
            // be the fallback default (that mislabels every other 422).
            $status === 422 => self::BAD_REQUEST,
            $status === 429 => self::RATE_LIMITED,
            $status === 503 => self::SERVICE_UNAVAILABLE,
            $status === 504 => self::ENGINE_TIMEOUT,
            $status >= 500  => self::INTERNAL_ERROR,
            default         => self::BAD_REQUEST,
        };
    }

    /**
     * Whether the given code belongs to the RESULT channel (target failure
     * surfaced inside an HTTP 200 result object).
     */
    public static function isResultCode(string $code): bool
    {
        return (self::CATALOG[$code]['channel'] ?? null) === 'result';
    }
}
