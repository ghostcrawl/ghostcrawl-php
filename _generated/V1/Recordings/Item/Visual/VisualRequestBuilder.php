<?php

namespace GhostCrawl\V1\Recordings\Item\Visual;

use Exception;
use GhostCrawl\Models\AuthContext;
use GhostCrawl\Models\ProblemDetails;
use GhostCrawl\V1\Recordings\Item\Visual\Frames\FramesRequestBuilder;
use GhostCrawl\V1\Recordings\Item\Visual\Start\StartRequestBuilder;
use GhostCrawl\V1\Recordings\Item\Visual\Stop\StopRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/recordings/{recording_-id}/visual
*/
class VisualRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The frames property
    */
    public function frames(): FramesRequestBuilder {
        return new FramesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The start property
    */
    public function start(): StartRequestBuilder {
        return new StartRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The stop property
    */
    public function stop(): StopRequestBuilder {
        return new StopRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new VisualRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/recordings/{recording_%2Did}/visual');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * Get the HLS-style manifest pointer for a visual recording. Returns 200 {manifest_url, frame_count, status, engine} or 404 for
     * @param AuthContext $body The request body
     * @param VisualRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(AuthContext $body, ?VisualRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [ProblemDetails::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * Get the HLS-style manifest pointer for a visual recording. Returns 200 {manifest_url, frame_count, status, engine} or 404 for
     * @param AuthContext $body The request body
     * @param VisualRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(AuthContext $body, ?VisualRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::GET;
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
     * @return VisualRequestBuilder
    */
    public function withUrl(string $rawUrl): VisualRequestBuilder {
        return new VisualRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
