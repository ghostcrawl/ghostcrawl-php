<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class BatchScrapeRequest_output_format extends Enum {
    public const HTML = "html";
    public const MARKDOWN = "markdown";
    public const BOTH = "both";
}
