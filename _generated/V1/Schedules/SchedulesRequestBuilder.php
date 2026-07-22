<?php

namespace GhostCrawl\V1\Schedules;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\ScheduleCreateRequest;
use GhostCrawl\V1\Schedules\Item\WithSchedule_ItemRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/schedules
*/
class SchedulesRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.schedules.item collection
     * @param string $schedule_id Unique identifier of the item
     * @return WithSchedule_ItemRequestBuilder
    */
    public function bySchedule_id(string $schedule_id): WithSchedule_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['schedule_id'] = $schedule_id;
        return new WithSchedule_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new SchedulesRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/schedules');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * list.
     * @param SchedulesRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?SchedulesRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * create a cron-triggered scrape/crawl schedule. Validations:- schedule:write scope required (403 forbidden_scope on miss)- cron_expr must parse (422 invalid_cron)- job_type must be 'scrape', 'crawl', or 'change_monitor' (422 invalid_job_type)- notify_webhook must be SSRF-safe HTTPS URL if provided (422 invalid_webhook)- per-org count < cap (429 schedule_cap_reached)- unique name per org (409 schedule_exists)
     * @param ScheduleCreateRequest $body POST /v1/schedules body.
     * @param SchedulesRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function post(ScheduleCreateRequest $body, ?SchedulesRequestBuilderPostRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPostRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * list.
     * @param SchedulesRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?SchedulesRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * create a cron-triggered scrape/crawl schedule. Validations:- schedule:write scope required (403 forbidden_scope on miss)- cron_expr must parse (422 invalid_cron)- job_type must be 'scrape', 'crawl', or 'change_monitor' (422 invalid_job_type)- notify_webhook must be SSRF-safe HTTPS URL if provided (422 invalid_webhook)- per-org count < cap (429 schedule_cap_reached)- unique name per org (409 schedule_exists)
     * @param ScheduleCreateRequest $body POST /v1/schedules body.
     * @param SchedulesRequestBuilderPostRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPostRequestInformation(ScheduleCreateRequest $body, ?SchedulesRequestBuilderPostRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * @return SchedulesRequestBuilder
    */
    public function withUrl(string $rawUrl): SchedulesRequestBuilder {
        return new SchedulesRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
