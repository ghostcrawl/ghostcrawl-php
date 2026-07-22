<?php

namespace GhostCrawl\V1\Sessions\Item\BudgetStream;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/sessions/{profile_-id}/budget-stream
*/
class BudgetStreamRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new BudgetStreamRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/sessions/{profile_%2Did}/budget-stream');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * SSE stream of live budget counters for a session. Emits server-sent events only on counter change (polled every 250 ms). Heartbeat emitted every 15 seconds to keep the connection alive. Closes on session end, client disconnect, or server shutdown. Proxy anti-buffer headers: Cache-Control: no-cache, X-Accel-Buffering: no,Connection: keep-alive. Auth: budgets:read for own session. Cross-tenant access returns 404(not 403) as an enumeration guard, ownership is checked before scopeso that a caller with budgets:read cannot enumerate other organisations'sessions.
     * @param BudgetStreamRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?BudgetStreamRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * SSE stream of live budget counters for a session. Emits server-sent events only on counter change (polled every 250 ms). Heartbeat emitted every 15 seconds to keep the connection alive. Closes on session end, client disconnect, or server shutdown. Proxy anti-buffer headers: Cache-Control: no-cache, X-Accel-Buffering: no,Connection: keep-alive. Auth: budgets:read for own session. Cross-tenant access returns 404(not 403) as an enumeration guard, ownership is checked before scopeso that a caller with budgets:read cannot enumerate other organisations'sessions.
     * @param BudgetStreamRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?BudgetStreamRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return BudgetStreamRequestBuilder
    */
    public function withUrl(string $rawUrl): BudgetStreamRequestBuilder {
        return new BudgetStreamRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
