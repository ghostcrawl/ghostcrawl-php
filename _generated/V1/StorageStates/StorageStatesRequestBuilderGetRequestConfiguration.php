<?php

namespace GhostCrawl\V1\StorageStates;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class StorageStatesRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var StorageStatesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?StorageStatesRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new StorageStatesRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param StorageStatesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?StorageStatesRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new StorageStatesRequestBuilderGetQueryParameters.
     * @param string|null $cursor 
     * @param int|null $limit 
     * @return StorageStatesRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $cursor = null, ?int $limit = null): StorageStatesRequestBuilderGetQueryParameters {
        return new StorageStatesRequestBuilderGetQueryParameters($cursor, $limit);
    }

}
