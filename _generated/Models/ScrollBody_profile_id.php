<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrollBody_profile_idMember1, string
*/
class ScrollBody_profile_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrollBody_profile_idMember1|null $scrollBody_profile_idMember1 Composed type representation for type ScrollBody_profile_idMember1
    */
    private ?ScrollBody_profile_idMember1 $scrollBody_profile_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrollBody_profile_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrollBody_profile_id {
        $result = new ScrollBody_profile_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrollBodyProfileIdMember1(new ScrollBody_profile_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrollBodyProfileIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrollBodyProfileIdMember1());
        }
        return [];
    }

    /**
     * Gets the ScrollBody_profile_idMember1 property value. Composed type representation for type ScrollBody_profile_idMember1
     * @return ScrollBody_profile_idMember1|null
    */
    public function getScrollBodyProfileIdMember1(): ?ScrollBody_profile_idMember1 {
        return $this->scrollBody_profile_idMember1;
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
            $writer->writeObjectValue(null, $this->getScrollBodyProfileIdMember1());
        }
    }

    /**
     * Sets the ScrollBody_profile_idMember1 property value. Composed type representation for type ScrollBody_profile_idMember1
     * @param ScrollBody_profile_idMember1|null $value Value to set for the ScrollBody_profile_idMember1 property.
    */
    public function setScrollBodyProfileIdMember1(?ScrollBody_profile_idMember1 $value): void {
        $this->scrollBody_profile_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
