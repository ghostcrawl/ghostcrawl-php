<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ScrapeRequest_routing_mode extends Enum {
    public const AUTO = "auto";
    public const STANDARD = "standard";
    public const PREMIUM = "premium";
}
