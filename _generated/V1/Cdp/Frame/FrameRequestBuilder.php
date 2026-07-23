<?php

namespace GhostCrawl\V1\Cdp\Frame;

use Exception;
use GhostCrawl\Models\CdpFrameRequest;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/cdp/frame
*/
class FrameRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new FrameRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/cdp/frame');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Engine-agnostic live-view frame capture (cross-engine). Returns a single base64-encoded JPEG frame of a live interactive session, using the same capture path across Chromium, Firefox, and WebKit. Gating: 1. Tenant authentication 2. Revocation check 3. 4. Session ownership (the session must belong to the authenticated organisation) Returns 200 {"format":"jpeg","data":"<base64>","engine","width","height"} on success; 403 cdp_not_enabled (tier) / cdp_revoked; 404 session_not_found; 502 frame_failed.
     * @param CdpFrameRequest $body The request body
     * @param FrameRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(CdpFrameRequest $body, ?FrameRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Engine-agnostic live-view frame capture (cross-engine). Returns a single base64-encoded JPEG frame of a live interactive session, using the same capture path across Chromium, Firefox, and WebKit. Gating: 1. Tenant authentication 2. Revocation check 3. 4. Session ownership (the session must belong to the authenticated organisation) Returns 200 {"format":"jpeg","data":"<base64>","engine","width","height"} on success; 403 cdp_not_enabled (tier) / cdp_revoked; 404 session_not_found; 502 frame_failed.
     * @param CdpFrameRequest $body The request body
     * @param FrameRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(CdpFrameRequest $body, ?FrameRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        $requestInfo->setContentFromParsable($this->requestAdapter, "application/json", $body);
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return FrameRequestBuilder
    */
    public function withUrl(string $rawUrl): FrameRequestBuilder {
        return new FrameRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
