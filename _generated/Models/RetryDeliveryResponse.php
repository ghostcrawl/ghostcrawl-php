<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Response for POST /v1/webhooks/{id}/deliveries/{delivery_id}/retry (202 Accepted). The original event_id is preserved so downstream consumers can detect the retry; a fresh delivery_id is assigned for the new attempt.
*/
class RetryDeliveryResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var DateTime|null $enqueued_at The enqueued_at property
    */
    private ?DateTime $enqueued_at = null;
    
    /**
     * @var string|null $new_delivery_id The new_delivery_id property
    */
    private ?string $new_delivery_id = null;
    
    /**
     * @var string|null $original_delivery_id The original_delivery_id property
    */
    private ?string $original_delivery_id = null;
    
    /**
     * @var string|null $webhook_id The webhook_id property
    */
    private ?string $webhook_id = null;
    
    /**
     * Instantiates a new RetryDeliveryResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return RetryDeliveryResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): RetryDeliveryResponse {
        return new RetryDeliveryResponse();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the enqueued_at property value. The enqueued_at property
     * @return DateTime|null
    */
    public function getEnqueuedAt(): ?DateTime {
        return $this->enqueued_at;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'enqueued_at' => fn(ParseNode $n) => $o->setEnqueuedAt($n->getDateTimeValue()),
            'new_delivery_id' => fn(ParseNode $n) => $o->setNewDeliveryId($n->getStringValue()),
            'original_delivery_id' => fn(ParseNode $n) => $o->setOriginalDeliveryId($n->getStringValue()),
            'webhook_id' => fn(ParseNode $n) => $o->setWebhookId($n->getStringValue()),
        ];
    }

    /**
     * Gets the new_delivery_id property value. The new_delivery_id property
     * @return string|null
    */
    public function getNewDeliveryId(): ?string {
        return $this->new_delivery_id;
    }

    /**
     * Gets the original_delivery_id property value. The original_delivery_id property
     * @return string|null
    */
    public function getOriginalDeliveryId(): ?string {
        return $this->original_delivery_id;
    }

    /**
     * Gets the webhook_id property value. The webhook_id property
     * @return string|null
    */
    public function getWebhookId(): ?string {
        return $this->webhook_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeDateTimeValue('enqueued_at', $this->getEnqueuedAt());
        $writer->writeStringValue('new_delivery_id', $this->getNewDeliveryId());
        $writer->writeStringValue('original_delivery_id', $this->getOriginalDeliveryId());
        $writer->writeStringValue('webhook_id', $this->getWebhookId());
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
     * Sets the enqueued_at property value. The enqueued_at property
     * @param DateTime|null $value Value to set for the enqueued_at property.
    */
    public function setEnqueuedAt(?DateTime $value): void {
        $this->enqueued_at = $value;
    }

    /**
     * Sets the new_delivery_id property value. The new_delivery_id property
     * @param string|null $value Value to set for the new_delivery_id property.
    */
    public function setNewDeliveryId(?string $value): void {
        $this->new_delivery_id = $value;
    }

    /**
     * Sets the original_delivery_id property value. The original_delivery_id property
     * @param string|null $value Value to set for the original_delivery_id property.
    */
    public function setOriginalDeliveryId(?string $value): void {
        $this->original_delivery_id = $value;
    }

    /**
     * Sets the webhook_id property value. The webhook_id property
     * @param string|null $value Value to set for the webhook_id property.
    */
    public function setWebhookId(?string $value): void {
        $this->webhook_id = $value;
    }

}
