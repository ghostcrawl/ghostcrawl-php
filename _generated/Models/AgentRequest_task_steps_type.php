<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Enum;

class AgentRequest_task_steps_type extends Enum {
    public const ACT = "act";
    public const OBSERVE = "observe";
    public const EXTRACT = "extract";
}
