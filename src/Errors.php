<?php

declare(strict_types=1);

namespace GhostCrawl;

/**
 * Base error for all GhostCrawl API errors.
 *
 * Carries the canonical error code (see {@see ErrorCodes}), whether a retry is
 * worthwhile, and the request id (from the problem+json `instance` field, echoed
 * by the API for support correlation).
 *
 * The canonical code is read via the `$code` property (e.g. `$e->code`). It is
 * backed by {@see $errorCode} and surfaced through a magic accessor: PHP's base
 * \Exception already declares a (protected, mutable, int) `$code` slot which
 * cannot be redeclared as a readonly string, so `$e->code` is served via
 * {@see __get()} rather than a clashing property declaration.
 *
 * @property-read string|null $code Canonical error code (see {@see ErrorCodes}), if known.
 */
class GhostCrawlError extends \RuntimeException
{
    /** @var int HTTP status code */
    public readonly int $statusCode;

    /** @var string Raw response body */
    public readonly string $body;

    /**
     * Canonical error code (see {@see ErrorCodes}), if known.
     *
     * Backing field for the `$code` property; read it as `$e->code`.
     *
     * @var string|null
     */
    public readonly ?string $errorCode;

    /** @var bool Whether retrying the request is worthwhile. */
    public readonly bool $retryable;

    /** @var string|null Request id for support correlation (problem+json `instance`). */
    public readonly ?string $requestId;

    public function __construct(
        string $message,
        int $statusCode = 0,
        string $body = '',
        ?string $code = null,
        bool $retryable = false,
        ?string $requestId = null,
    ) {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->body       = $body;
        $this->errorCode  = $code;
        $this->retryable  = $retryable;
        $this->requestId  = $requestId;
    }

    /**
     * Expose the canonical code as `$e->code` without colliding with the
     * inherited \Exception::$code slot.
     */
    public function __get(string $name): mixed
    {
        if ($name === 'code') {
            return $this->errorCode;
        }
        // Preserve normal "undefined property" semantics for anything else.
        trigger_error(
            'Undefined property: ' . static::class . '::$' . $name,
            \E_USER_WARNING
        );
        return null;
    }

    public function __isset(string $name): bool
    {
        return $name === 'code' && $this->errorCode !== null;
    }
}

/** Raised on 401 — missing or invalid API key. */
class AuthenticationError extends GhostCrawlError {}

/** Raised on 402 — usage or spend limit reached. */
class PaymentRequiredError extends GhostCrawlError {}

/** Raised on 422 — bad request parameters. */
class InvalidRequestError extends GhostCrawlError {}

/** Raised on 429 — rate limit reached. */
class RateLimitError extends GhostCrawlError {}

/** Raised on 5xx server errors. */
class APIError extends GhostCrawlError {}

/**
 * Raised when a successful (HTTP 200) request reports a target-side failure in
 * its result body — the RESULT channel.
 *
 * These are not failures of the GhostCrawl API itself but of the target site:
 * it returned an HTTP error, could not be reached, blocked the request,
 * presented a CAPTCHA, or yielded no extractable content. The {@see $code} is a
 * RESULT-channel code (see {@see ErrorCodes::isResultCode()}); {@see $targetStatus}
 * carries the target's HTTP status when the failure was an upstream HTTP error.
 */
class ScrapeError extends GhostCrawlError
{
    /** @var int|null The target site's HTTP status, when the failure was an upstream HTTP error. */
    public readonly ?int $targetStatus;

    public function __construct(
        string $message,
        int $statusCode = 200,
        string $body = '',
        ?string $code = null,
        bool $retryable = false,
        ?string $requestId = null,
        ?int $targetStatus = null,
    ) {
        parent::__construct($message, $statusCode, $body, $code, $retryable, $requestId);
        $this->targetStatus = $targetStatus;
    }
}
