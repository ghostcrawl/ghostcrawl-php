<?php

namespace GhostCrawl\V1\Map;

use Exception;
use GhostCrawl\Models\MapBody;
use GhostCrawl\Models\MapResponse;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/map
*/
class MapRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new MapRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/map');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * sitemap URL discovery. 1. The seed URL is validated against private/loopback/metadata targets. 2. The request is quota-checked. 3. URLs are discovered from the site's sitemaps. 4. Results are filtered to the same registrable domain by default. 5. An optional case-insensitive substring filter is applied to URLs. 6. Results are capped at 10000 regardless of the requested limit.
     * @param MapBody $body Firecrawl-compatible /v1/map request body. naming convention warnings for intentional camelCase).
     * @param MapRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<MapResponse|null>
     * @throws Exception
    */
    public function post(MapBody $body, ?MapRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [MapResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * sitemap URL discovery. 1. The seed URL is validated against private/loopback/metadata targets. 2. The request is quota-checked. 3. URLs are discovered from the site's sitemaps. 4. Results are filtered to the same registrable domain by default. 5. An optional case-insensitive substring filter is applied to URLs. 6. Results are capped at 10000 regardless of the requested limit.
     * @param MapBody $body Firecrawl-compatible /v1/map request body. naming convention warnings for intentional camelCase).
     * @param MapRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(MapBody $body, ?MapRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return MapRequestBuilder
    */
    public function withUrl(string $rawUrl): MapRequestBuilder {
        return new MapRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
