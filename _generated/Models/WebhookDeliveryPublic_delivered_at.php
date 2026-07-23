<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes DateTime, WebhookDeliveryPublic_delivered_atMember1
*/
class WebhookDeliveryPublic_delivered_at implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var DateTime|null $dateTimeOffset Composed type representation for type DateTime
    */
    private ?DateTime $dateTimeOffset = null;
    
    /**
     * @var WebhookDeliveryPublic_delivered_atMember1|null $webhookDeliveryPublic_delivered_atMember1 Composed type representation for type WebhookDeliveryPublic_delivered_atMember1
    */
    private ?WebhookDeliveryPublic_delivered_atMember1 $webhookDeliveryPublic_delivered_atMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryPublic_delivered_at
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryPublic_delivered_at {
        $result = new WebhookDeliveryPublic_delivered_at();
        if ($parseNode->getDateTimeValue() !== null) {
            $result->setDateTimeOffset($parseNode->getDateTimeValue());
        } else {
            $result->setWebhookDeliveryPublicDeliveredAtMember1(new WebhookDeliveryPublic_delivered_atMember1());
        }
        return $result;
    }

    /**
     * Gets the DateTimeOffset property value. Composed type representation for type DateTime
     * @return DateTime|null
    */
    public function getDateTimeOffset(): ?DateTime {
        return $this->dateTimeOffset;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookDeliveryPublicDeliveredAtMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookDeliveryPublicDeliveredAtMember1());
        }
        return [];
    }

    /**
     * Gets the WebhookDeliveryPublic_delivered_atMember1 property value. Composed type representation for type WebhookDeliveryPublic_delivered_atMember1
     * @return WebhookDeliveryPublic_delivered_atMember1|null
    */
    public function getWebhookDeliveryPublicDeliveredAtMember1(): ?WebhookDeliveryPublic_delivered_atMember1 {
        return $this->webhookDeliveryPublic_delivered_atMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getDateTimeOffset() !== null) {
            $writer->writeDateTimeValue(null, $this->getDateTimeOffset());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookDeliveryPublicDeliveredAtMember1());
        }
    }

    /**
     * Sets the DateTimeOffset property value. Composed type representation for type DateTime
     * @param DateTime|null $value Value to set for the DateTimeOffset property.
    */
    public function setDateTimeOffset(?DateTime $value): void {
        $this->dateTimeOffset = $value;
    }

    /**
     * Sets the WebhookDeliveryPublic_delivered_atMember1 property value. Composed type representation for type WebhookDeliveryPublic_delivered_atMember1
     * @param WebhookDeliveryPublic_delivered_atMember1|null $value Value to set for the WebhookDeliveryPublic_delivered_atMember1 property.
    */
    public function setWebhookDeliveryPublicDeliveredAtMember1(?WebhookDeliveryPublic_delivered_atMember1 $value): void {
        $this->webhookDeliveryPublic_delivered_atMember1 = $value;
    }

}
