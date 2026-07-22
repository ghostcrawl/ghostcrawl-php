<?php

namespace GhostCrawl\V1\StorageStates;

/**
 * owner-scoped cursor pagination.
*/
class StorageStatesRequestBuilderGetQueryParameters 
{
    /**
     * @var string|null $cursor
    */
    public ?string $cursor = null;
    
    /**
     * @var int|null $limit
    */
    public ?int $limit = null;
    
    /**
     * Instantiates a new StorageStatesRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $cursor
     * @param int|null $limit
    */
    public function __construct(?string $cursor = null, ?int $limit = null) {
        $this->cursor = $cursor;
        $this->limit = $limit;
    }

}
