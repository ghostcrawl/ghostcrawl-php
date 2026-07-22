<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, WebhookDeliveryPublic_response_statusMember1
*/
class WebhookDeliveryPublic_response_status implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var WebhookDeliveryPublic_response_statusMember1|null $webhookDeliveryPublic_response_statusMember1 Composed type representation for type WebhookDeliveryPublic_response_statusMember1
    */
    private ?WebhookDeliveryPublic_response_statusMember1 $webhookDeliveryPublic_response_statusMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryPublic_response_status
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryPublic_response_status {
        $result = new WebhookDeliveryPublic_response_status();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setWebhookDeliveryPublicResponseStatusMember1(new WebhookDeliveryPublic_response_statusMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookDeliveryPublicResponseStatusMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookDeliveryPublicResponseStatusMember1());
        }
        return [];
    }

    /**
     * Gets the integer property value. Composed type representation for type int
     * @return int|null
    */
    public function getInteger(): ?int {
        return $this->integer;
    }

    /**
     * Gets the WebhookDeliveryPublic_response_statusMember1 property value. Composed type representation for type WebhookDeliveryPublic_response_statusMember1
     * @return WebhookDeliveryPublic_response_statusMember1|null
    */
    public function getWebhookDeliveryPublicResponseStatusMember1(): ?WebhookDeliveryPublic_response_statusMember1 {
        return $this->webhookDeliveryPublic_response_statusMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookDeliveryPublicResponseStatusMember1());
        }
    }

    /**
     * Sets the integer property value. Composed type representation for type int
     * @param int|null $value Value to set for the integer property.
    */
    public function setInteger(?int $value): void {
        $this->integer = $value;
    }

    /**
     * Sets the WebhookDeliveryPublic_response_statusMember1 property value. Composed type representation for type WebhookDeliveryPublic_response_statusMember1
     * @param WebhookDeliveryPublic_response_statusMember1|null $value Value to set for the WebhookDeliveryPublic_response_statusMember1 property.
    */
    public function setWebhookDeliveryPublicResponseStatusMember1(?WebhookDeliveryPublic_response_statusMember1 $value): void {
        $this->webhookDeliveryPublic_response_statusMember1 = $value;
    }

}
