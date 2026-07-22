<?php

namespace GhostCrawl\V1\Recordings\Item\Visual\Frames;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class FramesRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var FramesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?FramesRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new FramesRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param FramesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?FramesRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new FramesRequestBuilderGetQueryParameters.
     * @param int|null $cursor Start frame index (cursor-paginated)
     * @param int|null $limit Max frames per page
     * @return FramesRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?int $cursor = null, ?int $limit = null): FramesRequestBuilderGetQueryParameters {
        return new FramesRequestBuilderGetQueryParameters($cursor, $limit);
    }

}
