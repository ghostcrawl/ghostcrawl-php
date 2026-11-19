<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class CookiesSetBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var array<CookieDict>|null $cookies The cookies property
    */
    private ?array $cookies = null;
    
    /**
     * @var CookiesSetBody_profile_id|null $profile_id The profile_id property
    */
    private ?CookiesSetBody_profile_id $profile_id = null;
    
    /**
     * @var string|null $session_id The session_id property
    */
    private ?string $session_id = null;
    
    /**
     * Instantiates a new CookiesSetBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookiesSetBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookiesSetBody {
        return new CookiesSetBody();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the cookies property value. The cookies property
     * @return array<CookieDict>|null
    */
    public function getCookies(): ?array {
        return $this->cookies;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'cookies' => fn(ParseNode $n) => $o->setCookies($n->getCollectionOfObjectValues([CookieDict::class, 'createFromDiscriminatorValue'])),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getObjectValue([CookiesSetBody_profile_id::class, 'createFromDiscriminatorValue'])),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getStringValue()),
        ];
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return CookiesSetBody_profile_id|null
    */
    public function getProfileId(): ?CookiesSetBody_profile_id {
        return $this->profile_id;
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return string|null
    */
    public function getSessionId(): ?string {
        return $this->session_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfObjectValues('cookies', $this->getCookies());
        $writer->writeObjectValue('profile_id', $this->getProfileId());
        $writer->writeStringValue('session_id', $this->getSessionId());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the cookies property value. The cookies property
     * @param array<CookieDict>|null $value Value to set for the cookies property.
    */
    public function setCookies(?array $value): void {
        $this->cookies = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param CookiesSetBody_profile_id|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?CookiesSetBody_profile_id $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param string|null $value Value to set for the session_id property.
    */
    public function setSessionId(?string $value): void {
        $this->session_id = $value;
    }

}
