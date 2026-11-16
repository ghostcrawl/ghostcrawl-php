<?php

namespace GhostCrawl\V1\Page\Arrival;

use Exception;
use GhostCrawl\Models\ArrivalBody;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/page/arrival
*/
class ArrivalRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ArrivalRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/page/arrival');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Arrive at ``dest_url`` through a native link click from ``source_url``, engine-agnostic, so document.referrer, the Referer header and Sec-Fetch-* are produced natively by the click. Both URLs are validated server-side. Tier and ownership checks mirror /v1/cdp/input.
     * @param ArrivalBody $body The request body
     * @param ArrivalRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(ArrivalBody $body, ?ArrivalRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Arrive at ``dest_url`` through a native link click from ``source_url``, engine-agnostic, so document.referrer, the Referer header and Sec-Fetch-* are produced natively by the click. Both URLs are validated server-side. Tier and ownership checks mirror /v1/cdp/input.
     * @param ArrivalBody $body The request body
     * @param ArrivalRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(ArrivalBody $body, ?ArrivalRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return ArrivalRequestBuilder
    */
    public function withUrl(string $rawUrl): ArrivalRequestBuilder {
        return new ArrivalRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
