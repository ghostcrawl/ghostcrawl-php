<?php

namespace GhostCrawl\V1\Webhooks\Item\Deliveries;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\WebhookDeliveryListResponse;
use GhostCrawl\V1\Webhooks\Item\Deliveries\Item\WithDelivery_ItemRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/webhooks/{webhook_id}/deliveries
*/
class DeliveriesRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.webhooks.item.deliveries.item collection
     * @param string $delivery_id Unique identifier of the item
     * @return WithDelivery_ItemRequestBuilder
    */
    public function byDelivery_id(string $delivery_id): WithDelivery_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['delivery_id'] = $delivery_id;
        return new WithDelivery_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new DeliveriesRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/webhooks/{webhook_id}/deliveries{?created_at_from*,created_at_to*,cursor*,limit*,owner_id*,tags*}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * webhooks:read. Tier gate: NOT applied. Cross-tenant → 404 (by-id asymmetry).
     * @param DeliveriesRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<WebhookDeliveryListResponse|null>
     * @throws Exception
    */
    public function get(?DeliveriesRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [WebhookDeliveryListResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * webhooks:read. Tier gate: NOT applied. Cross-tenant → 404 (by-id asymmetry).
     * @param DeliveriesRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?DeliveriesRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return DeliveriesRequestBuilder
    */
    public function withUrl(string $rawUrl): DeliveriesRequestBuilder {
        return new DeliveriesRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
