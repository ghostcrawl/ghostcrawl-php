<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/cdp/input body. Drives a live interactive session. ``step_type`` is one of navigate/click/type: * navigate → ``url`` * click → ``x``/``y`` (CSS px) + optional ``button`` * type → ``text``
*/
class CdpInputRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var CdpInputRequest_button|null $button The button property
    */
    private ?CdpInputRequest_button $button = null;
    
    /**
     * @var string|null $session_id The session_id property
    */
    private ?string $session_id = null;
    
    /**
     * @var CdpInputRequest_step_type|null $step_type The step_type property
    */
    private ?CdpInputRequest_step_type $step_type = null;
    
    /**
     * @var CdpInputRequest_text|null $text The text property
    */
    private ?CdpInputRequest_text $text = null;
    
    /**
     * @var CdpInputRequest_url|null $url The url property
    */
    private ?CdpInputRequest_url $url = null;
    
    /**
     * @var CdpInputRequest_wait_until|null $wait_until The wait_until property
    */
    private ?CdpInputRequest_wait_until $wait_until = null;
    
    /**
     * @var CdpInputRequest_x|null $x The x property
    */
    private ?CdpInputRequest_x $x = null;
    
    /**
     * @var CdpInputRequest_y|null $y The y property
    */
    private ?CdpInputRequest_y $y = null;
    
    /**
     * Instantiates a new CdpInputRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CdpInputRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CdpInputRequest {
        return new CdpInputRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the button property value. The button property
     * @return CdpInputRequest_button|null
    */
    public function getButton(): ?CdpInputRequest_button {
        return $this->button;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'button' => fn(ParseNode $n) => $o->setButton($n->getObjectValue([CdpInputRequest_button::class, 'createFromDiscriminatorValue'])),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getStringValue()),
            'step_type' => fn(ParseNode $n) => $o->setStepType($n->getEnumValue(CdpInputRequest_step_type::class)),
            'text' => fn(ParseNode $n) => $o->setText($n->getObjectValue([CdpInputRequest_text::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getObjectValue([CdpInputRequest_url::class, 'createFromDiscriminatorValue'])),
            'wait_until' => fn(ParseNode $n) => $o->setWaitUntil($n->getObjectValue([CdpInputRequest_wait_until::class, 'createFromDiscriminatorValue'])),
            'x' => fn(ParseNode $n) => $o->setX($n->getObjectValue([CdpInputRequest_x::class, 'createFromDiscriminatorValue'])),
            'y' => fn(ParseNode $n) => $o->setY($n->getObjectValue([CdpInputRequest_y::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return string|null
    */
    public function getSessionId(): ?string {
        return $this->session_id;
    }

    /**
     * Gets the step_type property value. The step_type property
     * @return CdpInputRequest_step_type|null
    */
    public function getStepType(): ?CdpInputRequest_step_type {
        return $this->step_type;
    }

    /**
     * Gets the text property value. The text property
     * @return CdpInputRequest_text|null
    */
    public function getText(): ?CdpInputRequest_text {
        return $this->text;
    }

    /**
     * Gets the url property value. The url property
     * @return CdpInputRequest_url|null
    */
    public function getUrl(): ?CdpInputRequest_url {
        return $this->url;
    }

    /**
     * Gets the wait_until property value. The wait_until property
     * @return CdpInputRequest_wait_until|null
    */
    public function getWaitUntil(): ?CdpInputRequest_wait_until {
        return $this->wait_until;
    }

    /**
     * Gets the x property value. The x property
     * @return CdpInputRequest_x|null
    */
    public function getX(): ?CdpInputRequest_x {
        return $this->x;
    }

    /**
     * Gets the y property value. The y property
     * @return CdpInputRequest_y|null
    */
    public function getY(): ?CdpInputRequest_y {
        return $this->y;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('button', $this->getButton());
        $writer->writeStringValue('session_id', $this->getSessionId());
        $writer->writeEnumValue('step_type', $this->getStepType());
        $writer->writeObjectValue('text', $this->getText());
        $writer->writeObjectValue('url', $this->getUrl());
        $writer->writeObjectValue('wait_until', $this->getWaitUntil());
        $writer->writeObjectValue('x', $this->getX());
        $writer->writeObjectValue('y', $this->getY());
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
     * Sets the button property value. The button property
     * @param CdpInputRequest_button|null $value Value to set for the button property.
    */
    public function setButton(?CdpInputRequest_button $value): void {
        $this->button = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param string|null $value Value to set for the session_id property.
    */
    public function setSessionId(?string $value): void {
        $this->session_id = $value;
    }

    /**
     * Sets the step_type property value. The step_type property
     * @param CdpInputRequest_step_type|null $value Value to set for the step_type property.
    */
    public function setStepType(?CdpInputRequest_step_type $value): void {
        $this->step_type = $value;
    }

    /**
     * Sets the text property value. The text property
     * @param CdpInputRequest_text|null $value Value to set for the text property.
    */
    public function setText(?CdpInputRequest_text $value): void {
        $this->text = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param CdpInputRequest_url|null $value Value to set for the url property.
    */
    public function setUrl(?CdpInputRequest_url $value): void {
        $this->url = $value;
    }

    /**
     * Sets the wait_until property value. The wait_until property
     * @param CdpInputRequest_wait_until|null $value Value to set for the wait_until property.
    */
    public function setWaitUntil(?CdpInputRequest_wait_until $value): void {
        $this->wait_until = $value;
    }

    /**
     * Sets the x property value. The x property
     * @param CdpInputRequest_x|null $value Value to set for the x property.
    */
    public function setX(?CdpInputRequest_x $value): void {
        $this->x = $value;
    }

    /**
     * Sets the y property value. The y property
     * @param CdpInputRequest_y|null $value Value to set for the y property.
    */
    public function setY(?CdpInputRequest_y $value): void {
        $this->y = $value;
    }

}
