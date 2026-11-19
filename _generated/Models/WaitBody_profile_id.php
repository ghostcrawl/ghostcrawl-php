<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WaitBody_profile_idMember1
*/
class WaitBody_profile_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var WaitBody_profile_idMember1|null $waitBody_profile_idMember1 Composed type representation for type WaitBody_profile_idMember1
    */
    private ?WaitBody_profile_idMember1 $waitBody_profile_idMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WaitBody_profile_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WaitBody_profile_id {
        $result = new WaitBody_profile_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setWaitBodyProfileIdMember1(new WaitBody_profile_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWaitBodyProfileIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWaitBodyProfileIdMember1());
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
     * Gets the WaitBody_profile_idMember1 property value. Composed type representation for type WaitBody_profile_idMember1
     * @return WaitBody_profile_idMember1|null
    */
    public function getWaitBodyProfileIdMember1(): ?WaitBody_profile_idMember1 {
        return $this->waitBody_profile_idMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getWaitBodyProfileIdMember1());
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
     * Sets the WaitBody_profile_idMember1 property value. Composed type representation for type WaitBody_profile_idMember1
     * @param WaitBody_profile_idMember1|null $value Value to set for the WaitBody_profile_idMember1 property.
    */
    public function setWaitBodyProfileIdMember1(?WaitBody_profile_idMember1 $value): void {
        $this->waitBody_profile_idMember1 = $value;
    }

}
