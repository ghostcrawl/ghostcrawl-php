<?php

namespace GhostCrawl\V1\Sessions\Item;

use GhostCrawl\V1\Sessions\Item\Extend\ExtendRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Pin\PinRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Recording\RecordingRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Release\ReleaseRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Takeover_release\Takeover_releaseRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Takeover_token\Takeover_tokenRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Takeover\TakeoverRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/sessions/{profile_-id}
*/
class Profile_ItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The extend property
    */
    public function extend(): ExtendRequestBuilder {
        return new ExtendRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The pin property
    */
    public function pin(): PinRequestBuilder {
        return new PinRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The recording property
    */
    public function recording(): RecordingRequestBuilder {
        return new RecordingRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The release property
    */
    public function release(): ReleaseRequestBuilder {
        return new ReleaseRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The takeover property
    */
    public function takeover(): TakeoverRequestBuilder {
        return new TakeoverRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The takeover_release property
    */
    public function takeover_release(): Takeover_releaseRequestBuilder {
        return new Takeover_releaseRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The takeover_token property
    */
    public function takeover_token(): Takeover_tokenRequestBuilder {
        return new Takeover_tokenRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new Profile_ItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/sessions/{profile_%2Did}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
