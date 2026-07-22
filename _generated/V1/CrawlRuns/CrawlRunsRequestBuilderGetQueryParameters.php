<?php

namespace GhostCrawl\V1\CrawlRuns;

/**
 * cursor pagination. This is the one explicit breaking shapechange in; no SDK consumers shipped against the old shape. owner_id requires crawl:admin scope to be honored. created_at_from > created_at_to → 400 (not 422). Error envelope for 403 unchanged (at error layer).
*/
class CrawlRunsRequestBuilderGetQueryParameters 
{
    /**
     * @QueryParameter("created_at_from")
     * @var string|null $createdAtFrom
    */
    public ?string $createdAtFrom = null;
    
    /**
     * @QueryParameter("created_at_to")
     * @var string|null $createdAtTo
    */
    public ?string $createdAtTo = null;
    
    /**
     * @var string|null $cursor
    */
    public ?string $cursor = null;
    
    /**
     * @var int|null $limit
    */
    public ?int $limit = null;
    
    /**
     * @QueryParameter("owner_id")
     * @var string|null $ownerId
    */
    public ?string $ownerId = null;
    
    /**
     * @var string|null $tags
    */
    public ?string $tags = null;
    
    /**
     * Instantiates a new CrawlRunsRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $created_at_from
     * @param string|null $created_at_to
     * @param string|null $cursor
     * @param int|null $limit
     * @param string|null $owner_id
     * @param string|null $tags
    */
    public function __construct(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $owner_id = null, ?string $tags = null) {
        $this->createdAtFrom = $created_at_from;
        $this->createdAtTo = $created_at_to;
        $this->cursor = $cursor;
        $this->limit = $limit;
        $this->ownerId = $owner_id;
        $this->tags = $tags;
    }

}
