<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ErrorCode extends Enum {
    public const BAD_REQUEST = "bad_request";
    public const UNAUTHORIZED = "unauthorized";
    public const FORBIDDEN = "forbidden";
    public const PAYMENT_REQUIRED = "payment_required";
    public const NOT_FOUND = "not_found";
    public const CONFLICT = "conflict";
    public const BYO_PROXY_INVALID = "byo_proxy_invalid";
    public const TIER_UNAVAILABLE = "tier_unavailable";
    public const RATE_LIMITED = "rate_limited";
    public const QUOTA_BACKEND_UNAVAILABLE = "quota_backend_unavailable";
    public const POOL_EXHAUSTED = "pool_exhausted";
    public const EGRESS_INTEGRITY_FAILED = "egress_integrity_failed";
    public const RENDER_HUNG = "render_hung";
    public const ENGINE_CRASHED = "engine_crashed";
    public const RENDER_TIMEOUT = "render_timeout";
    public const ENGINE_TIMEOUT = "engine_timeout";
    public const SERVICE_UNAVAILABLE = "service_unavailable";
    public const INTERNAL_ERROR = "internal_error";
    public const TARGET_HTTP_ERROR = "target_http_error";
    public const NAVIGATION_FAILED = "navigation_failed";
    public const BLOCKED = "blocked";
    public const CAPTCHA_REQUIRED = "captcha_required";
    public const EMPTY_CONTENT = "empty_content";
}
