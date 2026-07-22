<?php

namespace GhostCrawl\V1\Budgets\Policy;

use Exception;
use GhostCrawl\Models\HTTPValidationError;
use GhostCrawl\Models\PolicyUpsertRequest;
use GhostCrawl\V1\Budgets\Policy\Item\WithScope_typeItemRequestBuilder;
use Http\Promise\Promise;
use Microsoft\Kiota\Abstractions\BaseRequestBuilder;
use Microsoft\Kiota\Abstractions\HttpMethod;
use Microsoft\Kiota\Abstractions\RequestAdapter;
use Microsoft\Kiota\Abstractions\RequestInformation;
use Psr\Http\Message\StreamInterface;

/**
 * Builds and executes requests for operations under /v1/budgets/policy
*/
class PolicyRequestBuilder extends BaseRequestBuilder 
{
    /**
     * Gets an item from the ghostcrawl.v1.budgets.policy.item collection
     * @param string $scope_type Unique identifier of the item
     * @return WithScope_typeItemRequestBuilder
    */
    public function byScope_type(string $scope_type): WithScope_typeItemRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['scope_type'] = $scope_type;
        return new WithScope_typeItemRequestBuilder($urlTplParams, $this->requestAdapter);
    }

    /**
     * Instantiates a new PolicyRequestBuilder and sets the default values.
     * @param array<string, mixed>|string $pathParametersOrRawUrl Path parameters for the request or a String representing the raw URL.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct($pathParametersOrRawUrl, RequestAdapter $requestAdapter) {
        parent::__construct($requestAdapter, [], '{+baseurl}/v1/budgets/policy{?scope_id*,scope_type*}');
        if (is_array($pathParametersOrRawUrl)) {
            $this->pathParameters = $pathParametersOrRawUrl;
        } else {
            $this->pathParameters = ['request-raw-url' => $pathParametersOrRawUrl];
        }
    }

    /**
     * retrieve the effective policy for a scope. Requires budgets:read scope for your own scope, or budgets:admin forcross-organisation access. Cross-tenant or missing-id requests return 404(not 403) to prevent enumeration. Query params: scope_type: "user" | "org" | "session" (default "org") scope_id: UUID string; defaults to caller's org_id when scope_type=org, or caller's user_id when scope_type=user.
     * @param PolicyRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function get(?PolicyRequestBuilderGetRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toGetRequestInformation($requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * upsert a budget policy row. Auth: budgets:write for own scope; budgets:admin for cross-tenant scope. Audit: emits budget.policy_created (INSERT) or budget.policy_updated (UPDATE), the store's upsert re-reads the row post-conflict to detect which happened(compare created_at == updated_at). Best-effort; never raises to caller.
     * @param PolicyUpsertRequest $body The request body
     * @param PolicyRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return Promise<StreamInterface|null>
     * @throws Exception
    */
    public function put(PolicyUpsertRequest $body, ?PolicyRequestBuilderPutRequestConfiguration $requestConfiguration = null): Promise {
        $requestInfo = $this->toPutRequestInformation($body, $requestConfiguration);
        $errorMappings = [
                '422' => [HTTPValidationError::class, 'createFromDiscriminatorValue'],
        ];
        /** @var Promise<StreamInterface|null> $result */
        $result = $this->requestAdapter->sendPrimitiveAsync($requestInfo, StreamInterface::class, $errorMappings);
        return $result;
    }

    /**
     * retrieve the effective policy for a scope. Requires budgets:read scope for your own scope, or budgets:admin forcross-organisation access. Cross-tenant or missing-id requests return 404(not 403) to prevent enumeration. Query params: scope_type: "user" | "org" | "session" (default "org") scope_id: UUID string; defaults to caller's org_id when scope_type=org, or caller's user_id when scope_type=user.
     * @param PolicyRequestBuilderGetRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toGetRequestInformation(?PolicyRequestBuilderGetRequestConfiguration $requestConfiguration = null): RequestInformation {
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
     * upsert a budget policy row. Auth: budgets:write for own scope; budgets:admin for cross-tenant scope. Audit: emits budget.policy_created (INSERT) or budget.policy_updated (UPDATE), the store's upsert re-reads the row post-conflict to detect which happened(compare created_at == updated_at). Best-effort; never raises to caller.
     * @param PolicyUpsertRequest $body The request body
     * @param PolicyRequestBuilderPutRequestConfiguration|null $requestConfiguration Configuration for the request such as headers, query parameters, and middleware options.
     * @return RequestInformation
    */
    public function toPutRequestInformation(PolicyUpsertRequest $body, ?PolicyRequestBuilderPutRequestConfiguration $requestConfiguration = null): RequestInformation {
        $requestInfo = new RequestInformation();
        $requestInfo->urlTemplate = $this->urlTemplate;
        $requestInfo->pathParameters = $this->pathParameters;
        $requestInfo->httpMethod = HttpMethod::PUT;
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
     * @return PolicyRequestBuilder
    */
    public function withUrl(string $rawUrl): PolicyRequestBuilder {
        return new PolicyRequestBuilder($rawUrl, $this->requestAdapter);
    }

}
