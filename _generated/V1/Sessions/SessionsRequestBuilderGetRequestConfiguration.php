<?php

namespace GhostCrawl\V1\Sessions;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class SessionsRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var SessionsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?SessionsRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new SessionsRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param SessionsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?SessionsRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new SessionsRequestBuilderGetQueryParameters.
     * @param string|null $created_at_from
     * @param string|null $created_at_to
     * @param string|null $cursor
     * @param int|null $limit
     * @param string|null $owner_id
     * @param string|null $tags
     * @return SessionsRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $owner_id = null, ?string $tags = null): SessionsRequestBuilderGetQueryParameters {
        return new SessionsRequestBuilderGetQueryParameters($created_at_from, $created_at_to, $cursor, $limit, $owner_id, $tags);
    }

}
