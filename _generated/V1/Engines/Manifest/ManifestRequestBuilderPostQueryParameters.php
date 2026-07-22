<?php

namespace GhostCrawl\V1\Engines\Manifest;

/**
 * Return a license-bound short-TTL pre-signed engine manifest.
*/
class ManifestRequestBuilderPostQueryParameters 
{
    /**
     * @var string|null $channel
    */
    public ?string $channel = null;
    
    /**
     * @var string|null $platform Override body's platform value
    */
    public ?string $platform = null;
    
    /**
     * Instantiates a new ManifestRequestBuilderPostQueryParameters and sets the default values.
     * @param string|null $channel
     * @param string|null $platform Override body's platform value
    */
    public function __construct(?string $channel = null, ?string $platform = null) {
        $this->channel = $channel;
        $this->platform = $platform;
    }

}
