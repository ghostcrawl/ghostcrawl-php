<?php

namespace GhostCrawl\V1\Search\Jobs;

use GhostCrawl\V1\Search\Jobs\Item\WithJob_ItemRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/search/jobs
*/
class JobsRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the GhostCrawl.v1.search.jobs.item collection
     * @param string $job_id Search job id from a 202 /v1/search handoff.
     * @return WithJob_ItemRequestBuilder
    */
    public function byJob_id(string $job_id): WithJob_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['job_id'] = $job_id;
        return new WithJob_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new JobsRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/search/jobs');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
