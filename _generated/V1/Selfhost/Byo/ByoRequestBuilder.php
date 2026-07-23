<?php

namespace GhostCrawl\V1\Selfhost\Byo;

use GhostCrawl\V1\Selfhost\Byo\Behavior\BehaviorRequestBuilder;
use GhostCrawl\V1\Selfhost\Byo\Identity\IdentityRequestBuilder;
use GhostCrawl\V1\Selfhost\Byo\Proxy\ProxyRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/selfhost/byo
*/
class ByoRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The behavior property
    */
    public function behavior(): BehaviorRequestBuilder {
        return new BehaviorRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The identity property
    */
    public function identity(): IdentityRequestBuilder {
        return new IdentityRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The proxy property
    */
    public function proxy(): ProxyRequestBuilder {
        return new ProxyRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new ByoRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/selfhost/byo');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
