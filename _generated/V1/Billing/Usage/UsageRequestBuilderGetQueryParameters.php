<?php

namespace GhostCrawl\V1\Billing\Usage;

/**
 *
*/
class UsageRequestBuilderGetQueryParameters 
{
    /**
     * @var string|null $dim Filter to specific dim; omit for all dims
    */
    public ?string $dim = null;
    
    /**
     * @QueryParameter("metered_only")
     * @var bool|null $meteredOnly When true, return only metered (billable) usage dims.
    */
    public ?bool $meteredOnly = null;
    
    /**
     * @var string|null $since Start of usage window (timestamp; default: billing period start).
    */
    public ?string $since = null;
    
    /**
     * @var string|null $until End of usage window (timestamp; default: now).
    */
    public ?string $until = null;
    
    /**
     * @QueryParameter("workspace_id")
     * @var string|null $workspaceId Optional workspace override (admin only); defaults to tenant workspace
    */
    public ?string $workspaceId = null;
    
    /**
     * Instantiates a new UsageRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $dim Filter to specific dim; omit for all dims
     * @param bool|null $metered_only When true, return only metered (billable) usage dims.
     * @param string|null $since Start of usage window (timestamp; default: billing period start).
     * @param string|null $until End of usage window (timestamp; default: now).
     * @param string|null $workspace_id Optional workspace override (admin only); defaults to tenant workspace
    */
    public function __construct(?string $dim = null, ?bool $metered_only = null, ?string $since = null, ?string $until = null, ?string $workspace_id = null) {
        $this->dim = $dim;
        $this->meteredOnly = $metered_only;
        $this->since = $since;
        $this->until = $until;
        $this->workspaceId = $workspace_id;
    }

}
