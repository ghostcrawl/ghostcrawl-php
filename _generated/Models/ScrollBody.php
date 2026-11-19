<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class ScrollBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ScrollBody_direction|null $direction The direction property
    */
    private ?ScrollBody_direction $direction = null;
    
    /**
     * @var ScrollBody_distance_px|null $distance_px The distance_px property
    */
    private ?ScrollBody_distance_px $distance_px = null;
    
    /**
     * @var ScrollBody_dy|null $dy The dy property
    */
    private ?ScrollBody_dy $dy = null;
    
    /**
     * @var ScrollBody_profile_id|null $profile_id The profile_id property
    */
    private ?ScrollBody_profile_id $profile_id = null;
    
    /**
     * @var ScrollBody_selector|null $selector The selector property
    */
    private ?ScrollBody_selector $selector = null;
    
    /**
     * @var ScrollBody_session_id|null $session_id The session_id property
    */
    private ?ScrollBody_session_id $session_id = null;
    
    /**
     * Instantiates a new ScrollBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setDirection(new ScrollBody_direction('down'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrollBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrollBody {
        return new ScrollBody();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the direction property value. The direction property
     * @return ScrollBody_direction|null
    */
    public function getDirection(): ?ScrollBody_direction {
        return $this->direction;
    }

    /**
     * Gets the distance_px property value. The distance_px property
     * @return ScrollBody_distance_px|null
    */
    public function getDistancePx(): ?ScrollBody_distance_px {
        return $this->distance_px;
    }

    /**
     * Gets the dy property value. The dy property
     * @return ScrollBody_dy|null
    */
    public function getDy(): ?ScrollBody_dy {
        return $this->dy;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'direction' => fn(ParseNode $n) => $o->setDirection($n->getEnumValue(ScrollBody_direction::class)),
            'distance_px' => fn(ParseNode $n) => $o->setDistancePx($n->getObjectValue([ScrollBody_distance_px::class, 'createFromDiscriminatorValue'])),
            'dy' => fn(ParseNode $n) => $o->setDy($n->getObjectValue([ScrollBody_dy::class, 'createFromDiscriminatorValue'])),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getObjectValue([ScrollBody_profile_id::class, 'createFromDiscriminatorValue'])),
            'selector' => fn(ParseNode $n) => $o->setSelector($n->getObjectValue([ScrollBody_selector::class, 'createFromDiscriminatorValue'])),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getObjectValue([ScrollBody_session_id::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return ScrollBody_profile_id|null
    */
    public function getProfileId(): ?ScrollBody_profile_id {
        return $this->profile_id;
    }

    /**
     * Gets the selector property value. The selector property
     * @return ScrollBody_selector|null
    */
    public function getSelector(): ?ScrollBody_selector {
        return $this->selector;
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return ScrollBody_session_id|null
    */
    public function getSessionId(): ?ScrollBody_session_id {
        return $this->session_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeEnumValue('direction', $this->getDirection());
        $writer->writeObjectValue('distance_px', $this->getDistancePx());
        $writer->writeObjectValue('dy', $this->getDy());
        $writer->writeObjectValue('profile_id', $this->getProfileId());
        $writer->writeObjectValue('selector', $this->getSelector());
        $writer->writeObjectValue('session_id', $this->getSessionId());
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
     * Sets the direction property value. The direction property
     * @param ScrollBody_direction|null $value Value to set for the direction property.
    */
    public function setDirection(?ScrollBody_direction $value): void {
        $this->direction = $value;
    }

    /**
     * Sets the distance_px property value. The distance_px property
     * @param ScrollBody_distance_px|null $value Value to set for the distance_px property.
    */
    public function setDistancePx(?ScrollBody_distance_px $value): void {
        $this->distance_px = $value;
    }

    /**
     * Sets the dy property value. The dy property
     * @param ScrollBody_dy|null $value Value to set for the dy property.
    */
    public function setDy(?ScrollBody_dy $value): void {
        $this->dy = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param ScrollBody_profile_id|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?ScrollBody_profile_id $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the selector property value. The selector property
     * @param ScrollBody_selector|null $value Value to set for the selector property.
    */
    public function setSelector(?ScrollBody_selector $value): void {
        $this->selector = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param ScrollBody_session_id|null $value Value to set for the session_id property.
    */
    public function setSessionId(?ScrollBody_session_id $value): void {
        $this->session_id = $value;
    }

}
