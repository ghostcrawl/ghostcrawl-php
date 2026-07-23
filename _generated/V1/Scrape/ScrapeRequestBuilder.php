<?php

namespace GhostCrawl\V1\Scrape;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\Models\ScrapeRequest;
use GhostCrawl\Models\ScrapeResult;
use GhostCrawl\V1\Scrape\Batch\BatchRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/scrape
*/
class ScrapeRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The batch property
    */
    public function batch(): BatchRequestBuilder {
        return new BatchRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new ScrapeRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/scrape');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Bearer-gated scrape with identity field. Accepts: ``identity: "id_."`` Re-use a persisted identity (no quota charge). - ``identity_spec: {.}`` Inline identity creation (counts against quota). - neither Host-identity fallback; warns in response. - Both → 422 invalid_request. is unreachable from this route, profile.identity_id is always populated. stream=True branch returns text/event-stream with per-tenant cap.
     * @param ScrapeRequest $body POST /v1/scrape request body (-03 identity-aware shape).
     * @param ScrapeRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<ScrapeResult|null>
     * @throws Exception
    */
    public function post(ScrapeRequest $body, ?ScrapeRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '400' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '401' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '402' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '429' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '500' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '503' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '504' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                'XXX' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [ScrapeResult::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * Bearer-gated scrape with identity field. Accepts: ``identity: "id_."`` Re-use a persisted identity (no quota charge). - ``identity_spec: {.}`` Inline identity creation (counts against quota). - neither Host-identity fallback; warns in response. - Both → 422 invalid_request. is unreachable from this route, profile.identity_id is always populated. stream=True branch returns text/event-stream with per-tenant cap.
     * @param ScrapeRequest $body POST /v1/scrape request body (-03 identity-aware shape).
     * @param ScrapeRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(ScrapeRequest $body, ?ScrapeRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return ScrapeRequestBuilder
    */
    public function withUrl(string $rawUrl): ScrapeRequestBuilder {
        return new ScrapeRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
