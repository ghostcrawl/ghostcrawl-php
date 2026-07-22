<?php

namespace GhostCrawl\V1\CrawlRuns;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class CrawlRunsRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var CrawlRunsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?CrawlRunsRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new CrawlRunsRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param CrawlRunsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?CrawlRunsRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new CrawlRunsRequestBuilderGetQueryParameters.
     * @param string|null $created_at_from
     * @param string|null $created_at_to
     * @param string|null $cursor
     * @param int|null $limit
     * @param string|null $owner_id
     * @param string|null $tags
     * @return CrawlRunsRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $owner_id = null, ?string $tags = null): CrawlRunsRequestBuilderGetQueryParameters {
        return new CrawlRunsRequestBuilderGetQueryParameters($created_at_from, $created_at_to, $cursor, $limit, $owner_id, $tags);
    }

}
