<?php

namespace GhostCrawl\V1\Sessions\Item\Takeover;

use Exception;
use GhostCrawl\Models\ProblemDetails;
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
     * Start or release an interactive takeover of a live browser session. Send ``{"action": "mint"}`` to begin a takeover: you receive a short-lived token you can use to open the interactive session and drive it yourself. Send ``{"action": "release"}`` to hand control back and return the session to view-only. Requires a paid plan and ownership of the session.
     * @param TakeoverActionBody $body The request body
     * @param TakeoverRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(TakeoverActionBody $body, ?TakeoverRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Start or release an interactive takeover of a live browser session. Send ``{"action": "mint"}`` to begin a takeover: you receive a short-lived token you can use to open the interactive session and drive it yourself. Send ``{"action": "release"}`` to hand control back and return the session to view-only. Requires a paid plan and ownership of the session.
     * @param TakeoverActionBody $body The request body
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
