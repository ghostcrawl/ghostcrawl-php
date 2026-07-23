<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ProfileUpdateRequest_nameMember1, string
*/
class ProfileUpdateRequest_name implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ProfileUpdateRequest_nameMember1|null $profileUpdateRequest_nameMember1 Composed type representation for type ProfileUpdateRequest_nameMember1
    */
    private ?ProfileUpdateRequest_nameMember1 $profileUpdateRequest_nameMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ProfileUpdateRequest_name
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ProfileUpdateRequest_name {
        $result = new ProfileUpdateRequest_name();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setProfileUpdateRequestNameMember1(new ProfileUpdateRequest_nameMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getProfileUpdateRequestNameMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getProfileUpdateRequestNameMember1());
        }
        return [];
    }

    /**
     * Gets the ProfileUpdateRequest_nameMember1 property value. Composed type representation for type ProfileUpdateRequest_nameMember1
     * @return ProfileUpdateRequest_nameMember1|null
    */
    public function getProfileUpdateRequestNameMember1(): ?ProfileUpdateRequest_nameMember1 {
        return $this->profileUpdateRequest_nameMember1;
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
            $writer->writeObjectValue(null, $this->getProfileUpdateRequestNameMember1());
        }
    }

    /**
     * Sets the ProfileUpdateRequest_nameMember1 property value. Composed type representation for type ProfileUpdateRequest_nameMember1
     * @param ProfileUpdateRequest_nameMember1|null $value Value to set for the ProfileUpdateRequest_nameMember1 property.
    */
    public function setProfileUpdateRequestNameMember1(?ProfileUpdateRequest_nameMember1 $value): void {
        $this->profileUpdateRequest_nameMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
