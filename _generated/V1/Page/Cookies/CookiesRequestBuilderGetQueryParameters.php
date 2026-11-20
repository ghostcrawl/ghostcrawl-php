<?php

namespace GhostCrawl\V1\Page\Cookies;

/**
 * Read cookies from the browser context of a live cloud session. Optionally filter by cookie ``name`` and/or ``domain``.
*/
class CookiesRequestBuilderGetQueryParameters 
{
    /**
     * @var string|null $domain
    */
    public ?string $domain = null;
    
    /**
     * @var string|null $name
    */
    public ?string $name = null;
    
    /**
     * @QueryParameter("session_id")
     * @var string|null $sessionId
    */
    public ?string $sessionId = null;
    
    /**
     * Instantiates a new CookiesRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $domain
     * @param string|null $name
     * @param string|null $session_id
    */
    public function __construct(?string $domain = null, ?string $name = null, ?string $session_id = null) {
        $this->domain = $domain;
        $this->name = $name;
        $this->sessionId = $session_id;
    }

}
