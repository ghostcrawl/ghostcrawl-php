<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class AgentRequest_mode extends Enum {
    public const SYNC = "sync";
    public const ASYNC = "async";
}
