<?php

namespace GhostCrawl\V1\Profiles;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class ProfilesRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var ProfilesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?ProfilesRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new ProfilesRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param ProfilesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?ProfilesRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new ProfilesRequestBuilderGetQueryParameters.
     * @param string|null $created_at_from
     * @param string|null $created_at_to
     * @param string|null $cursor
     * @param int|null $limit
     * @param string|null $owner_id
     * @param string|null $tags
     * @return ProfilesRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $owner_id = null, ?string $tags = null): ProfilesRequestBuilderGetQueryParameters {
        return new ProfilesRequestBuilderGetQueryParameters($created_at_from, $created_at_to, $cursor, $limit, $owner_id, $tags);
    }

}
