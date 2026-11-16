<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class ArrivalBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $dest_url The dest_url property
    */
    private ?string $dest_url = null;
    
    /**
     * @var ArrivalBody_profile_id|null $profile_id The profile_id property
    */
    private ?ArrivalBody_profile_id $profile_id = null;
    
    /**
     * @var ArrivalBody_referrer_shape|null $referrer_shape The referrer_shape property
    */
    private ?ArrivalBody_referrer_shape $referrer_shape = null;
    
    /**
     * @var ArrivalBody_session_id|null $session_id The session_id property
    */
    private ?ArrivalBody_session_id $session_id = null;
    
    /**
     * @var string|null $source_title The source_title property
    */
    private ?string $source_title = null;
    
    /**
     * @var string|null $source_url The source_url property
    */
    private ?string $source_url = null;
    
    /**
     * Instantiates a new ArrivalBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setReferrerShape(new ArrivalBody_referrer_shape('origin'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ArrivalBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ArrivalBody {
        return new ArrivalBody();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the dest_url property value. The dest_url property
     * @return string|null
    */
    public function getDestUrl(): ?string {
        return $this->dest_url;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'dest_url' => fn(ParseNode $n) => $o->setDestUrl($n->getStringValue()),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getObjectValue([ArrivalBody_profile_id::class, 'createFromDiscriminatorValue'])),
            'referrer_shape' => fn(ParseNode $n) => $o->setReferrerShape($n->getEnumValue(ArrivalBody_referrer_shape::class)),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getObjectValue([ArrivalBody_session_id::class, 'createFromDiscriminatorValue'])),
            'source_title' => fn(ParseNode $n) => $o->setSourceTitle($n->getStringValue()),
            'source_url' => fn(ParseNode $n) => $o->setSourceUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return ArrivalBody_profile_id|null
    */
    public function getProfileId(): ?ArrivalBody_profile_id {
        return $this->profile_id;
    }

    /**
     * Gets the referrer_shape property value. The referrer_shape property
     * @return ArrivalBody_referrer_shape|null
    */
    public function getReferrerShape(): ?ArrivalBody_referrer_shape {
        return $this->referrer_shape;
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return ArrivalBody_session_id|null
    */
    public function getSessionId(): ?ArrivalBody_session_id {
        return $this->session_id;
    }

    /**
     * Gets the source_title property value. The source_title property
     * @return string|null
    */
    public function getSourceTitle(): ?string {
        return $this->source_title;
    }

    /**
     * Gets the source_url property value. The source_url property
     * @return string|null
    */
    public function getSourceUrl(): ?string {
        return $this->source_url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('dest_url', $this->getDestUrl());
        $writer->writeObjectValue('profile_id', $this->getProfileId());
        $writer->writeEnumValue('referrer_shape', $this->getReferrerShape());
        $writer->writeObjectValue('session_id', $this->getSessionId());
        $writer->writeStringValue('source_title', $this->getSourceTitle());
        $writer->writeStringValue('source_url', $this->getSourceUrl());
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
     * Sets the dest_url property value. The dest_url property
     * @param string|null $value Value to set for the dest_url property.
    */
    public function setDestUrl(?string $value): void {
        $this->dest_url = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param ArrivalBody_profile_id|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?ArrivalBody_profile_id $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the referrer_shape property value. The referrer_shape property
     * @param ArrivalBody_referrer_shape|null $value Value to set for the referrer_shape property.
    */
    public function setReferrerShape(?ArrivalBody_referrer_shape $value): void {
        $this->referrer_shape = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param ArrivalBody_session_id|null $value Value to set for the session_id property.
    */
    public function setSessionId(?ArrivalBody_session_id $value): void {
        $this->session_id = $value;
    }

    /**
     * Sets the source_title property value. The source_title property
     * @param string|null $value Value to set for the source_title property.
    */
    public function setSourceTitle(?string $value): void {
        $this->source_title = $value;
    }

    /**
     * Sets the source_url property value. The source_url property
     * @param string|null $value Value to set for the source_url property.
    */
    public function setSourceUrl(?string $value): void {
        $this->source_url = $value;
    }

}
