<?php

namespace GhostCrawl\V1\Selfhost\Byo\Proxy;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/selfhost/byo/proxy
*/
class ProxyRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ProxyRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/selfhost/byo/proxy');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * **Self-host deployments only.** Validate + persist a BYO proxy JSON document, then reload the provider. Contract: ``{"proxies": [ {url, operating system,.},. ]}``. Each entry MUST carry a ``url`` and ``operating system`` (CLAUDE.md residential-proxy rule). Malformed → 422 invalid_proxy_json (no write). Success → write to the proxies.json target + reload via LocalProxyProvider → {reloaded, count}.
     * @param ProxyPutRequestBody $body The request body
     * @param ProxyRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function put(ProxyPutRequestBody $body, ?ProxyRequestBuilderPutRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPutRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * **Self-host deployments only.** Validate + persist a BYO proxy JSON document, then reload the provider. Contract: ``{"proxies": [ {url, operating system,.},. ]}``. Each entry MUST carry a ``url`` and ``operating system`` (CLAUDE.md residential-proxy rule). Malformed → 422 invalid_proxy_json (no write). Success → write to the proxies.json target + reload via LocalProxyProvider → {reloaded, count}.
     * @param ProxyPutRequestBody $body The request body
     * @param ProxyRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPutRequestInformation(ProxyPutRequestBody $body, ?ProxyRequestBuilderPutRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::PUT;
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
     * @return ProxyRequestBuilder
    */
    public function withUrl(string $rawUrl): ProxyRequestBuilder {
        return new ProxyRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
