<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class CdpInputRequest_step_type extends Enum {
    public const NAVIGATE = "navigate";
    public const CLICK = "click";
    public const TYPE = "type";
}
