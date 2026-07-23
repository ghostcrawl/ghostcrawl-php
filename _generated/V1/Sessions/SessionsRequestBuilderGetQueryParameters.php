<?php

namespace GhostCrawl\V1\Sessions;

/**
 * cursor-paginated listing of active sessions. Sessions created by scrape workers and via the API are unified in the same listing, all sessions for your organisation are visible. Results are strictly; no cross-organisation sessions are returned.
*/
class SessionsRequestBuilderGetQueryParameters 
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
     * @var string|null $tags 
    */
    public ?string $tags = null;
    
    /**
     * Instantiates a new SessionsRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $created_at_from 
     * @param string|null $created_at_to 
     * @param string|null $cursor 
     * @param int|null $limit 
     * @param string|null $tags 
    */
    public function __construct(?string $created_at_from = null, ?string $created_at_to = null, ?string $cursor = null, ?int $limit = null, ?string $tags = null) {
        $this->createdAtFrom = $created_at_from;
        $this->createdAtTo = $created_at_to;
        $this->cursor = $cursor;
        $this->limit = $limit;
        $this->tags = $tags;
    }

}
