<?php

namespace GhostCrawl\V1\CrawlRuns\Item;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\V1\CrawlRuns\Item\Cancel\CancelRequestBuilder;
use GhostCrawl\V1\CrawlRuns\Item\Resume\ResumeRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/crawl-runs/{run_id}
*/
class WithRun_ItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The cancel property
    */
    public function cancel(): CancelRequestBuilder {
        return new CancelRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The resume property
    */
    public function resume(): ResumeRequestBuilder {
        return new ResumeRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new WithRun_ItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/crawl-runs/{run_id}{?timeout_s*,wait*}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * status, plus OPT-IN long-poll. Default (``wait`` absent/false): instant status snapshot, behavior unchanged. ``?wait=true&timeout_s=N``: BLOCKS event-driven (same cross-worker `` signal as start-and-wait) until the run reaches a terminal state (completed|cancelled|failed|failed_resumable) or ``timeout_s`` elapses, THEN returns the run record (results included when completed). A timeout returns the CURRENT non-terminal run as HTTP 200, a long-poll, NOT an error. ``timeout_s`` defaults to 300 and is capped at a server-configured maximum (default 600).
     * @param WithRun_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?WithRun_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '400' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '401' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '402' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '404' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '429' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '500' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '503' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * status, plus OPT-IN long-poll. Default (``wait`` absent/false): instant status snapshot, behavior unchanged. ``?wait=true&timeout_s=N``: BLOCKS event-driven (same cross-worker `` signal as start-and-wait) until the run reaches a terminal state (completed|cancelled|failed|failed_resumable) or ``timeout_s`` elapses, THEN returns the run record (results included when completed). A timeout returns the CURRENT non-terminal run as HTTP 200, a long-poll, NOT an error. ``timeout_s`` defaults to 300 and is capped at a server-configured maximum (default 600).
     * @param WithRun_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?WithRun_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return WithRun_ItemRequestBuilder
    */
    public function withUrl(string $rawUrl): WithRun_ItemRequestBuilder {
        return new WithRun_ItemRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
