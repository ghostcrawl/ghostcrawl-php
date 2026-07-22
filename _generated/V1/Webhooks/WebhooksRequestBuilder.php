<?php

namespace GhostCrawl\V1\Webhooks;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\WebhookCreateRequest;
use GhostCrawl\Models\WebhookCreateResponse;
use GhostCrawl\Models\WebhookListResponse;
use GhostCrawl\V1\Webhooks\Item\WithWebhook_ItemRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/webhooks
*/
class WebhooksRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.webhooks.item collection
     * @param string $webhook_id Unique identifier of the item
     * @return WithWebhook_ItemRequestBuilder
    */
    public function byWebhook_id(string $webhook_id): WithWebhook_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['webhook_id'] = $webhook_id;
        return new WithWebhook_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new WebhooksRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/webhooks{?created_at_from*,created_at_to*,cursor*,limit*,owner_id*,tags*}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * cursor pagination. Scope: webhooks:read. cross-tenant → 200 + empty items (store filters by org_id). tier gate NOT applied (already-registered webhooks always listable). owner_id filter requires webhooks:admin; without it → 403.
     * @param WebhooksRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<WebhookListResponse|null>
     * @throws Exception
    */
    public function get(?WebhooksRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [WebhookListResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * Create a new webhook subscription. Returns the webhook plus the plaintext signing secret once. Store the secret immediately, it cannot be recovered; only rotation via /rotate-secret provides a new one.
     * @param WebhookCreateRequest $body Request body for POST /v1/webhooks.
     * @param WebhooksRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<WebhookCreateResponse|null>
     * @throws Exception
    */
    public function post(WebhookCreateRequest $body, ?WebhooksRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [WebhookCreateResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * cursor pagination. Scope: webhooks:read. cross-tenant → 200 + empty items (store filters by org_id). tier gate NOT applied (already-registered webhooks always listable). owner_id filter requires webhooks:admin; without it → 403.
     * @param WebhooksRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?WebhooksRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::GET;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            if ($requestConfiguration->queryParameters !== null) {
                $requestInfo->setQueryParameters($requestConfiguration->queryParameters);
            }
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json");
        return $requestInfo;
    }

    /**
     * Create a new webhook subscription. Returns the webhook plus the plaintext signing secret once. Store the secret immediately, it cannot be recovered; only rotation via /rotate-secret provides a new one.
     * @param WebhookCreateRequest $body Request body for POST /v1/webhooks.
     * @param WebhooksRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(WebhookCreateRequest $body, ?WebhooksRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return WebhooksRequestBuilder
    */
    public function withUrl(string $rawUrl): WebhooksRequestBuilder {
        return new WebhooksRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
