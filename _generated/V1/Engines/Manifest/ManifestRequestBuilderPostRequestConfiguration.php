<?php

namespace GhostCrawl\V1\Engines\Manifest;

use Microsoft\Kiota\Abstractions\BaseRequestConfiguration;
use Microsoft\Kiota\Abstractions\RequestOption;

/**
 * Configuration for the request such as headers, query parameters, and middleware options.
*/
class ManifestRequestBuilderPostRequestConfiguration extends BaseRequestConfiguration 
{
    /**
     * @var ManifestRequestBuilderPostQueryParameters|null $queryParameters Request query parameters
    */
    public ?ManifestRequestBuilderPostQueryParameters $queryParameters = null;
    
    /**
     * Instantiates a new ManifestRequestBuilderPostRequestConfiguration and sets the default values.
     * @param array<string, array<string>|string>|null $headers Request headers
     * @param array<RequestOption>|null $options Request options
     * @param ManifestRequestBuilderPostQueryParameters|null $queryParameters Request query parameters
    */
    public function __construct(?array $headers = null, ?array $options = null, ?ManifestRequestBuilderPostQueryParameters $queryParameters = null) {
        parent::__construct($headers ?? [], $options ?? []);
        $this->queryParameters = $queryParameters;
    }

    /**
     * Instantiates a new ManifestRequestBuilderPostQueryParameters.
     * @param string|null $channel
     * @param string|null $platform Override body's platform value
     * @return ManifestRequestBuilderPostQueryParameters
    */
    public static function createQueryParameters(?string $channel = null, ?string $platform = null): ManifestRequestBuilderPostQueryParameters {
        return new ManifestRequestBuilderPostQueryParameters($channel, $platform);
    }

}
