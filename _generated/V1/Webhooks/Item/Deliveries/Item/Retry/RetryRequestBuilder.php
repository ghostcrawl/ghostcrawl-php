<?php

namespace GhostCrawl\V1\Webhooks\Item\Deliveries\Item\Retry;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\Models\RetryDeliveryResponse;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/webhooks/{webhook_id}/deliveries/{delivery_id}/retry
*/
class RetryRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new RetryRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/webhooks/{webhook_id}/deliveries/{delivery_id}/retry');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * POST /v1/webhooks/{webhook_id}/deliveries/{delivery_id}/retry. Re-enqueues the failed delivery with a fresh delivery_id; the original event_id is preserved so downstream consumers can detect the retry.
     * @param RetryRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<RetryDeliveryResponse|null>
     * @throws Exception
    */
    public function post(?RetryRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [RetryDeliveryResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * POST /v1/webhooks/{webhook_id}/deliveries/{delivery_id}/retry. Re-enqueues the failed delivery with a fresh delivery_id; the original event_id is preserved so downstream consumers can detect the retry.
     * @param RetryRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(?RetryRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return RetryRequestBuilder
    */
    public function withUrl(string $rawUrl): RetryRequestBuilder {
        return new RetryRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
