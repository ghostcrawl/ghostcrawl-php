<?php

namespace GhostCrawl\V1\CrawlRuns\Item;

/**
 * status, plus OPT-IN long-poll. Default (``wait`` absent/false): instant status snapshot, behavior unchanged. ``?wait=true&timeout_s=N``: BLOCKS event-driven (same cross-worker `` signal as start-and-wait) until the run reaches a terminal state (completed|cancelled|failed|failed_resumable) or ``timeout_s`` elapses, THEN returns the run record (results included when completed). A timeout returns the CURRENT non-terminal run as HTTP 200, a long-poll, NOT an error. ``timeout_s`` defaults to 300 and is capped at a server-configured maximum (default 600).
*/
class WithRun_ItemRequestBuilderGetQueryParameters 
{
    /**
     * @QueryParameter("timeout_s")
     * @var int|null $timeoutS 
    */
    public ?int $timeoutS = null;
    
    /**
     * @var bool|null $wait 
    */
    public ?bool $wait = null;
    
    /**
     * Instantiates a new WithRun_ItemRequestBuilderGetQueryParameters and sets the default values.
     * @param int|null $timeout_s 
     * @param bool|null $wait 
    */
    public function __construct(?int $timeout_s = null, ?bool $wait = null) {
        $this->timeoutS = $timeout_s;
        $this->wait = $wait;
    }

}
