<?php

namespace GhostCrawl\V1\Webhooks\Item;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\WebhookPublic;
use GhostCrawl\V1\Webhooks\Item\Deliveries\DeliveriesRequestBuilder;
use GhostCrawl\V1\Webhooks\Item\RotateSecret\RotateSecretRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/webhooks/{webhook_id}
*/
class WithWebhook_ItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The deliveries property
    */
    public function deliveries(): DeliveriesRequestBuilder {
        return new DeliveriesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The rotateSecret property
    */
    public function rotateSecret(): RotateSecretRequestBuilder {
        return new RotateSecretRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new WithWebhook_ItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/webhooks/{webhook_id}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * webhooks:write. Tier gate: NOT applied (asymmetry). Cross-tenant → 404. secret keys deleted best-effort.
     * @param WithWebhook_ItemRequestBuilderDeleteRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<void|null>
     * @throws Exception
    */
    public function delete(?WithWebhook_ItemRequestBuilderDeleteRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toDeleteRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendNoContentAsync($requestInfo, $errorMappings);
    }

    /**
     * 404 byte-identical for missing AND cross-tenant. Scope: webhooks:read. Tier gate: NOT applied. Cross-tenant → 404 (by-id asymmetry). Secret: NOT returned (/10).
     * @param WithWebhook_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<WebhookPublic|null>
     * @throws Exception
    */
    public function get(?WithWebhook_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [WebhookPublic::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * webhooks:write. Tier gate: NOT applied (asymmetry). Cross-tenant → 404. secret keys deleted best-effort.
     * @param WithWebhook_ItemRequestBuilderDeleteRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toDeleteRequestInformation(?WithWebhook_ItemRequestBuilderDeleteRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::DELETE;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        return $requestInfo;
    }

    /**
     * 404 byte-identical for missing AND cross-tenant. Scope: webhooks:read. Tier gate: NOT applied. Cross-tenant → 404 (by-id asymmetry). Secret: NOT returned (/10).
     * @param WithWebhook_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?WithWebhook_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return WithWebhook_ItemRequestBuilder
    */
    public function withUrl(string $rawUrl): WithWebhook_ItemRequestBuilder {
        return new WithWebhook_ItemRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
