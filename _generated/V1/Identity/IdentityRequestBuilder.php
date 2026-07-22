<?php

namespace GhostCrawl\V1\Identity;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\IdentityRequest;
use GhostCrawl\Models\IdentityResponse;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/identity
*/
class IdentityRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new IdentityRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/identity');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Create an encrypted identity payload. 2. On HIT: return encrypted blob. 3. Encrypts the resultingidentity configuration, and returns an opaque encrypted envelope. The plaintext identity configuration is NEVER returned in the response.
     * @param IdentityRequest $body Request body for POST /v1/identity. extension (single-endpoint-with-source): source="user" → BYO local path; carries the full local identity payload. source="gc_identity" → managed cloud identity (paid plan). source=None → Legacy path (operating system and browser required). For legacy path with mobile operating system values (ios, android): device_model is required. For legacy path with desktop operating system values (macos, windows, linux): viewport is required.
     * @param IdentityRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<IdentityResponse|null>
     * @throws Exception
    */
    public function post(IdentityRequest $body, ?IdentityRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [IdentityResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * Create an encrypted identity payload. 2. On HIT: return encrypted blob. 3. Encrypts the resultingidentity configuration, and returns an opaque encrypted envelope. The plaintext identity configuration is NEVER returned in the response.
     * @param IdentityRequest $body Request body for POST /v1/identity. extension (single-endpoint-with-source): source="user" → BYO local path; carries the full local identity payload. source="gc_identity" → managed cloud identity (paid plan). source=None → Legacy path (operating system and browser required). For legacy path with mobile operating system values (ios, android): device_model is required. For legacy path with desktop operating system values (macos, windows, linux): viewport is required.
     * @param IdentityRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(IdentityRequest $body, ?IdentityRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return IdentityRequestBuilder
    */
    public function withUrl(string $rawUrl): IdentityRequestBuilder {
        return new IdentityRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
