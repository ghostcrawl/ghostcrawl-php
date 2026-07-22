<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ExtractRequest_engine extends Enum {
    public const AUTO = "auto";
    public const CHROME = "chrome";
    public const FIREFOX = "firefox";
    public const WEBKIT = "webkit";
}
