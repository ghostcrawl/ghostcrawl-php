<?php

namespace GhostCrawl\V1\Updates;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class UpdatesRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var UpdatesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?UpdatesRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new UpdatesRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param UpdatesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?UpdatesRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new UpdatesRequestBuilderGetQueryParameters.
     * @param string|null $current Currently installed tag, e.g. v1. 8. 0
     * @return UpdatesRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $current = null): UpdatesRequestBuilderGetQueryParameters {
        return new UpdatesRequestBuilderGetQueryParameters($current);
    }

}
