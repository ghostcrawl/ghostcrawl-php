<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WebhookListResponse_next_cursorMember1
*/
class WebhookListResponse_next_cursor implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var WebhookListResponse_next_cursorMember1|null $webhookListResponse_next_cursorMember1 Composed type representation for type WebhookListResponse_next_cursorMember1
    */
    private ?WebhookListResponse_next_cursorMember1 $webhookListResponse_next_cursorMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookListResponse_next_cursor
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookListResponse_next_cursor {
        $result = new WebhookListResponse_next_cursor();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setWebhookListResponseNextCursorMember1(new WebhookListResponse_next_cursorMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookListResponseNextCursorMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookListResponseNextCursorMember1());
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
     * Gets the WebhookListResponse_next_cursorMember1 property value. Composed type representation for type WebhookListResponse_next_cursorMember1
     * @return WebhookListResponse_next_cursorMember1|null
    */
    public function getWebhookListResponseNextCursorMember1(): ?WebhookListResponse_next_cursorMember1 {
        return $this->webhookListResponse_next_cursorMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookListResponseNextCursorMember1());
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
     * Sets the WebhookListResponse_next_cursorMember1 property value. Composed type representation for type WebhookListResponse_next_cursorMember1
     * @param WebhookListResponse_next_cursorMember1|null $value Value to set for the WebhookListResponse_next_cursorMember1 property.
    */
    public function setWebhookListResponseNextCursorMember1(?WebhookListResponse_next_cursorMember1 $value): void {
        $this->webhookListResponse_next_cursorMember1 = $value;
    }

}
