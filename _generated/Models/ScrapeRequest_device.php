<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ScrapeRequest_device extends Enum {
    public const RANDOM = "random";
    public const RANDOM_DESKTOP = "random_desktop";
    public const RANDOM_MOBILE = "random_mobile";
    public const RANDOM_WINDOWS = "random_windows";
    public const RANDOM_ANDROID = "random_android";
    public const RANDOM_IOS = "random_ios";
}
