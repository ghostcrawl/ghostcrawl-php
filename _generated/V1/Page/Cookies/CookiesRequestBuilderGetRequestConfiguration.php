<?php

namespace GhostCrawl\V1\Page\Cookies;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class CookiesRequestBuilderGetRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var CookiesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public ?CookiesRequestBuilderGetQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new CookiesRequestBuilderGetRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param CookiesRequestBuilderGetQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?CookiesRequestBuilderGetQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new CookiesRequestBuilderGetQueryParameters.
     * @param string|null $domain
     * @param string|null $name
     * @param string|null $profile_id
     * @return CookiesRequestBuilderGetQueryParameters
    */
    public static function createQueryParameters(?string $domain = null, ?string $name = null, ?string $profile_id = null): CookiesRequestBuilderGetQueryParameters {
        return new CookiesRequestBuilderGetQueryParameters($domain, $name, $profile_id);
    }

}
