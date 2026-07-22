<?php

namespace GhostCrawl\V1\Budgets\Policy\Item;

use GhostCrawl\V1\Budgets\Policy\Item\Item\WithScope_ItemRequestBuilder;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

/**
 * Builds and executes requests for operations under /v1/budgets/policy/{scope_type}
*/
class WithScope_typeItemRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.budgets.policy.item.item collection
     * @param string $scope_id Unique identifier of the item
     * @return WithScope_ItemRequestBuilder
    */
    public function byScope_id(string $scope_id): WithScope_ItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['scope_id'] = $scope_id;
        return new WithScope_ItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new WithScope_typeItemRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/budgets/policy/{scope_type}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

}
