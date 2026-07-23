<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Wire-public delivery log representation. 13 wire-public fields per webhook_deliveries schema. All fields are operator/integrator-facing, no secret material.
*/
class WebhookDeliveryPublic implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var int|null $attempt The attempt property
    */
    private ?int $attempt = null;
    
    /**
     * @var WebhookDeliveryPublic_delivered_at|null $delivered_at The delivered_at property
    */
    private ?WebhookDeliveryPublic_delivered_at $delivered_at = null;
    
    /**
     * @var DateTime|null $enqueued_at The enqueued_at property
    */
    private ?DateTime $enqueued_at = null;
    
    /**
     * @var WebhookDeliveryPublic_error_class|null $error_class The error_class property
    */
    private ?WebhookDeliveryPublic_error_class $error_class = null;
    
    /**
     * @var string|null $event_id The event_id property
    */
    private ?string $event_id = null;
    
    /**
     * @var string|null $event_type The event_type property
    */
    private ?string $event_type = null;
    
    /**
     * @var string|null $id The id property
    */
    private ?string $id = null;
    
    /**
     * @var string|null $org_id The org_id property
    */
    private ?string $org_id = null;
    
    /**
     * @var WebhookDeliveryPublic_replay_of|null $replay_of The replay_of property
    */
    private ?WebhookDeliveryPublic_replay_of $replay_of = null;
    
    /**
     * @var WebhookDeliveryPublic_response_body_preview|null $response_body_preview The response_body_preview property
    */
    private ?WebhookDeliveryPublic_response_body_preview $response_body_preview = null;
    
    /**
     * @var WebhookDeliveryPublic_response_status|null $response_status The response_status property
    */
    private ?WebhookDeliveryPublic_response_status $response_status = null;
    
    /**
     * @var string|null $status The status property
    */
    private ?string $status = null;
    
    /**
     * @var string|null $webhook_id The webhook_id property
    */
    private ?string $webhook_id = null;
    
    /**
     * Instantiates a new WebhookDeliveryPublic and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryPublic
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryPublic {
        return new WebhookDeliveryPublic();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the attempt property value. The attempt property
     * @return int|null
    */
    public function getAttempt(): ?int {
        return $this->attempt;
    }

    /**
     * Gets the delivered_at property value. The delivered_at property
     * @return WebhookDeliveryPublic_delivered_at|null
    */
    public function getDeliveredAt(): ?WebhookDeliveryPublic_delivered_at {
        return $this->delivered_at;
    }

    /**
     * Gets the enqueued_at property value. The enqueued_at property
     * @return DateTime|null
    */
    public function getEnqueuedAt(): ?DateTime {
        return $this->enqueued_at;
    }

    /**
     * Gets the error_class property value. The error_class property
     * @return WebhookDeliveryPublic_error_class|null
    */
    public function getErrorClass(): ?WebhookDeliveryPublic_error_class {
        return $this->error_class;
    }

    /**
     * Gets the event_id property value. The event_id property
     * @return string|null
    */
    public function getEventId(): ?string {
        return $this->event_id;
    }

    /**
     * Gets the event_type property value. The event_type property
     * @return string|null
    */
    public function getEventType(): ?string {
        return $this->event_type;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'attempt' => fn(ParseNode $n) => $o->setAttempt($n->getIntegerValue()),
            'delivered_at' => fn(ParseNode $n) => $o->setDeliveredAt($n->getObjectValue([WebhookDeliveryPublic_delivered_at::class, 'createFromDiscriminatorValue'])),
            'enqueued_at' => fn(ParseNode $n) => $o->setEnqueuedAt($n->getDateTimeValue()),
            'error_class' => fn(ParseNode $n) => $o->setErrorClass($n->getObjectValue([WebhookDeliveryPublic_error_class::class, 'createFromDiscriminatorValue'])),
            'event_id' => fn(ParseNode $n) => $o->setEventId($n->getStringValue()),
            'event_type' => fn(ParseNode $n) => $o->setEventType($n->getStringValue()),
            'id' => fn(ParseNode $n) => $o->setId($n->getStringValue()),
            'org_id' => fn(ParseNode $n) => $o->setOrgId($n->getStringValue()),
            'replay_of' => fn(ParseNode $n) => $o->setReplayOf($n->getObjectValue([WebhookDeliveryPublic_replay_of::class, 'createFromDiscriminatorValue'])),
            'response_body_preview' => fn(ParseNode $n) => $o->setResponseBodyPreview($n->getObjectValue([WebhookDeliveryPublic_response_body_preview::class, 'createFromDiscriminatorValue'])),
            'response_status' => fn(ParseNode $n) => $o->setResponseStatus($n->getObjectValue([WebhookDeliveryPublic_response_status::class, 'createFromDiscriminatorValue'])),
            'status' => fn(ParseNode $n) => $o->setStatus($n->getStringValue()),
            'webhook_id' => fn(ParseNode $n) => $o->setWebhookId($n->getStringValue()),
        ];
    }

    /**
     * Gets the id property value. The id property
     * @return string|null
    */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Gets the org_id property value. The org_id property
     * @return string|null
    */
    public function getOrgId(): ?string {
        return $this->org_id;
    }

    /**
     * Gets the replay_of property value. The replay_of property
     * @return WebhookDeliveryPublic_replay_of|null
    */
    public function getReplayOf(): ?WebhookDeliveryPublic_replay_of {
        return $this->replay_of;
    }

    /**
     * Gets the response_body_preview property value. The response_body_preview property
     * @return WebhookDeliveryPublic_response_body_preview|null
    */
    public function getResponseBodyPreview(): ?WebhookDeliveryPublic_response_body_preview {
        return $this->response_body_preview;
    }

    /**
     * Gets the response_status property value. The response_status property
     * @return WebhookDeliveryPublic_response_status|null
    */
    public function getResponseStatus(): ?WebhookDeliveryPublic_response_status {
        return $this->response_status;
    }

    /**
     * Gets the status property value. The status property
     * @return string|null
    */
    public function getStatus(): ?string {
        return $this->status;
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
        $writer->writeIntegerValue('attempt', $this->getAttempt());
        $writer->writeObjectValue('delivered_at', $this->getDeliveredAt());
        $writer->writeDateTimeValue('enqueued_at', $this->getEnqueuedAt());
        $writer->writeObjectValue('error_class', $this->getErrorClass());
        $writer->writeStringValue('event_id', $this->getEventId());
        $writer->writeStringValue('event_type', $this->getEventType());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeStringValue('org_id', $this->getOrgId());
        $writer->writeObjectValue('replay_of', $this->getReplayOf());
        $writer->writeObjectValue('response_body_preview', $this->getResponseBodyPreview());
        $writer->writeObjectValue('response_status', $this->getResponseStatus());
        $writer->writeStringValue('status', $this->getStatus());
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
     * Sets the attempt property value. The attempt property
     * @param int|null $value Value to set for the attempt property.
    */
    public function setAttempt(?int $value): void {
        $this->attempt = $value;
    }

    /**
     * Sets the delivered_at property value. The delivered_at property
     * @param WebhookDeliveryPublic_delivered_at|null $value Value to set for the delivered_at property.
    */
    public function setDeliveredAt(?WebhookDeliveryPublic_delivered_at $value): void {
        $this->delivered_at = $value;
    }

    /**
     * Sets the enqueued_at property value. The enqueued_at property
     * @param DateTime|null $value Value to set for the enqueued_at property.
    */
    public function setEnqueuedAt(?DateTime $value): void {
        $this->enqueued_at = $value;
    }

    /**
     * Sets the error_class property value. The error_class property
     * @param WebhookDeliveryPublic_error_class|null $value Value to set for the error_class property.
    */
    public function setErrorClass(?WebhookDeliveryPublic_error_class $value): void {
        $this->error_class = $value;
    }

    /**
     * Sets the event_id property value. The event_id property
     * @param string|null $value Value to set for the event_id property.
    */
    public function setEventId(?string $value): void {
        $this->event_id = $value;
    }

    /**
     * Sets the event_type property value. The event_type property
     * @param string|null $value Value to set for the event_type property.
    */
    public function setEventType(?string $value): void {
        $this->event_type = $value;
    }

    /**
     * Sets the id property value. The id property
     * @param string|null $value Value to set for the id property.
    */
    public function setId(?string $value): void {
        $this->id = $value;
    }

    /**
     * Sets the org_id property value. The org_id property
     * @param string|null $value Value to set for the org_id property.
    */
    public function setOrgId(?string $value): void {
        $this->org_id = $value;
    }

    /**
     * Sets the replay_of property value. The replay_of property
     * @param WebhookDeliveryPublic_replay_of|null $value Value to set for the replay_of property.
    */
    public function setReplayOf(?WebhookDeliveryPublic_replay_of $value): void {
        $this->replay_of = $value;
    }

    /**
     * Sets the response_body_preview property value. The response_body_preview property
     * @param WebhookDeliveryPublic_response_body_preview|null $value Value to set for the response_body_preview property.
    */
    public function setResponseBodyPreview(?WebhookDeliveryPublic_response_body_preview $value): void {
        $this->response_body_preview = $value;
    }

    /**
     * Sets the response_status property value. The response_status property
     * @param WebhookDeliveryPublic_response_status|null $value Value to set for the response_status property.
    */
    public function setResponseStatus(?WebhookDeliveryPublic_response_status $value): void {
        $this->response_status = $value;
    }

    /**
     * Sets the status property value. The status property
     * @param string|null $value Value to set for the status property.
    */
    public function setStatus(?string $value): void {
        $this->status = $value;
    }

    /**
     * Sets the webhook_id property value. The webhook_id property
     * @param string|null $value Value to set for the webhook_id property.
    */
    public function setWebhookId(?string $value): void {
        $this->webhook_id = $value;
    }

}
