<?php

namespace GhostCrawl\V1\Datasets;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class DatasetsRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var DatasetsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?DatasetsRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new DatasetsRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param DatasetsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?DatasetsRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new DatasetsRequestBuilderGetQueryParameters.
     * @param string|null $created_at_from 
     * @param string|null $created_at_to 
     * @param string|null $cursor 
     * @param int|null $limit 
     * @param string|null $tags 
     * @return DatasetsRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $tags = null): DatasetsRequestBuilderGetQueryParameters {
        return new DatasetsRequestBuilderGetQueryParameters($created_at_from, $created_at_to, $cursor, $limit, $tags);
    }

}
