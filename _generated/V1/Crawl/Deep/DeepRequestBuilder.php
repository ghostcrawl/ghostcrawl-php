<?php

namespace GhostCrawl\V1\Crawl\Deep;

use Exception;
use GhostCrawl\Models\DeepCrawlBody;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\V1\Crawl\Deep\Item\WithRun_ItemRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/crawl/deep
*/
class DeepRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the GhostCrawl.v1.crawl.deep.item collection
     * @param string $run_id Unique identifier of the item
     * @return WithRun_ItemRequestBuilder
    */
    public function byRun_id(string $run_id): WithRun_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['run_id'] = $run_id;
        return new WithRun_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new DeepRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/crawl/deep');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * queue an async deep crawl. Returns immediately with run_id and status="queued". Webhook fires on completion when webhook_url is provided. Billing: crawl_pages_delta (Option A).
     * @param DeepCrawlBody $body The request body
     * @param DeepRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(DeepCrawlBody $body, ?DeepRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * queue an async deep crawl. Returns immediately with run_id and status="queued". Webhook fires on completion when webhook_url is provided. Billing: crawl_pages_delta (Option A).
     * @param DeepCrawlBody $body The request body
     * @param DeepRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(DeepCrawlBody $body, ?DeepRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return DeepRequestBuilder
    */
    public function withUrl(string $rawUrl): DeepRequestBuilder {
        return new DeepRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
