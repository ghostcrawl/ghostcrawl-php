<?php

namespace GhostCrawl\V1\Recordings;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\V1\Recordings\Item\Recording_ItemRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/recordings
*/
class RecordingsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.recordings.item collection
     * @param string $recording_Id Unique identifier of the item
     * @return Recording_ItemRequestBuilder
    */
    public function byRecording_Id(string $recording_Id): Recording_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['recording_%2Did'] = $recording_Id;
        return new Recording_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new RecordingsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/recordings{?created_at_from*,created_at_to*,cursor*,limit*,owner_id*,tags*}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * cursor pagination. response gains total_count (additive); items[*] shape unchanged. owner_id filter requires recordings:admin scope to be honored; without it, the filter is silently dropped (not 403). created_at_from > created_at_to → 400 (not 422). tier gate NOT applied at list layer.
     * @param RecordingsRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?RecordingsRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * cursor pagination. response gains total_count (additive); items[*] shape unchanged. owner_id filter requires recordings:admin scope to be honored; without it, the filter is silently dropped (not 403). created_at_from > created_at_to → 400 (not 422). tier gate NOT applied at list layer.
     * @param RecordingsRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?RecordingsRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return RecordingsRequestBuilder
    */
    public function withUrl(string $rawUrl): RecordingsRequestBuilder {
        return new RecordingsRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
