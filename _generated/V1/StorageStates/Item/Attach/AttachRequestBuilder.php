<?php

namespace GhostCrawl\V1\StorageStates\Item\Attach;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\StorageStateAttachRequest;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/storage-states/{id_or_name}/attach
*/
class AttachRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Instantiates a new AttachRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/storage-states/{id_or_name}/attach');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * attach a storage state to a profile. Decrypts and validates the named storage state, filters expired cookies,then sets the sticky binding so subsequent sessions on this profile startwith the saved state loaded. Cross-tenant miss → storage_state_not_found (404, not 403; enumeration guard). Corrupted data → storage_state_decrypt_failed (400).
     * @param StorageStateAttachRequest $body POST /v1/storage-states/{id_or_name}/attach, sticky-attach to a profile.
     * @param AttachRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(StorageStateAttachRequest $body, ?AttachRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * attach a storage state to a profile. Decrypts and validates the named storage state, filters expired cookies,then sets the sticky binding so subsequent sessions on this profile startwith the saved state loaded. Cross-tenant miss → storage_state_not_found (404, not 403; enumeration guard). Corrupted data → storage_state_decrypt_failed (400).
     * @param StorageStateAttachRequest $body POST /v1/storage-states/{id_or_name}/attach, sticky-attach to a profile.
     * @param AttachRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(StorageStateAttachRequest $body, ?AttachRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return AttachRequestBuilder
    */
    public function withUrl(string $rawUrl): AttachRequestBuilder {
        return new AttachRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
