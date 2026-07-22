<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ScrapeRequest_batch_identity_mode extends Enum {
    public const PERSIST = "persist";
    public const RANDOMIZE = "randomize";
}
