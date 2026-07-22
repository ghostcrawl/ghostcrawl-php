<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes AuditEventsResponse_next_cursorMember1, string
*/
class AuditEventsResponse_next_cursor implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var AuditEventsResponse_next_cursorMember1|null $auditEventsResponse_next_cursorMember1 Composed type representation for type AuditEventsResponse_next_cursorMember1
    */
    private ?AuditEventsResponse_next_cursorMember1 $auditEventsResponse_next_cursorMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AuditEventsResponse_next_cursor
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AuditEventsResponse_next_cursor {
        $result = new AuditEventsResponse_next_cursor();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setAuditEventsResponseNextCursorMember1(new AuditEventsResponse_next_cursorMember1());
        }
        return $result;
    }

    /**
     * Gets the AuditEventsResponse_next_cursorMember1 property value. Composed type representation for type AuditEventsResponse_next_cursorMember1
     * @return AuditEventsResponse_next_cursorMember1|null
    */
    public function getAuditEventsResponseNextCursorMember1(): ?AuditEventsResponse_next_cursorMember1 {
        return $this->auditEventsResponse_next_cursorMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getAuditEventsResponseNextCursorMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getAuditEventsResponseNextCursorMember1());
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
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getAuditEventsResponseNextCursorMember1());
        }
    }

    /**
     * Sets the AuditEventsResponse_next_cursorMember1 property value. Composed type representation for type AuditEventsResponse_next_cursorMember1
     * @param AuditEventsResponse_next_cursorMember1|null $value Value to set for the AuditEventsResponse_next_cursorMember1 property.
    */
    public function setAuditEventsResponseNextCursorMember1(?AuditEventsResponse_next_cursorMember1 $value): void {
        $this->auditEventsResponse_next_cursorMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
