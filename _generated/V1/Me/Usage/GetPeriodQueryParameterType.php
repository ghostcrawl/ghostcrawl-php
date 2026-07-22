<?php

namespace GhostCrawl\V1\Me\Usage;

use Microsoft\Kiota\Abstractions\Enum;

class GetPeriodQueryParameterType extends Enum {
    public const DAY = "day";
    public const WEEK = "week";
    public const MONTH = "month";
}
