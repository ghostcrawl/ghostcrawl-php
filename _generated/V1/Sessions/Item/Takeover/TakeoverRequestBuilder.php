<?php

namespace GhostCrawl\V1\Sessions\Item\Takeover;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\TakeoverActionBody;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/sessions/{profile_-id}/takeover
*/
class TakeoverRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new TakeoverRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/sessions/{profile_%2Did}/takeover');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Action-dispatch shim for the takeover surface (Surface L acceptance test). POST /v1/sessions/{id}/takeover with {"action": "mint"} delegates to theHMAC-token mint logic (same as /takeover_token). {"action": "release"}delegates to the control flag release logic (same as /takeover_release). This endpoint exists because the Surface L live test uses a single URLwith an action discriminator, while the underlying REST surface exposestwo dedicated sub-paths. Both entry points share identical auth, tier,and cross-tenant guards.
     * @param TakeoverActionBody $body Body for the action-dispatch shim.
     * @param TakeoverRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(TakeoverActionBody $body, ?TakeoverRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Action-dispatch shim for the takeover surface (Surface L acceptance test). POST /v1/sessions/{id}/takeover with {"action": "mint"} delegates to theHMAC-token mint logic (same as /takeover_token). {"action": "release"}delegates to the control flag release logic (same as /takeover_release). This endpoint exists because the Surface L live test uses a single URLwith an action discriminator, while the underlying REST surface exposestwo dedicated sub-paths. Both entry points share identical auth, tier,and cross-tenant guards.
     * @param TakeoverActionBody $body Body for the action-dispatch shim.
     * @param TakeoverRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(TakeoverActionBody $body, ?TakeoverRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return TakeoverRequestBuilder
    */
    public function withUrl(string $rawUrl): TakeoverRequestBuilder {
        return new TakeoverRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
