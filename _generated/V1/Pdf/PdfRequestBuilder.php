<?php

namespace GhostCrawl\V1\Pdf;

use Exception;
use GhostCrawl\Models\PdfRequest;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/pdf
*/
class PdfRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new PdfRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/pdf');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * render a URL to PDF. Equivalent to /v1/scrape with format=pdf. Returns application/pdf bytes. Supported on Chrome identities; Firefox and WebKit return 400. The URL is validated and all traffic egresses through your configured proxy. Requires a paid plan and is subject to your request quota (same as /v1/extract).
     * @param PdfRequest $body POST /v1/pdf request body, render a URL to PDF. Renders the target URL to a PDF document. Supported on Chrome identities; requests that resolve to a Firefox or WebKit identity return 400 pdf_engine_unsupported. Security: - The URL is validated against private/loopback/metadata targets. - All traffic egresses through your configured proxy. - Subject to your daily request quota.
     * @param PdfRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(PdfRequest $body, ?PdfRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * render a URL to PDF. Equivalent to /v1/scrape with format=pdf. Returns application/pdf bytes. Supported on Chrome identities; Firefox and WebKit return 400. The URL is validated and all traffic egresses through your configured proxy. Requires a paid plan and is subject to your request quota (same as /v1/extract).
     * @param PdfRequest $body POST /v1/pdf request body, render a URL to PDF. Renders the target URL to a PDF document. Supported on Chrome identities; requests that resolve to a Firefox or WebKit identity return 400 pdf_engine_unsupported. Security: - The URL is validated against private/loopback/metadata targets. - All traffic egresses through your configured proxy. - Subject to your daily request quota.
     * @param PdfRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(PdfRequest $body, ?PdfRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/pdf, application/problem+json");
        $requestInfo->setContentFromParsable($this->requestAdapter, "application/json", $body);
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return PdfRequestBuilder
    */
    public function withUrl(string $rawUrl): PdfRequestBuilder {
        return new PdfRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
