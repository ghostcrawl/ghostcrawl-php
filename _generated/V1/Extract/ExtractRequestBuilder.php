<?php

namespace GhostCrawl\V1\Extract;

use Exception;
use GhostCrawl\Models\ExtractRequest;
use GhostCrawl\Models\ProblemDetails;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/extract
*/
class ExtractRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ExtractRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/extract');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * structured extraction (deterministic default) + bring-your-own-model extraction. Two modes (selected by model_provider): DETERMINISTIC (model_provider absent, default): 1. The schema is validated (input guard). 2. The URL is validated against private/loopback/metadata targets. 3. The page is fetched and rendered. 4. Structured data is extracted via CSS/regex/keyword rules. 5. The result is validated against the schema, 422 on mismatch (field path only). Returns {"url","data","token_estimate"}. BRING-YOUR-OWN-MODEL (model_provider present): 1. Target URLs are resolved (urls or [url]). 2. The schema is validated if present. 3. At least one of prompt or schema is required, 400 prompt_or_schema_required otherwise. 4. Model credentials are validated, 400 invalid_model_provider on error (the message never echoes the key). 5. Every target URL is validated before fetching, 400 ssrf_blocked. 6. Each URL is fetched and converted to clean Markdown. 7. Your connected model performs the extraction. 8. With a schema present, the result is validated, 422 on mismatch. Returns {"urls","data","token_estimate"}. Security: 401 without a valid Bearer token. - model_provider.api_key is request-scoped: never persisted, logged, or echoed. - Error responses never echo the schema body, fetched content, or credentials.
     * @param ExtractRequest $body POST /v1/extract request body, schema-driven extraction (deterministic) + bring-your-own-model extraction. Two extraction modes: - Deterministic (default, model_provider absent): CSS/regex/keyword extraction. Requires 'schema'. Returns {"url","data","token_estimate"}. - Bring-your-own-model (model_provider present): GhostCrawl fetches and prepares clean Markdown; your connected model performs the semantic extraction (you are not billed for model inference here, only the request quota). Returns {"urls","data","token_estimate"}. Security notes: - The 'schema' field is validated before any fetch (fail-fast input guard). - URLs are validated against private, loopback, and metadata targets before any fetch. - Error responses never echo the schema body, fetched content, or model credentials. - model_provider.api_key is request-scoped only: never persisted, logged, or returned in any response body or error message.
     * @param ExtractRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<ExtractPostResponse|null>
     * @throws Exception
    */
    public function post(ExtractRequest $body, ?ExtractRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '400' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '401' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '402' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '429' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '500' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '503' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
                '504' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [ExtractPostResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * structured extraction (deterministic default) + bring-your-own-model extraction. Two modes (selected by model_provider): DETERMINISTIC (model_provider absent, default): 1. The schema is validated (input guard). 2. The URL is validated against private/loopback/metadata targets. 3. The page is fetched and rendered. 4. Structured data is extracted via CSS/regex/keyword rules. 5. The result is validated against the schema, 422 on mismatch (field path only). Returns {"url","data","token_estimate"}. BRING-YOUR-OWN-MODEL (model_provider present): 1. Target URLs are resolved (urls or [url]). 2. The schema is validated if present. 3. At least one of prompt or schema is required, 400 prompt_or_schema_required otherwise. 4. Model credentials are validated, 400 invalid_model_provider on error (the message never echoes the key). 5. Every target URL is validated before fetching, 400 ssrf_blocked. 6. Each URL is fetched and converted to clean Markdown. 7. Your connected model performs the extraction. 8. With a schema present, the result is validated, 422 on mismatch. Returns {"urls","data","token_estimate"}. Security: 401 without a valid Bearer token. - model_provider.api_key is request-scoped: never persisted, logged, or echoed. - Error responses never echo the schema body, fetched content, or credentials.
     * @param ExtractRequest $body POST /v1/extract request body, schema-driven extraction (deterministic) + bring-your-own-model extraction. Two extraction modes: - Deterministic (default, model_provider absent): CSS/regex/keyword extraction. Requires 'schema'. Returns {"url","data","token_estimate"}. - Bring-your-own-model (model_provider present): GhostCrawl fetches and prepares clean Markdown; your connected model performs the semantic extraction (you are not billed for model inference here, only the request quota). Returns {"urls","data","token_estimate"}. Security notes: - The 'schema' field is validated before any fetch (fail-fast input guard). - URLs are validated against private, loopback, and metadata targets before any fetch. - Error responses never echo the schema body, fetched content, or model credentials. - model_provider.api_key is request-scoped only: never persisted, logged, or returned in any response body or error message.
     * @param ExtractRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(ExtractRequest $body, ?ExtractRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return ExtractRequestBuilder
    */
    public function withUrl(string $rawUrl): ExtractRequestBuilder {
        return new ExtractRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
