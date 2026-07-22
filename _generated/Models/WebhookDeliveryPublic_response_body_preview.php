<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WebhookDeliveryPublic_response_body_previewMember1
*/
class WebhookDeliveryPublic_response_body_preview implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var WebhookDeliveryPublic_response_body_previewMember1|null $webhookDeliveryPublic_response_body_previewMember1 Composed type representation for type WebhookDeliveryPublic_response_body_previewMember1
    */
    private ?WebhookDeliveryPublic_response_body_previewMember1 $webhookDeliveryPublic_response_body_previewMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryPublic_response_body_preview
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryPublic_response_body_preview {
        $result = new WebhookDeliveryPublic_response_body_preview();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setWebhookDeliveryPublicResponseBodyPreviewMember1(new WebhookDeliveryPublic_response_body_previewMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookDeliveryPublicResponseBodyPreviewMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookDeliveryPublicResponseBodyPreviewMember1());
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
     * Gets the WebhookDeliveryPublic_response_body_previewMember1 property value. Composed type representation for type WebhookDeliveryPublic_response_body_previewMember1
     * @return WebhookDeliveryPublic_response_body_previewMember1|null
    */
    public function getWebhookDeliveryPublicResponseBodyPreviewMember1(): ?WebhookDeliveryPublic_response_body_previewMember1 {
        return $this->webhookDeliveryPublic_response_body_previewMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookDeliveryPublicResponseBodyPreviewMember1());
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
     * Sets the WebhookDeliveryPublic_response_body_previewMember1 property value. Composed type representation for type WebhookDeliveryPublic_response_body_previewMember1
     * @param WebhookDeliveryPublic_response_body_previewMember1|null $value Value to set for the WebhookDeliveryPublic_response_body_previewMember1 property.
    */
    public function setWebhookDeliveryPublicResponseBodyPreviewMember1(?WebhookDeliveryPublic_response_body_previewMember1 $value): void {
        $this->webhookDeliveryPublic_response_body_previewMember1 = $value;
    }

}
