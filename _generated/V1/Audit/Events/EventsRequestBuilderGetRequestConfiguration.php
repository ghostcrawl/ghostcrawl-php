<?php

namespace GhostCrawl\V1\Audit\Events;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class EventsRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var EventsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?EventsRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new EventsRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param EventsRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?EventsRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new EventsRequestBuilderGetQueryParameters.
     * @param string|null $action Exact-match filter on action.
     * @param string|null $actor_user_id
     * @param string|null $cursor Opaque pagination cursor.
     * @param int|null $limit
     * @param string|null $outcome
     * @param string|null $since Return records created on or after this timestamp.
     * @param string|null $target_id
     * @param string|null $target_kind
     * @param string|null $until Return records created before this timestamp.
     * @return EventsRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $action = null, ?string $actor_user_id = null, ?string $cursor = null, ?int $limit = null, ?string $outcome = null, ?string $since = null, ?string $target_id = null, ?string $target_kind = null, ?string $until = null): EventsRequestBuilderGetQueryParameters {
        return new EventsRequestBuilderGetQueryParameters($action, $actor_user_id, $cursor, $limit, $outcome, $since, $target_id, $target_kind, $until);
    }

}
