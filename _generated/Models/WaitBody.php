<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class WaitBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $profile_id The profile_id property
    */
    private ?string $profile_id = null;
    
    /**
     * @var WaitBody_selector|null $selector The selector property
    */
    private ?WaitBody_selector $selector = null;
    
    /**
     * @var int|null $timeout_ms The timeout_ms property
    */
    private ?int $timeout_ms = null;
    
    /**
     * Instantiates a new WaitBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setTimeoutMs(30000);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WaitBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WaitBody {
        return new WaitBody();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getStringValue()),
            'selector' => fn(ParseNode $n) => $o->setSelector($n->getObjectValue([WaitBody_selector::class, 'createFromDiscriminatorValue'])),
            'timeout_ms' => fn(ParseNode $n) => $o->setTimeoutMs($n->getIntegerValue()),
        ];
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return string|null
    */
    public function getProfileId(): ?string {
        return $this->profile_id;
    }

    /**
     * Gets the selector property value. The selector property
     * @return WaitBody_selector|null
    */
    public function getSelector(): ?WaitBody_selector {
        return $this->selector;
    }

    /**
     * Gets the timeout_ms property value. The timeout_ms property
     * @return int|null
    */
    public function getTimeoutMs(): ?int {
        return $this->timeout_ms;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('profile_id', $this->getProfileId());
        $writer->writeObjectValue('selector', $this->getSelector());
        $writer->writeIntegerValue('timeout_ms', $this->getTimeoutMs());
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
     * Sets the profile_id property value. The profile_id property
     * @param string|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?string $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the selector property value. The selector property
     * @param WaitBody_selector|null $value Value to set for the selector property.
    */
    public function setSelector(?WaitBody_selector $value): void {
        $this->selector = $value;
    }

    /**
     * Sets the timeout_ms property value. The timeout_ms property
     * @param int|null $value Value to set for the timeout_ms property.
    */
    public function setTimeoutMs(?int $value): void {
        $this->timeout_ms = $value;
    }

}
