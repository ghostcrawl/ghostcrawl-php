<?php

namespace GhostCrawl\V1\CrawlRuns\Item;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class WithRun_ItemRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var WithRun_ItemRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?WithRun_ItemRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new WithRun_ItemRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param WithRun_ItemRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?WithRun_ItemRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new WithRun_ItemRequestBuilderGetQueryParameters.
     * @param int|null $timeout_s 
     * @param bool|null $wait 
     * @return WithRun_ItemRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?int $timeout_s = null, ?bool $wait = null): WithRun_ItemRequestBuilderGetQueryParameters {
        return new WithRun_ItemRequestBuilderGetQueryParameters($timeout_s, $wait);
    }

}
