<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class TabVisitBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var float|null $dwell_s The dwell_s property
    */
    private ?float $dwell_s = null;
    
    /**
     * @var TabVisitBody_profile_id|null $profile_id The profile_id property
    */
    private ?TabVisitBody_profile_id $profile_id = null;
    
    /**
     * @var TabVisitBody_session_id|null $session_id The session_id property
    */
    private ?TabVisitBody_session_id $session_id = null;
    
    /**
     * @var string|null $url The url property
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new TabVisitBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setDwellS(3);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return TabVisitBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TabVisitBody {
        return new TabVisitBody();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the dwell_s property value. The dwell_s property
     * @return float|null
    */
    public function getDwellS(): ?float {
        return $this->dwell_s;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'dwell_s' => fn(ParseNode $n) => $o->setDwellS($n->getFloatValue()),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getObjectValue([TabVisitBody_profile_id::class, 'createFromDiscriminatorValue'])),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getObjectValue([TabVisitBody_session_id::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return TabVisitBody_profile_id|null
    */
    public function getProfileId(): ?TabVisitBody_profile_id {
        return $this->profile_id;
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return TabVisitBody_session_id|null
    */
    public function getSessionId(): ?TabVisitBody_session_id {
        return $this->session_id;
    }

    /**
     * Gets the url property value. The url property
     * @return string|null
    */
    public function getUrl(): ?string {
        return $this->url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeFloatValue('dwell_s', $this->getDwellS());
        $writer->writeObjectValue('profile_id', $this->getProfileId());
        $writer->writeObjectValue('session_id', $this->getSessionId());
        $writer->writeStringValue('url', $this->getUrl());
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
     * Sets the dwell_s property value. The dwell_s property
     * @param float|null $value Value to set for the dwell_s property.
    */
    public function setDwellS(?float $value): void {
        $this->dwell_s = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param TabVisitBody_profile_id|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?TabVisitBody_profile_id $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param TabVisitBody_session_id|null $value Value to set for the session_id property.
    */
    public function setSessionId(?TabVisitBody_session_id $value): void {
        $this->session_id = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
