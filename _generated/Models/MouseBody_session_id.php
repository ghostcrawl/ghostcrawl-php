<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes MouseBody_session_idMember1, string
*/
class MouseBody_session_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var MouseBody_session_idMember1|null $mouseBody_session_idMember1 Composed type representation for type MouseBody_session_idMember1
    */
    private ?MouseBody_session_idMember1 $mouseBody_session_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MouseBody_session_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MouseBody_session_id {
        $result = new MouseBody_session_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setMouseBodySessionIdMember1(new MouseBody_session_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getMouseBodySessionIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getMouseBodySessionIdMember1());
        }
        return [];
    }

    /**
     * Gets the MouseBody_session_idMember1 property value. Composed type representation for type MouseBody_session_idMember1
     * @return MouseBody_session_idMember1|null
    */
    public function getMouseBodySessionIdMember1(): ?MouseBody_session_idMember1 {
        return $this->mouseBody_session_idMember1;
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
            $writer->writeObjectValue(null, $this->getMouseBodySessionIdMember1());
        }
    }

    /**
     * Sets the MouseBody_session_idMember1 property value. Composed type representation for type MouseBody_session_idMember1
     * @param MouseBody_session_idMember1|null $value Value to set for the MouseBody_session_idMember1 property.
    */
    public function setMouseBodySessionIdMember1(?MouseBody_session_idMember1 $value): void {
        $this->mouseBody_session_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
