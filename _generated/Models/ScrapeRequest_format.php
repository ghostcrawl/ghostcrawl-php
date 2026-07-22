<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ScrapeRequest_format extends Enum {
    public const HTML = "html";
    public const MARKDOWN = "markdown";
    public const PDF = "pdf";
}
