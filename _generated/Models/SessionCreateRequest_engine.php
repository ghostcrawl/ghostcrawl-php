<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class SessionCreateRequest_engine extends Enum {
    public const CHROME = "chrome";
    public const FIREFOX = "firefox";
    public const WEBKIT = "webkit";
    public const AUTO = "auto";
}
