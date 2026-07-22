<?php

namespace GhostCrawl\V1\Page\Eval;

use Exception;
use GhostCrawl\Models\EvalBody;
use GhostCrawl\Models\HTTPValidationError;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/page/eval
*/
class EvalRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new EvalRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/page/eval');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Run caller-supplied JavaScript in the pinned page context. All execution paths (disabled, timeout-killed, result-capped, PII-filtered)are audit-logged. A pre-execution audit record is written before the watchdogfires so interrupted evaluations remain traceable, paired with a finalsuccess/failure/denied record sharing the same ``eval_id`` correlation key. The result payload is never written to the audit log, only its size and hash.
     * @param EvalBody $body The request body
     * @param EvalRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(EvalBody $body, ?EvalRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Run caller-supplied JavaScript in the pinned page context. All execution paths (disabled, timeout-killed, result-capped, PII-filtered)are audit-logged. A pre-execution audit record is written before the watchdogfires so interrupted evaluations remain traceable, paired with a finalsuccess/failure/denied record sharing the same ``eval_id`` correlation key. The result payload is never written to the audit log, only its size and hash.
     * @param EvalBody $body The request body
     * @param EvalRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(EvalBody $body, ?EvalRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return EvalRequestBuilder
    */
    public function withUrl(string $rawUrl): EvalRequestBuilder {
        return new EvalRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
