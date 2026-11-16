<?php

namespace GhostCrawl\V1\Page\ClosePopups;

use Exception;
use GhostCrawl\Models\ClosePopupsBody;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/page/close-popups
*/
class ClosePopupsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ClosePopupsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/page/close-popups');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Close any popup tab opened on a live cloud session (works on every engine). Every non-primary, off-host http page is closed while the primary page and same-host tabs are kept. Returns ``{closed: [urls], count}``. Tier and ownership checks mirror the other page tools.
     * @param ClosePopupsBody $body The request body
     * @param ClosePopupsRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(ClosePopupsBody $body, ?ClosePopupsRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Close any popup tab opened on a live cloud session (works on every engine). Every non-primary, off-host http page is closed while the primary page and same-host tabs are kept. Returns ``{closed: [urls], count}``. Tier and ownership checks mirror the other page tools.
     * @param ClosePopupsBody $body The request body
     * @param ClosePopupsRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(ClosePopupsBody $body, ?ClosePopupsRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return ClosePopupsRequestBuilder
    */
    public function withUrl(string $rawUrl): ClosePopupsRequestBuilder {
        return new ClosePopupsRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
