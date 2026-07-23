<?php

namespace GhostCrawl\V1\Search\Jobs\Item;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/search/jobs/{job_id}
*/
class WithJob_ItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new WithJob_ItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/search/jobs/{job_id}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * 200 + SearchResult when done (real result items = GREEN); 202 {status:"running"} while the extended rotation is still going (carrying ``deadline``/``poll_max_seconds`` so the client loop is bounded); 200 {status:"open", items:[]} on honest exhaustion (challenged/0-result, never a faked GREEN); 200 {status:"temporarily_unavailable"} when the deadline passes with the record still ``running`` (lost worker, retryable terminal); 404 if unknown/expired/foreign. Ownership-scoped: a job created by another tenant reads as 404. BOUNDED-TERMINAL CONTRACT (no infinite poll): every poll resolves to a terminal within the stamped deadline REGARDLESS of worker health. A 404 is TERMINAL, the job expired or is unknown; the query may be retried at a HUMAN pace after Retry-After, but a 404 must NEVER be auto-interpreted as "resubmit the same query in a tight loop" (that is the one behavior that turns a recoverable miss into an infinite loop). See the SDK/MCP wrapper.
     * @param WithJob_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?WithJob_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * 200 + SearchResult when done (real result items = GREEN); 202 {status:"running"} while the extended rotation is still going (carrying ``deadline``/``poll_max_seconds`` so the client loop is bounded); 200 {status:"open", items:[]} on honest exhaustion (challenged/0-result, never a faked GREEN); 200 {status:"temporarily_unavailable"} when the deadline passes with the record still ``running`` (lost worker, retryable terminal); 404 if unknown/expired/foreign. Ownership-scoped: a job created by another tenant reads as 404. BOUNDED-TERMINAL CONTRACT (no infinite poll): every poll resolves to a terminal within the stamped deadline REGARDLESS of worker health. A 404 is TERMINAL, the job expired or is unknown; the query may be retried at a HUMAN pace after Retry-After, but a 404 must NEVER be auto-interpreted as "resubmit the same query in a tight loop" (that is the one behavior that turns a recoverable miss into an infinite loop). See the SDK/MCP wrapper.
     * @param WithJob_ItemRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?WithJob_ItemRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return WithJob_ItemRequestBuilder
    */
    public function withUrl(string $rawUrl): WithJob_ItemRequestBuilder {
        return new WithJob_ItemRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
