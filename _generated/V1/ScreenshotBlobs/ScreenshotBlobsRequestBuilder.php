<?php

namespace GhostCrawl\V1\ScreenshotBlobs;

use GhostCrawl\V1\ScreenshotBlobs\Item\WithRefItemRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/screenshot-blobs
*/
class ScreenshotBlobsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.screenshotBlobs.item collection
     * @param string $ref Unique identifier of the item
     * @return WithRefItemRequestBuilder
    */
    public function byRef(string $ref): WithRefItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['ref'] = $ref;
        return new WithRefItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new ScreenshotBlobsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/screenshot-blobs');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
