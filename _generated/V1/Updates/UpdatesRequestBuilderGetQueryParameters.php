<?php

namespace GhostCrawl\V1\Updates;

/**
 * Check if a newer release tag is available. Returns: JSON with ``newer_available``, ``newer_tag``, ``release_notes_url``.
*/
class UpdatesRequestBuilderGetQueryParameters 
{
    /**
     * @var string|null $current Currently installed tag, e.g. v1. 8. 0
    */
    public ?string $current = null;
    
    /**
     * Instantiates a new UpdatesRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $current Currently installed tag, e.g. v1. 8. 0
    */
    public function __construct(?string $current = null) {
        $this->current = $current;
    }

}
