<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WebhookDeliveryPublic_error_classMember1
*/
class WebhookDeliveryPublic_error_class implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var WebhookDeliveryPublic_error_classMember1|null $webhookDeliveryPublic_error_classMember1 Composed type representation for type WebhookDeliveryPublic_error_classMember1
    */
    private ?WebhookDeliveryPublic_error_classMember1 $webhookDeliveryPublic_error_classMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryPublic_error_class
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryPublic_error_class {
        $result = new WebhookDeliveryPublic_error_class();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setWebhookDeliveryPublicErrorClassMember1(new WebhookDeliveryPublic_error_classMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookDeliveryPublicErrorClassMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookDeliveryPublicErrorClassMember1());
        }
        return [];
    }

    /**
     * Gets the string property value. Composed type representation for type string
     * @return string|null
    */
    public function getString(): ?string {
        return $this->string;
    }

    /**
     * Gets the WebhookDeliveryPublic_error_classMember1 property value. Composed type representation for type WebhookDeliveryPublic_error_classMember1
     * @return WebhookDeliveryPublic_error_classMember1|null
    */
    public function getWebhookDeliveryPublicErrorClassMember1(): ?WebhookDeliveryPublic_error_classMember1 {
        return $this->webhookDeliveryPublic_error_classMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookDeliveryPublicErrorClassMember1());
        }
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

    /**
     * Sets the WebhookDeliveryPublic_error_classMember1 property value. Composed type representation for type WebhookDeliveryPublic_error_classMember1
     * @param WebhookDeliveryPublic_error_classMember1|null $value Value to set for the WebhookDeliveryPublic_error_classMember1 property.
    */
    public function setWebhookDeliveryPublicErrorClassMember1(?WebhookDeliveryPublic_error_classMember1 $value): void {
        $this->webhookDeliveryPublic_error_classMember1 = $value;
    }

}
