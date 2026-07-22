<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes AuditEventOut_target_idMember1, string
*/
class AuditEventOut_target_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var AuditEventOut_target_idMember1|null $auditEventOut_target_idMember1 Composed type representation for type AuditEventOut_target_idMember1
    */
    private ?AuditEventOut_target_idMember1 $auditEventOut_target_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AuditEventOut_target_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AuditEventOut_target_id {
        $result = new AuditEventOut_target_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setAuditEventOutTargetIdMember1(new AuditEventOut_target_idMember1());
        }
        return $result;
    }

    /**
     * Gets the AuditEventOut_target_idMember1 property value. Composed type representation for type AuditEventOut_target_idMember1
     * @return AuditEventOut_target_idMember1|null
    */
    public function getAuditEventOutTargetIdMember1(): ?AuditEventOut_target_idMember1 {
        return $this->auditEventOut_target_idMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getAuditEventOutTargetIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getAuditEventOutTargetIdMember1());
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
            $writer->writeObjectValue(null, $this->getAuditEventOutTargetIdMember1());
        }
    }

    /**
     * Sets the AuditEventOut_target_idMember1 property value. Composed type representation for type AuditEventOut_target_idMember1
     * @param AuditEventOut_target_idMember1|null $value Value to set for the AuditEventOut_target_idMember1 property.
    */
    public function setAuditEventOutTargetIdMember1(?AuditEventOut_target_idMember1 $value): void {
        $this->auditEventOut_target_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
