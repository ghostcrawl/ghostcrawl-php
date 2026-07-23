<?php

namespace GhostCrawl\V1\Selfhost\Byo\Behavior;

use Exception;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/selfhost/byo/behavior
*/
class BehaviorRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new BehaviorRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/selfhost/byo/behavior');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * **Self-host deployments only.** Validate + persist a BYO behavior JSON, then report the sanitized count. Contract: ``{"human_actions": [ {kind,.},. ]}``. ``human_actions`` MUST be a list; it is passed through byo_behavior.sanitize_actions (allow-list + clamp). A non-empty input that sanitizes to an EMPTY plan (every action an invalid kind) → 422 invalid_behavior_json (nothing valid to apply). Success → write ~/.ghostcrawl/behavior.json + {reloaded, actions}.
     * @param BehaviorPutRequestBody $body The request body
     * @param BehaviorRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function put(BehaviorPutRequestBody $body, ?BehaviorRequestBuilderPutRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPutRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * **Self-host deployments only.** Validate + persist a BYO behavior JSON, then report the sanitized count. Contract: ``{"human_actions": [ {kind,.},. ]}``. ``human_actions`` MUST be a list; it is passed through byo_behavior.sanitize_actions (allow-list + clamp). A non-empty input that sanitizes to an EMPTY plan (every action an invalid kind) → 422 invalid_behavior_json (nothing valid to apply). Success → write ~/.ghostcrawl/behavior.json + {reloaded, actions}.
     * @param BehaviorPutRequestBody $body The request body
     * @param BehaviorRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPutRequestInformation(BehaviorPutRequestBody $body, ?BehaviorRequestBuilderPutRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::PUT;
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
     * @return BehaviorRequestBuilder
    */
    public function withUrl(string $rawUrl): BehaviorRequestBuilder {
        return new BehaviorRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
