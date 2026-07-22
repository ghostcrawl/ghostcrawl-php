<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WebhookDeliveryListResponse_next_cursorMember1
*/
class WebhookDeliveryListResponse_next_cursor implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var WebhookDeliveryListResponse_next_cursorMember1|null $webhookDeliveryListResponse_next_cursorMember1 Composed type representation for type WebhookDeliveryListResponse_next_cursorMember1
    */
    private ?WebhookDeliveryListResponse_next_cursorMember1 $webhookDeliveryListResponse_next_cursorMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryListResponse_next_cursor
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryListResponse_next_cursor {
        $result = new WebhookDeliveryListResponse_next_cursor();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setWebhookDeliveryListResponseNextCursorMember1(new WebhookDeliveryListResponse_next_cursorMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookDeliveryListResponseNextCursorMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookDeliveryListResponseNextCursorMember1());
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
     * Gets the WebhookDeliveryListResponse_next_cursorMember1 property value. Composed type representation for type WebhookDeliveryListResponse_next_cursorMember1
     * @return WebhookDeliveryListResponse_next_cursorMember1|null
    */
    public function getWebhookDeliveryListResponseNextCursorMember1(): ?WebhookDeliveryListResponse_next_cursorMember1 {
        return $this->webhookDeliveryListResponse_next_cursorMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookDeliveryListResponseNextCursorMember1());
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
     * Sets the WebhookDeliveryListResponse_next_cursorMember1 property value. Composed type representation for type WebhookDeliveryListResponse_next_cursorMember1
     * @param WebhookDeliveryListResponse_next_cursorMember1|null $value Value to set for the WebhookDeliveryListResponse_next_cursorMember1 property.
    */
    public function setWebhookDeliveryListResponseNextCursorMember1(?WebhookDeliveryListResponse_next_cursorMember1 $value): void {
        $this->webhookDeliveryListResponse_next_cursorMember1 = $value;
    }

}
