<?php

namespace GhostCrawl\V1;

use GhostCrawl\V1\Agent\AgentRequestBuilder;
use GhostCrawl\V1\Cdp\CdpRequestBuilder;
use GhostCrawl\V1\Content\ContentRequestBuilder;
use GhostCrawl\V1\Crawl\CrawlRequestBuilder;
use GhostCrawl\V1\CrawlRuns\CrawlRunsRequestBuilder;
use GhostCrawl\V1\Datasets\DatasetsRequestBuilder;
use GhostCrawl\V1\Downloads\DownloadsRequestBuilder;
use GhostCrawl\V1\Extract\ExtractRequestBuilder;
use GhostCrawl\V1\Kv\KvRequestBuilder;
use GhostCrawl\V1\Map\MapRequestBuilder;
use GhostCrawl\V1\Page\PageRequestBuilder;
use GhostCrawl\V1\Pdf\PdfRequestBuilder;
use GhostCrawl\V1\Profiles\ProfilesRequestBuilder;
use GhostCrawl\V1\Recordings\RecordingsRequestBuilder;
use GhostCrawl\V1\Schedules\SchedulesRequestBuilder;
use GhostCrawl\V1\Scrape\ScrapeRequestBuilder;
use GhostCrawl\V1\Screenshot\ScreenshotRequestBuilder;
use GhostCrawl\V1\ScreenshotBlobs\ScreenshotBlobsRequestBuilder;
use GhostCrawl\V1\Search\SearchRequestBuilder;
use GhostCrawl\V1\Selfhost\SelfhostRequestBuilder;
use GhostCrawl\V1\Sessions\SessionsRequestBuilder;
use GhostCrawl\V1\StorageStates\StorageStatesRequestBuilder;
use GhostCrawl\V1\Webhooks\WebhooksRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1
*/
class V1RequestBuilder extends BaseRequestBuilder 
{
    /**
     * The agent property
    */
    public function agent(): AgentRequestBuilder {
        return new AgentRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The cdp property
    */
    public function cdp(): CdpRequestBuilder {
        return new CdpRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The content property
    */
    public function content(): ContentRequestBuilder {
        return new ContentRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The crawl property
    */
    public function crawl(): CrawlRequestBuilder {
        return new CrawlRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The crawlRuns property
    */
    public function crawlRuns(): CrawlRunsRequestBuilder {
        return new CrawlRunsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The datasets property
    */
    public function datasets(): DatasetsRequestBuilder {
        return new DatasetsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The downloads property
    */
    public function downloads(): DownloadsRequestBuilder {
        return new DownloadsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The extract property
    */
    public function extract(): ExtractRequestBuilder {
        return new ExtractRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The kv property
    */
    public function kv(): KvRequestBuilder {
        return new KvRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The map property
    */
    public function map(): MapRequestBuilder {
        return new MapRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The page property
    */
    public function page(): PageRequestBuilder {
        return new PageRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The pdf property
    */
    public function pdf(): PdfRequestBuilder {
        return new PdfRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The profiles property
    */
    public function profiles(): ProfilesRequestBuilder {
        return new ProfilesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The recordings property
    */
    public function recordings(): RecordingsRequestBuilder {
        return new RecordingsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The schedules property
    */
    public function schedules(): SchedulesRequestBuilder {
        return new SchedulesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The scrape property
    */
    public function scrape(): ScrapeRequestBuilder {
        return new ScrapeRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The screenshot property
    */
    public function screenshot(): ScreenshotRequestBuilder {
        return new ScreenshotRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The screenshotBlobs property
    */
    public function screenshotBlobs(): ScreenshotBlobsRequestBuilder {
        return new ScreenshotBlobsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The search property
    */
    public function search(): SearchRequestBuilder {
        return new SearchRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The selfhost property
    */
    public function selfhost(): SelfhostRequestBuilder {
        return new SelfhostRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The sessions property
    */
    public function sessions(): SessionsRequestBuilder {
        return new SessionsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The storageStates property
    */
    public function storageStates(): StorageStatesRequestBuilder {
        return new StorageStatesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The webhooks property
    */
    public function webhooks(): WebhooksRequestBuilder {
        return new WebhooksRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new V1RequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
