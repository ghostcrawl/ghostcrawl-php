<?php

namespace GhostCrawl\V1;

use GhostCrawl\V1\Audit\AuditRequestBuilder;
use GhostCrawl\V1\Billing\BillingRequestBuilder;
use GhostCrawl\V1\Budgets\BudgetsRequestBuilder;
use GhostCrawl\V1\Cdp\CdpRequestBuilder;
use GhostCrawl\V1\Contact\ContactRequestBuilder;
use GhostCrawl\V1\Crawl\CrawlRequestBuilder;
use GhostCrawl\V1\CrawlRuns\CrawlRunsRequestBuilder;
use GhostCrawl\V1\Datasets\DatasetsRequestBuilder;
use GhostCrawl\V1\Discovery\DiscoveryRequestBuilder;
use GhostCrawl\V1\Engines\EnginesRequestBuilder;
use GhostCrawl\V1\Extract\ExtractRequestBuilder;
use GhostCrawl\V1\Identity\IdentityRequestBuilder;
use GhostCrawl\V1\Kv\KvRequestBuilder;
use GhostCrawl\V1\Map\MapRequestBuilder;
use GhostCrawl\V1\Me\MeRequestBuilder;
use GhostCrawl\V1\Page\PageRequestBuilder;
use GhostCrawl\V1\Pricing\PricingRequestBuilder;
use GhostCrawl\V1\Profiles\ProfilesRequestBuilder;
use GhostCrawl\V1\ProxyProviders\ProxyProvidersRequestBuilder;
use GhostCrawl\V1\Queues\QueuesRequestBuilder;
use GhostCrawl\V1\Recordings\RecordingsRequestBuilder;
use GhostCrawl\V1\Registry\RegistryRequestBuilder;
use GhostCrawl\V1\Schedules\SchedulesRequestBuilder;
use GhostCrawl\V1\Scrape\ScrapeRequestBuilder;
use GhostCrawl\V1\ScreenshotBlobs\ScreenshotBlobsRequestBuilder;
use GhostCrawl\V1\Search\SearchRequestBuilder;
use GhostCrawl\V1\Sessions\SessionsRequestBuilder;
use GhostCrawl\V1\StorageStates\StorageStatesRequestBuilder;
use GhostCrawl\V1\Updates\UpdatesRequestBuilder;
use GhostCrawl\V1\Webhooks\WebhooksRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1
*/
class V1RequestBuilder extends BaseRequestBuilder 
{
    /**
     * The audit property
    */
    public function audit(): AuditRequestBuilder {
        return new AuditRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The billing property
    */
    public function billing(): BillingRequestBuilder {
        return new BillingRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The budgets property
    */
    public function budgets(): BudgetsRequestBuilder {
        return new BudgetsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The cdp property
    */
    public function cdp(): CdpRequestBuilder {
        return new CdpRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The contact property
    */
    public function contact(): ContactRequestBuilder {
        return new ContactRequestBuilder($this->pathParameters, $this->requestAdapter);
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
     * The discovery property
    */
    public function discovery(): DiscoveryRequestBuilder {
        return new DiscoveryRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The engines property
    */
    public function engines(): EnginesRequestBuilder {
        return new EnginesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The extract property
    */
    public function extract(): ExtractRequestBuilder {
        return new ExtractRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The identity property
    */
    public function identity(): IdentityRequestBuilder {
        return new IdentityRequestBuilder($this->pathParameters, $this->requestAdapter);
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
     * The me property
    */
    public function me(): MeRequestBuilder {
        return new MeRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The page property
    */
    public function page(): PageRequestBuilder {
        return new PageRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The pricing property
    */
    public function pricing(): PricingRequestBuilder {
        return new PricingRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The profiles property
    */
    public function profiles(): ProfilesRequestBuilder {
        return new ProfilesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The proxyProviders property
    */
    public function proxyProviders(): ProxyProvidersRequestBuilder {
        return new ProxyProvidersRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The queues property
    */
    public function queues(): QueuesRequestBuilder {
        return new QueuesRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The recordings property
    */
    public function recordings(): RecordingsRequestBuilder {
        return new RecordingsRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The registry property
    */
    public function registry(): RegistryRequestBuilder {
        return new RegistryRequestBuilder($this->pathParameters, $this->requestAdapter);
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
     * The updates property
    */
    public function updates(): UpdatesRequestBuilder {
        return new UpdatesRequestBuilder($this->pathParameters, $this->requestAdapter);
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
