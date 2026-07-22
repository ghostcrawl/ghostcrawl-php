<?php

namespace GhostCrawl\V1\Me\Export;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;

/**
 * Builds and executes requests for operations under /v1/me/export
*/
class ExportRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new ExportRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/me/export');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * GDPR self-service data export. Returns a JSON bundle of the caller's org data: dataset rows, KV entries,session summaries, API key prefixes (NEVER full keys), audit log rows, webhooksubscriptions. Bundle schema: { "org_id": "<uuid>", "exported_at": "<iso8601>", "datasets": [.], "kv_entries": [.], "sessions": [.], "api_keys": [.], # prefixes only (never plaintext) "audit_log": [.], # most-recent 500 rows "webhooks": [.], }
     * @param ExportRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<ExportGetResponse|null>
     * @throws Exception
    */
    public function get(?ExportRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        return $this->requestAdapter->sendAsync($requestInfo, [ExportGetResponse::class, 'createFromDiscriminatorValue'], $errorMappings);
    }

    /**
     * GDPR self-service data export. Returns a JSON bundle of the caller's org data: dataset rows, KV entries,session summaries, API key prefixes (NEVER full keys), audit log rows, webhooksubscriptions. Bundle schema: { "org_id": "<uuid>", "exported_at": "<iso8601>", "datasets": [.], "kv_entries": [.], "sessions": [.], "api_keys": [.], # prefixes only (never plaintext) "audit_log": [.], # most-recent 500 rows "webhooks": [.], }
     * @param ExportRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?ExportRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return ExportRequestBuilder
    */
    public function withUrl(string $rawUrl): ExportRequestBuilder {
        return new ExportRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
