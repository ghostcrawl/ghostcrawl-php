<?php

namespace GhostCrawl\V1\Recordings;

/**
 * cursor pagination. response gains total_count (additive); items[*] shape unchanged. owner_id filter requires recordings:admin scope to be honored; without it, the filter is silently dropped (not 403). created_at_from > created_at_to → 400 (not 422). tier gate NOT applied at list layer.
*/
class RecordingsRequestBuilderGetQueryParameters 
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
     * Instantiates a new RecordingsRequestBuilderGetQueryParameters and sets the default values.
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
