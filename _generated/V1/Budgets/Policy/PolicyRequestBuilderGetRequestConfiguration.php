<?php

namespace GhostCrawl\V1\Budgets\Policy;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class PolicyRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var PolicyRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?PolicyRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new PolicyRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param PolicyRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?PolicyRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new PolicyRequestBuilderGetQueryParameters.
     * @param string|null $scope_id
     * @param string|null $scope_type
     * @return PolicyRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $scope_id = null, ?string $scope_type = null): PolicyRequestBuilderGetQueryParameters {
        return new PolicyRequestBuilderGetQueryParameters($scope_id, $scope_type);
    }

}
