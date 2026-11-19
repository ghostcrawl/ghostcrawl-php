<?php

namespace GhostCrawl\V1\Agent;

use Exception;
use GhostCrawl\Models\AgentRequest;
use GhostCrawl\Models\ErrorEnvelope;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/agent
*/
class AgentRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new AgentRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/agent');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * BETA / opt-in. The REST agent lane is disabled by default and returns 404 until enabled for your account/deployment, see the 404 response below. The agent capability is generally available via the MCP `ghostcrawl_agent` tool; this REST surface is still stabilising. Contact support to enable it.
     * @param AgentRequest $body The request body
     * @param AgentRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(AgentRequest $body, ?AgentRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '400' => [ErrorEnvelope::class, 'createFromDiscriminatorValue'],
                '404' => [Agent404Error::class, 'createFromDiscriminatorValue'],
                '503' => [ErrorEnvelope::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * BETA / opt-in. The REST agent lane is disabled by default and returns 404 until enabled for your account/deployment, see the 404 response below. The agent capability is generally available via the MCP `ghostcrawl_agent` tool; this REST surface is still stabilising. Contact support to enable it.
     * @param AgentRequest $body The request body
     * @param AgentRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(AgentRequest $body, ?AgentRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::POST;
        if ($requestConfiguration !== null) {
            $requestInfo->addHeaders($requestConfiguration->headers);
            $requestInfo->addRequestOptions(...$requestConfiguration->options);
        }
        $requestInfo->tryAddHeader('Accept', "application/json, application/problem+json");
        $requestInfo->setContentFromParsable($this->requestAdapter, "application/json", $body);
        return $requestInfo;
    }

    /**
     * Returns a request builder with the provided arbitrary URL. Using this method means any other path or query parameters are ignored.
     * @param string $rawUrl The raw URL to use for the request builder.
     * @return AgentRequestBuilder
    */
    public function withUrl(string $rawUrl): AgentRequestBuilder {
        return new AgentRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
