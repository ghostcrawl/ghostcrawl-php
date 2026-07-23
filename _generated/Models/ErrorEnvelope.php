<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class ErrorEnvelope extends ApiException implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $detail The detail property
    */
    private ?string $detail = null;
    
    /**
     * @var string|null $error The error property
    */
    private ?string $error = null;
    
    /**
     * @var string|null $field The field property
    */
    private ?string $field = null;
    
    /**
     * @var string|null $lane The lane property
    */
    private ?string $lane = null;
    
    /**
     * @var ErrorEnvelope_limits|null $limits The limits property
    */
    private ?ErrorEnvelope_limits $limits = null;
    
    /**
     * @var bool|null $ok The ok property
    */
    private ?bool $ok = null;
    
    /**
     * @var string|null $reason The reason property
    */
    private ?string $reason = null;
    
    /**
     * @var string|null $route The route property
    */
    private ?string $route = null;
    
    /**
     * @var string|null $session_id The session_id property
    */
    private ?string $session_id = null;
    
    /**
     * @var int|null $status The status property
    */
    private ?int $status = null;
    
    /**
     * Instantiates a new ErrorEnvelope and sets the default values.
    */
    public function __construct() {
        parent::__construct();
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ErrorEnvelope
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ErrorEnvelope {
        return new ErrorEnvelope();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the detail property value. The detail property
     * @return string|null
    */
    public function getDetail(): ?string {
        return $this->detail;
    }

    /**
     * Gets the error property value. The error property
     * @return string|null
    */
    public function getError(): ?string {
        return $this->error;
    }

    /**
     * Gets the field property value. The field property
     * @return string|null
    */
    public function getField(): ?string {
        return $this->field;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'detail' => fn(ParseNode $n) => $o->setDetail($n->getStringValue()),
            'error' => fn(ParseNode $n) => $o->setError($n->getStringValue()),
            'field' => fn(ParseNode $n) => $o->setField($n->getStringValue()),
            'lane' => fn(ParseNode $n) => $o->setLane($n->getStringValue()),
            'limits' => fn(ParseNode $n) => $o->setLimits($n->getObjectValue([ErrorEnvelope_limits::class, 'createFromDiscriminatorValue'])),
            'ok' => fn(ParseNode $n) => $o->setOk($n->getBooleanValue()),
            'reason' => fn(ParseNode $n) => $o->setReason($n->getStringValue()),
            'route' => fn(ParseNode $n) => $o->setRoute($n->getStringValue()),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getStringValue()),
            'status' => fn(ParseNode $n) => $o->setStatus($n->getIntegerValue()),
        ];
    }

    /**
     * Gets the lane property value. The lane property
     * @return string|null
    */
    public function getLane(): ?string {
        return $this->lane;
    }

    /**
     * Gets the limits property value. The limits property
     * @return ErrorEnvelope_limits|null
    */
    public function getLimits(): ?ErrorEnvelope_limits {
        return $this->limits;
    }

    /**
     * Gets the ok property value. The ok property
     * @return bool|null
    */
    public function getOk(): ?bool {
        return $this->ok;
    }

    /**
     * The primary error message.
     * @return string
    */
    public function getPrimaryErrorMessage(): string {
        return parent::getMessage();
    }

    /**
     * Gets the reason property value. The reason property
     * @return string|null
    */
    public function getReason(): ?string {
        return $this->reason;
    }

    /**
     * Gets the route property value. The route property
     * @return string|null
    */
    public function getRoute(): ?string {
        return $this->route;
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return string|null
    */
    public function getSessionId(): ?string {
        return $this->session_id;
    }

    /**
     * Gets the status property value. The status property
     * @return int|null
    */
    public function getStatus(): ?int {
        return $this->status;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('detail', $this->getDetail());
        $writer->writeStringValue('error', $this->getError());
        $writer->writeStringValue('field', $this->getField());
        $writer->writeStringValue('lane', $this->getLane());
        $writer->writeObjectValue('limits', $this->getLimits());
        $writer->writeBooleanValue('ok', $this->getOk());
        $writer->writeStringValue('reason', $this->getReason());
        $writer->writeStringValue('route', $this->getRoute());
        $writer->writeStringValue('session_id', $this->getSessionId());
        $writer->writeIntegerValue('status', $this->getStatus());
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
     * Sets the detail property value. The detail property
     * @param string|null $value Value to set for the detail property.
    */
    public function setDetail(?string $value): void {
        $this->detail = $value;
    }

    /**
     * Sets the error property value. The error property
     * @param string|null $value Value to set for the error property.
    */
    public function setError(?string $value): void {
        $this->error = $value;
    }

    /**
     * Sets the field property value. The field property
     * @param string|null $value Value to set for the field property.
    */
    public function setField(?string $value): void {
        $this->field = $value;
    }

    /**
     * Sets the lane property value. The lane property
     * @param string|null $value Value to set for the lane property.
    */
    public function setLane(?string $value): void {
        $this->lane = $value;
    }

    /**
     * Sets the limits property value. The limits property
     * @param ErrorEnvelope_limits|null $value Value to set for the limits property.
    */
    public function setLimits(?ErrorEnvelope_limits $value): void {
        $this->limits = $value;
    }

    /**
     * Sets the ok property value. The ok property
     * @param bool|null $value Value to set for the ok property.
    */
    public function setOk(?bool $value): void {
        $this->ok = $value;
    }

    /**
     * Sets the reason property value. The reason property
     * @param string|null $value Value to set for the reason property.
    */
    public function setReason(?string $value): void {
        $this->reason = $value;
    }

    /**
     * Sets the route property value. The route property
     * @param string|null $value Value to set for the route property.
    */
    public function setRoute(?string $value): void {
        $this->route = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param string|null $value Value to set for the session_id property.
    */
    public function setSessionId(?string $value): void {
        $this->session_id = $value;
    }

    /**
     * Sets the status property value. The status property
     * @param int|null $value Value to set for the status property.
    */
    public function setStatus(?int $value): void {
        $this->status = $value;
    }

}
