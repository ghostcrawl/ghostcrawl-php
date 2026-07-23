<?php

namespace GhostCrawl\V1\Selfhost\Byo\Identity;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/selfhost/byo/identity
*/
class IdentityRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new IdentityRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/selfhost/byo/identity');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * **Self-host deployments only.** Validate + persist a BYO identity JSON, then reload the provider. Contract: the JSON MUST contain all of byo_identity._REQUIRED_KEYS (8 keys). Missing any → 422 invalid_identity_json (no write). Success → write to ``<identities_dir>/<name>.json`` (name from an optional ``name`` field, else a single ``byo`` slot) + reload via LocalIdentityProvider → {reloaded}.
     * @param IdentityPutRequestBody $body The request body
     * @param IdentityRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function put(IdentityPutRequestBody $body, ?IdentityRequestBuilderPutRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPutRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * **Self-host deployments only.** Validate + persist a BYO identity JSON, then reload the provider. Contract: the JSON MUST contain all of byo_identity._REQUIRED_KEYS (8 keys). Missing any → 422 invalid_identity_json (no write). Success → write to ``<identities_dir>/<name>.json`` (name from an optional ``name`` field, else a single ``byo`` slot) + reload via LocalIdentityProvider → {reloaded}.
     * @param IdentityPutRequestBody $body The request body
     * @param IdentityRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPutRequestInformation(IdentityPutRequestBody $body, ?IdentityRequestBuilderPutRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return IdentityRequestBuilder
    */
    public function withUrl(string $rawUrl): IdentityRequestBuilder {
        return new IdentityRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
