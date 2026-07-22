<?php

namespace GhostCrawl\V1\Audit\Events;

/**
 * Returns audit events for the caller's organisation only. Requires scope. Cursor-paginated; supply the `cursor` value from the previous response to fetch the next page. Integrity chain hashes are not returned here, use the off-system chain-verification script for that.
*/
class EventsRequestBuilderGetQueryParameters 
{
    /**
     * @var string|null $action Exact-match filter on action.
    */
    public ?string $action = null;
    
    /**
     * @QueryParameter("actor_user_id")
     * @var string|null $actorUserId
    */
    public ?string $actorUserId = null;
    
    /**
     * @var string|null $cursor Opaque pagination cursor.
    */
    public ?string $cursor = null;
    
    /**
     * @var int|null $limit
    */
    public ?int $limit = null;
    
    /**
     * @var string|null $outcome
    */
    public ?string $outcome = null;
    
    /**
     * @var string|null $since Return records created on or after this timestamp.
    */
    public ?string $since = null;
    
    /**
     * @QueryParameter("target_id")
     * @var string|null $targetId
    */
    public ?string $targetId = null;
    
    /**
     * @QueryParameter("target_kind")
     * @var string|null $targetKind
    */
    public ?string $targetKind = null;
    
    /**
     * @var string|null $until Return records created before this timestamp.
    */
    public ?string $until = null;
    
    /**
     * Instantiates a new EventsRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $action Exact-match filter on action.
     * @param string|null $actor_user_id
     * @param string|null $cursor Opaque pagination cursor.
     * @param int|null $limit
     * @param string|null $outcome
     * @param string|null $since Return records created on or after this timestamp.
     * @param string|null $target_id
     * @param string|null $target_kind
     * @param string|null $until Return records created before this timestamp.
    */
    public function __construct(?string $action = null, ?string $actor_user_id = null, ?string $cursor = null, ?int $limit = null, ?string $outcome = null, ?string $since = null, ?string $target_id = null, ?string $target_kind = null, ?string $until = null) {
        $this->action = $action;
        $this->actorUserId = $actor_user_id;
        $this->cursor = $cursor;
        $this->limit = $limit;
        $this->outcome = $outcome;
        $this->since = $since;
        $this->targetId = $target_id;
        $this->targetKind = $target_kind;
        $this->until = $until;
    }

}
