<?php

namespace GhostCrawl\V1\Kv;

use GhostCrawl\V1\Kv\Item\WithKeyItemRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/kv
*/
class KvRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the GhostCrawl.v1.kv.item collection
     * @param string $key Unique identifier of the item
     * @return WithKeyItemRequestBuilder
    */
    public function byKey(string $key): WithKeyItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['key'] = $key;
        return new WithKeyItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new KvRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/kv');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
