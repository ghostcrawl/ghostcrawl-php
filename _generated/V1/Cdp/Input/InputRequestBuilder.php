<?php

namespace GhostCrawl\V1\Cdp\Input;

use Exception;
use GhostCrawl\Models\CdpInputRequest;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/cdp/input
*/
class InputRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new InputRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/cdp/input');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Drive a live interactive session. Dispatches a navigate/click/type step to the session: * navigate → {url} * click → {x, y, button} * type → {text} Returns 200 {"ok": true, "step_type":.} on success; 403 cdp_not_enabled / cdp_revoked; 404 session_not_found; 502 input_failed.
     * @param CdpInputRequest $body POST /v1/cdp/input body. Drives a live interactive session. ``step_type`` is one of navigate/click/type: * navigate → ``url`` * click → ``x``/``y`` (CSS px) + optional ``button`` * type → ``text``
     * @param InputRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(CdpInputRequest $body, ?InputRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Drive a live interactive session. Dispatches a navigate/click/type step to the session: * navigate → {url} * click → {x, y, button} * type → {text} Returns 200 {"ok": true, "step_type":.} on success; 403 cdp_not_enabled / cdp_revoked; 404 session_not_found; 502 input_failed.
     * @param CdpInputRequest $body POST /v1/cdp/input body. Drives a live interactive session. ``step_type`` is one of navigate/click/type: * navigate → ``url`` * click → ``x``/``y`` (CSS px) + optional ``button`` * type → ``text``
     * @param InputRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(CdpInputRequest $body, ?InputRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return InputRequestBuilder
    */
    public function withUrl(string $rawUrl): InputRequestBuilder {
        return new InputRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
