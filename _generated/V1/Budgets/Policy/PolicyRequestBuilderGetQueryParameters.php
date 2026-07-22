<?php

namespace GhostCrawl\V1\Budgets\Policy;

/**
 * retrieve the effective policy for a scope. Requires budgets:read scope for your own scope, or budgets:admin forcross-organisation access. Cross-tenant or missing-id requests return 404(not 403) to prevent enumeration. Query params: scope_type: "user" | "org" | "session" (default "org") scope_id: UUID string; defaults to caller's org_id when scope_type=org, or caller's user_id when scope_type=user.
*/
class PolicyRequestBuilderGetQueryParameters 
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
     * Instantiates a new PolicyRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $scope_id
     * @param string|null $scope_type
    */
    public function __construct(?string $scope_id = null, ?string $scope_type = null) {
        $this->scopeId = $scope_id;
        $this->scopeType = $scope_type;
    }

}
