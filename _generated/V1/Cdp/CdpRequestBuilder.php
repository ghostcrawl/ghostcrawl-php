<?php

namespace GhostCrawl\V1\Cdp;

use GhostCrawl\V1\Cdp\Frame\FrameRequestBuilder;
use GhostCrawl\V1\Cdp\Url\UrlRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/cdp
*/
class CdpRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The frame property
    */
    public function frame(): FrameRequestBuilder {
        return new FrameRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The url property
    */
    public function url(): UrlRequestBuilder {
        return new UrlRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new CdpRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/cdp');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
