<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ScrollBody_direction extends Enum {
    public const UP = "up";
    public const DOWN = "down";
    public const TOP = "top";
    public const BOTTOM = "bottom";
    public const INTO_VIEW = "into_view";
}
