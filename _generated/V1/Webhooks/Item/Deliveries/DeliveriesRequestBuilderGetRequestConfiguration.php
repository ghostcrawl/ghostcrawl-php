<?php

namespace GhostCrawl\V1\Webhooks\Item\Deliveries;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class DeliveriesRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var DeliveriesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?DeliveriesRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new DeliveriesRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param DeliveriesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?DeliveriesRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new DeliveriesRequestBuilderGetQueryParameters.
     * @param string|null $created_at_from 
     * @param string|null $created_at_to 
     * @param string|null $cursor 
     * @param int|null $limit 
     * @param string|null $tags 
     * @return DeliveriesRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $tags = null): DeliveriesRequestBuilderGetQueryParameters {
        return new DeliveriesRequestBuilderGetQueryParameters($created_at_from, $created_at_to, $cursor, $limit, $tags);
    }

}
