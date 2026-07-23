<?php

namespace GhostCrawl\V1\Screenshot;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\Models\ScreenshotRequest;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/screenshot
*/
class ScreenshotRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ScreenshotRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/screenshot');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * capture a URL to a PNG and return the raw image/png bytes. Equivalent to /v1/scrape with screenshot=true. Gated exactly like /v1/scrape (daily request quota + GB egress cap); works on every engine. Mirrors /v1/pdf's binary-response path but returns image/png.
     * @param ScreenshotRequest $body POST /v1/screenshot request body, capture a URL to a PNG screenshot.
     * @param ScreenshotRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(ScreenshotRequest $body, ?ScreenshotRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * capture a URL to a PNG and return the raw image/png bytes. Equivalent to /v1/scrape with screenshot=true. Gated exactly like /v1/scrape (daily request quota + GB egress cap); works on every engine. Mirrors /v1/pdf's binary-response path but returns image/png.
     * @param ScreenshotRequest $body POST /v1/screenshot request body, capture a URL to a PNG screenshot.
     * @param ScreenshotRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(ScreenshotRequest $body, ?ScreenshotRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "image/png, application/problem+json");
        $requestInfo->setContentFromParsable($this->requestAdapter, "application/json", $body);
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return ScreenshotRequestBuilder
    */
    public function withUrl(string $rawUrl): ScreenshotRequestBuilder {
        return new ScreenshotRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
