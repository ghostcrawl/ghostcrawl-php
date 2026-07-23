<?php

namespace GhostCrawl\V1\Recordings\Item\Visual\Frames;

/**
 * List paginated frame references for frame-by-frame replay. next_cursor == -1 means no more pages.
*/
class FramesRequestBuilderGetQueryParameters 
{
    /**
     * @var int|null $cursor Start frame index (cursor-paginated)
    */
    public ?int $cursor = null;
    
    /**
     * @var int|null $limit Max frames per page
    */
    public ?int $limit = null;
    
    /**
     * Instantiates a new FramesRequestBuilderGetQueryParameters and sets the default values.
     * @param int|null $cursor Start frame index (cursor-paginated)
     * @param int|null $limit Max frames per page
    */
    public function __construct(?int $cursor = null, ?int $limit = null) {
        $this->cursor = $cursor;
        $this->limit = $limit;
    }

}
