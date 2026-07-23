<?php

namespace GhostCrawl\V1\Datasets\Item\Rows;

/**
 * paginated rows from a dataset. Returns {rows: [{row_id, written_at, payload}], next_cursor}.
*/
class RowsRequestBuilderGetQueryParameters 
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
     * Instantiates a new RowsRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $cursor 
     * @param int|null $limit 
    */
    public function __construct(?string $cursor = null, ?int $limit = null) {
        $this->cursor = $cursor;
        $this->limit = $limit;
    }

}
