<?php

namespace GhostCrawl\V1\Queues\Item\Pop;

/**
 * read up to N items from the queue. Returns {items: [{id, url, meta}]}. Empty list when nothing available.
*/
class PopRequestBuilderGetQueryParameters 
{
    /**
     * @var int|null $count
    */
    public ?int $count = null;
    
    /**
     * Instantiates a new PopRequestBuilderGetQueryParameters and sets the default values.
     * @param int|null $count
    */
    public function __construct(?int $count = null) {
        $this->count = $count;
    }

}
