<?php

namespace GhostCrawl\V1\Queues;

use GhostCrawl\V1\Queues\Item\WithNameItemRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/queues
*/
class QueuesRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.queues.item collection
     * @param string $name Unique identifier of the item
     * @return WithNameItemRequestBuilder
    */
    public function byName(string $name): WithNameItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['name'] = $name;
        return new WithNameItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new QueuesRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/queues');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
