<?php

namespace GhostCrawl\V1\Sessions\Item;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\V1\Sessions\Item\Extend\ExtendRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Pin\PinRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Recording\RecordingRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Release\ReleaseRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Takeover_release\Takeover_releaseRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Takeover_token\Takeover_tokenRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Takeover\TakeoverRequestBuilder;
use GhostCrawl\V1\Sessions\Item\Terminate\TerminateRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

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
     * The terminate property
    */
    public function terminate(): TerminateRequestBuilder {
        return new TerminateRequestBuilder($this->pathParameters, $this->requestAdapter);
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

    /**
     * return the session lease record (org-owned) or 404. Reads; a missing lease OR a cross-org lease → 404). tenant_id is not echoed.
     * @param Profile_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?Profile_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * return the session lease record (org-owned) or 404. Reads; a missing lease OR a cross-org lease → 404). tenant_id is not echoed.
     * @param Profile_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?Profile_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::GET;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return Profile_ItemRequestBuilder
    */
    public function withUrl(string $rawUrl): Profile_ItemRequestBuilder {
        return new Profile_ItemRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
