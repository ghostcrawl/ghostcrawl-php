<?php

namespace GhostCrawl\V1\Page\Cookies;

/**
 * Get cookies
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
     * @QueryParameter("profile_id")
     * @var string|null $profileId 
    */
    public ?string $profileId = null;
    
    /**
     * Instantiates a new CookiesRequestBuilderGetQueryParameters and sets the default values.
     * @param string|null $domain 
     * @param string|null $name 
     * @param string|null $profile_id 
    */
    public function __construct(?string $domain = null, ?string $name = null, ?string $profile_id = null) {
        $this->domain = $domain;
        $this->name = $name;
        $this->profileId = $profile_id;
    }

}
