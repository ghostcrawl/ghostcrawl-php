<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class ErrorEnvelope_limits implements AdditionalDataHolder, Parsable 
{
    /**
     * @var int|null $active The active property
    */
    private ?int $active = null;
    
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var int|null $max_active The max_active property
    */
    private ?int $max_active = null;
    
    /**
     * @var int|null $max_queue The max_queue property
    */
    private ?int $max_queue = null;
    
    /**
     * @var int|null $queued The queued property
    */
    private ?int $queued = null;
    
    /**
     * @var string|null $reason The reason property
    */
    private ?string $reason = null;
    
    /**
     * Instantiates a new ErrorEnvelope_limits and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ErrorEnvelope_limits
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ErrorEnvelope_limits {
        return new ErrorEnvelope_limits();
    }

    /**
     * Gets the active property value. The active property
     * @return int|null
    */
    public function getActive(): ?int {
        return $this->active;
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
            'active' => fn(ParseNode $n) => $o->setActive($n->getIntegerValue()),
            'max_active' => fn(ParseNode $n) => $o->setMaxActive($n->getIntegerValue()),
            'max_queue' => fn(ParseNode $n) => $o->setMaxQueue($n->getIntegerValue()),
            'queued' => fn(ParseNode $n) => $o->setQueued($n->getIntegerValue()),
            'reason' => fn(ParseNode $n) => $o->setReason($n->getStringValue()),
        ];
    }

    /**
     * Gets the max_active property value. The max_active property
     * @return int|null
    */
    public function getMaxActive(): ?int {
        return $this->max_active;
    }

    /**
     * Gets the max_queue property value. The max_queue property
     * @return int|null
    */
    public function getMaxQueue(): ?int {
        return $this->max_queue;
    }

    /**
     * Gets the queued property value. The queued property
     * @return int|null
    */
    public function getQueued(): ?int {
        return $this->queued;
    }

    /**
     * Gets the reason property value. The reason property
     * @return string|null
    */
    public function getReason(): ?string {
        return $this->reason;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeIntegerValue('active', $this->getActive());
        $writer->writeIntegerValue('max_active', $this->getMaxActive());
        $writer->writeIntegerValue('max_queue', $this->getMaxQueue());
        $writer->writeIntegerValue('queued', $this->getQueued());
        $writer->writeStringValue('reason', $this->getReason());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the active property value. The active property
     * @param int|null $value Value to set for the active property.
    */
    public function setActive(?int $value): void {
        $this->active = $value;
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the max_active property value. The max_active property
     * @param int|null $value Value to set for the max_active property.
    */
    public function setMaxActive(?int $value): void {
        $this->max_active = $value;
    }

    /**
     * Sets the max_queue property value. The max_queue property
     * @param int|null $value Value to set for the max_queue property.
    */
    public function setMaxQueue(?int $value): void {
        $this->max_queue = $value;
    }

    /**
     * Sets the queued property value. The queued property
     * @param int|null $value Value to set for the queued property.
    */
    public function setQueued(?int $value): void {
        $this->queued = $value;
    }

    /**
     * Sets the reason property value. The reason property
     * @param string|null $value Value to set for the reason property.
    */
    public function setReason(?string $value): void {
        $this->reason = $value;
    }

}
