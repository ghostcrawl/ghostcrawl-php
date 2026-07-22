<?php

namespace GhostCrawl\V1\Queues\Item;

use GhostCrawl\V1\Queues\Item\Ack\AckRequestBuilder;
use GhostCrawl\V1\Queues\Item\Pop\PopRequestBuilder;
use GhostCrawl\V1\Queues\Item\Push\PushRequestBuilder;
use GhostCrawl\V1\Queues\Item\Stats\StatsRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/queues/{name}
*/
class WithNameItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The ack property
    */
    public function ack(): AckRequestBuilder {
        return new AckRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The pop property
    */
    public function pop(): PopRequestBuilder {
        return new PopRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The push property
    */
    public function push(): PushRequestBuilder {
        return new PushRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The stats property
    */
    public function stats(): StatsRequestBuilder {
        return new StatsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new WithNameItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/queues/{name}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
