<?php

namespace GhostCrawl\V1\Datasets\Item\Rows;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class RowsRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var RowsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?RowsRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new RowsRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param RowsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?RowsRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new RowsRequestBuilderGetQueryParameters.
     * @param string|null $cursor
     * @param int|null $limit
     * @return RowsRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $cursor = null, ?int $limit = null): RowsRequestBuilderGetQueryParameters {
        return new RowsRequestBuilderGetQueryParameters($cursor, $limit);
    }

}
