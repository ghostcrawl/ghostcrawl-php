<?php

namespace GhostCrawl\V1\Page;

use GhostCrawl\V1\Page\Cookies\CookiesRequestBuilder;
use GhostCrawl\V1\Page\Dom_snapshot\Dom_snapshotRequestBuilder;
use GhostCrawl\V1\Page\Download\DownloadRequestBuilder;
use GhostCrawl\V1\Page\Eval\EvalRequestBuilder;
use GhostCrawl\V1\Page\Har\HarRequestBuilder;
use GhostCrawl\V1\Page\Scroll\ScrollRequestBuilder;
use GhostCrawl\V1\Page\Upload\UploadRequestBuilder;
use GhostCrawl\V1\Page\Wait\WaitRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/page
*/
class PageRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The cookies property
    */
    public function cookies(): CookiesRequestBuilder {
        return new CookiesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The dom_snapshot property
    */
    public function dom_snapshot(): Dom_snapshotRequestBuilder {
        return new Dom_snapshotRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The download property
    */
    public function download(): DownloadRequestBuilder {
        return new DownloadRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The eval property
    */
    public function eval(): EvalRequestBuilder {
        return new EvalRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The har property
    */
    public function har(): HarRequestBuilder {
        return new HarRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The scroll property
    */
    public function scroll(): ScrollRequestBuilder {
        return new ScrollRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The upload property
    */
    public function upload(): UploadRequestBuilder {
        return new UploadRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The wait property
    */
    public function wait(): WaitRequestBuilder {
        return new WaitRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new PageRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/page');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
