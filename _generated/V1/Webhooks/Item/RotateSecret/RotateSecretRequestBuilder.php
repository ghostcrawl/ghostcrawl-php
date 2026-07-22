<?php

namespace GhostCrawl\V1\Webhooks\Item\RotateSecret;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\RotateSecretResponse;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/webhooks/{webhook_id}/rotate-secret
*/
class RotateSecretRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new RotateSecretRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/webhooks/{webhook_id}/rotate-secret');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * POST /v1/webhooks/{webhook_id}/rotate-secret. Generate a new signing secret for the webhook. The previous secret remains validfor a short grace period so in-flight deliveries can still be verified.
     * @param RotateSecretRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<RotateSecretResponse|null>
     * @throws Exception
    */
    public function post(?RotateSecretRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [RotateSecretResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * POST /v1/webhooks/{webhook_id}/rotate-secret. Generate a new signing secret for the webhook. The previous secret remains validfor a short grace period so in-flight deliveries can still be verified.
     * @param RotateSecretRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(?RotateSecretRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
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
     * @return RotateSecretRequestBuilder
    */
    public function withUrl(string $rawUrl): RotateSecretRequestBuilder {
        return new RotateSecretRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
