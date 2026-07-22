<?php

namespace GhostCrawl\V1\Webhooks\Item\Deliveries\Item;

use GhostCrawl\V1\Webhooks\Item\Deliveries\Item\Retry\RetryRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/webhooks/{webhook_id}/deliveries/{delivery_id}
*/
class WithDelivery_ItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The retry property
    */
    public function retry(): RetryRequestBuilder {
        return new RetryRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new WithDelivery_ItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/webhooks/{webhook_id}/deliveries/{delivery_id}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
