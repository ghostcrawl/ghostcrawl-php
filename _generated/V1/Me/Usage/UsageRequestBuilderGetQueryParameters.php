<?php

namespace GhostCrawl\V1\Me\Usage;

/**
 * Return cost/usage report scoped strictly to caller's primary_team_id.
*/
class UsageRequestBuilderGetQueryParameters 
{
    /**
     * @var GetPeriodQueryParameterType|null $period
    */
    public ?GetPeriodQueryParameterType $period = null;
    
    /**
     * Instantiates a new UsageRequestBuilderGetQueryParameters and sets the default values.
     * @param GetPeriodQueryParameterType|null $period
    */
    public function __construct(?GetPeriodQueryParameterType $period = null) {
        $this->period = $period;
    }

}
