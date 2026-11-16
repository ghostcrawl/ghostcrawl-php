<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ArrivalBody_session_idMember1, string
*/
class ArrivalBody_session_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ArrivalBody_session_idMember1|null $arrivalBody_session_idMember1 Composed type representation for type ArrivalBody_session_idMember1
    */
    private ?ArrivalBody_session_idMember1 $arrivalBody_session_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ArrivalBody_session_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ArrivalBody_session_id {
        $result = new ArrivalBody_session_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setArrivalBodySessionIdMember1(new ArrivalBody_session_idMember1());
        }
        return $result;
    }

    /**
     * Gets the ArrivalBody_session_idMember1 property value. Composed type representation for type ArrivalBody_session_idMember1
     * @return ArrivalBody_session_idMember1|null
    */
    public function getArrivalBodySessionIdMember1(): ?ArrivalBody_session_idMember1 {
        return $this->arrivalBody_session_idMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getArrivalBodySessionIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getArrivalBodySessionIdMember1());
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
            $writer->writeObjectValue(null, $this->getArrivalBodySessionIdMember1());
        }
    }

    /**
     * Sets the ArrivalBody_session_idMember1 property value. Composed type representation for type ArrivalBody_session_idMember1
     * @param ArrivalBody_session_idMember1|null $value Value to set for the ArrivalBody_session_idMember1 property.
    */
    public function setArrivalBodySessionIdMember1(?ArrivalBody_session_idMember1 $value): void {
        $this->arrivalBody_session_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
