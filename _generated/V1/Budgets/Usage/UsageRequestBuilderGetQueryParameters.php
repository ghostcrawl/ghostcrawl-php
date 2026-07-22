<?php

namespace GhostCrawl\V1\Budgets\Usage;

/**
 * live budget counter snapshot. Returns {tokens_used, tokens_remaining, calls_used, calls_remaining, crawl_pages_used, crawl_pages_remaining, scope_type, scope_id, source: "live"}.*_remaining = max(0, limit - used) when the policy has a limit, else null(unlimited). Matches the shape emitted by the SSE budget-stream endpoint. Cross-tenant → 404 budget_not_found (not 403; enumeration guard).
*/
class UsageRequestBuilderGetQueryParameters 
{
    /**
     * @QueryParameter("scope_id")
     * @var string|null $scopeId
    */
    public ?string $scopeId = null;
    
    /**
     * @QueryParameter("scope_type")
     * @var string|null $scopeType
    */
    public ?string $scopeType = null;
    
    /**
     * Instantiates a new UsageRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $scope_id
     * @param string|null $scope_type
    */
    public function __construct(?string $scope_id = null, ?string $scope_type = null) {
        $this->scopeId = $scope_id;
        $this->scopeType = $scope_type;
    }

}
