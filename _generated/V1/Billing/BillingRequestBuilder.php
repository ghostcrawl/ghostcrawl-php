<?php

namespace GhostCrawl\V1\Billing;

use GhostCrawl\V1\Billing\Checkout\CheckoutRequestBuilder;
use GhostCrawl\V1\Billing\Portal\PortalRequestBuilder;
use GhostCrawl\V1\Billing\Subscription\SubscriptionRequestBuilder;
use GhostCrawl\V1\Billing\Usage\UsageRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/billing
*/
class BillingRequestBuilder extends BaseRequestBuilder 
{
    /**
     * The checkout property
    */
    public function checkout(): CheckoutRequestBuilder {
        return new CheckoutRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The portal property
    */
    public function portal(): PortalRequestBuilder {
        return new PortalRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The subscription property
    */
    public function subscription(): SubscriptionRequestBuilder {
        return new SubscriptionRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * The usage property
    */
    public function usage(): UsageRequestBuilder {
        return new UsageRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new BillingRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/billing');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
