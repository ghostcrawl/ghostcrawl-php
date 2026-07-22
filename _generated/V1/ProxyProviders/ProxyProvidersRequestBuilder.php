<?php

namespace GhostCrawl\V1\ProxyProviders;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/proxy-providers
*/
class ProxyProvidersRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ProxyProvidersRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/proxy-providers');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * curated proxy provider list. Bearer-gated. Returns the operator-curated list of proxyproviders with referral URLs (carrying the operator's creator code) andpricing summaries. The customer signs up here, pays the provider, and bringsthe creds. Security:, referral URLs are not secrets, but the customer-facing list is bearer-gated (a 140. 4-era extract-method refactor accidentallypromoted the unauthenticated renderer to the route + orphaned this gated handler;restored 2026-06-11).
     * @param ProxyProvidersRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?ProxyProvidersRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * curated proxy provider list. Bearer-gated. Returns the operator-curated list of proxyproviders with referral URLs (carrying the operator's creator code) andpricing summaries. The customer signs up here, pays the provider, and bringsthe creds. Security:, referral URLs are not secrets, but the customer-facing list is bearer-gated (a 140. 4-era extract-method refactor accidentallypromoted the unauthenticated renderer to the route + orphaned this gated handler;restored 2026-06-11).
     * @param ProxyProvidersRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?ProxyProvidersRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return ProxyProvidersRequestBuilder
    */
    public function withUrl(string $rawUrl): ProxyProvidersRequestBuilder {
        return new ProxyProvidersRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
