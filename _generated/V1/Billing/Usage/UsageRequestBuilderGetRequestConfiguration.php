<?php

namespace GhostCrawl\V1\Billing\Usage;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class UsageRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var UsageRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?UsageRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new UsageRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param UsageRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?UsageRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new UsageRequestBuilderGetQueryParameters.
     * @param string|null $dim Filter to specific dim; omit for all dims
     * @param bool|null $metered_only When true, return only metered (billable) usage dims.
     * @param string|null $since Start of usage window (timestamp; default: billing period start).
     * @param string|null $until End of usage window (timestamp; default: now).
     * @param string|null $workspace_id Optional workspace override (admin only); defaults to tenant workspace
     * @return UsageRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $dim = null, ?bool $metered_only = null, ?string $since = null, ?string $until = null, ?string $workspace_id = null): UsageRequestBuilderGetQueryParameters {
        return new UsageRequestBuilderGetQueryParameters($dim, $metered_only, $since, $until, $workspace_id);
    }

}
