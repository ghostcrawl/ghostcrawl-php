<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScheduleCreateRequest_notify_webhookMember1, string
*/
class ScheduleCreateRequest_notify_webhook implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScheduleCreateRequest_notify_webhookMember1|null $scheduleCreateRequest_notify_webhookMember1 Composed type representation for type ScheduleCreateRequest_notify_webhookMember1
    */
    private ?ScheduleCreateRequest_notify_webhookMember1 $scheduleCreateRequest_notify_webhookMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScheduleCreateRequest_notify_webhook
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScheduleCreateRequest_notify_webhook {
        $result = new ScheduleCreateRequest_notify_webhook();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScheduleCreateRequestNotifyWebhookMember1(new ScheduleCreateRequest_notify_webhookMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScheduleCreateRequestNotifyWebhookMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScheduleCreateRequestNotifyWebhookMember1());
        }
        return [];
    }

    /**
     * Gets the ScheduleCreateRequest_notify_webhookMember1 property value. Composed type representation for type ScheduleCreateRequest_notify_webhookMember1
     * @return ScheduleCreateRequest_notify_webhookMember1|null
    */
    public function getScheduleCreateRequestNotifyWebhookMember1(): ?ScheduleCreateRequest_notify_webhookMember1 {
        return $this->scheduleCreateRequest_notify_webhookMember1;
    }

    /**
     * Gets the string property value. Composed type representation for type string
     * @return string|null
    */
    public function getString(): ?string {
        return $this->string;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getScheduleCreateRequestNotifyWebhookMember1());
        }
    }

    /**
     * Sets the ScheduleCreateRequest_notify_webhookMember1 property value. Composed type representation for type ScheduleCreateRequest_notify_webhookMember1
     * @param ScheduleCreateRequest_notify_webhookMember1|null $value Value to set for the ScheduleCreateRequest_notify_webhookMember1 property.
    */
    public function setScheduleCreateRequestNotifyWebhookMember1(?ScheduleCreateRequest_notify_webhookMember1 $value): void {
        $this->scheduleCreateRequest_notify_webhookMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
