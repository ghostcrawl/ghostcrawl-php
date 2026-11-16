<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, TouchBody_session_idMember1
*/
class TouchBody_session_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var TouchBody_session_idMember1|null $touchBody_session_idMember1 Composed type representation for type TouchBody_session_idMember1
    */
    private ?TouchBody_session_idMember1 $touchBody_session_idMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return TouchBody_session_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TouchBody_session_id {
        $result = new TouchBody_session_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setTouchBodySessionIdMember1(new TouchBody_session_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getTouchBodySessionIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getTouchBodySessionIdMember1());
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
     * Gets the TouchBody_session_idMember1 property value. Composed type representation for type TouchBody_session_idMember1
     * @return TouchBody_session_idMember1|null
    */
    public function getTouchBodySessionIdMember1(): ?TouchBody_session_idMember1 {
        return $this->touchBody_session_idMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getTouchBodySessionIdMember1());
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
     * Sets the TouchBody_session_idMember1 property value. Composed type representation for type TouchBody_session_idMember1
     * @param TouchBody_session_idMember1|null $value Value to set for the TouchBody_session_idMember1 property.
    */
    public function setTouchBodySessionIdMember1(?TouchBody_session_idMember1 $value): void {
        $this->touchBody_session_idMember1 = $value;
    }

}
