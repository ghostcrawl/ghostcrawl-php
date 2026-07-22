<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ProfileUpdateRequest_storage_state_idMember1, string
*/
class ProfileUpdateRequest_storage_state_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ProfileUpdateRequest_storage_state_idMember1|null $profileUpdateRequest_storage_state_idMember1 Composed type representation for type ProfileUpdateRequest_storage_state_idMember1
    */
    private ?ProfileUpdateRequest_storage_state_idMember1 $profileUpdateRequest_storage_state_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ProfileUpdateRequest_storage_state_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ProfileUpdateRequest_storage_state_id {
        $result = new ProfileUpdateRequest_storage_state_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setProfileUpdateRequestStorageStateIdMember1(new ProfileUpdateRequest_storage_state_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getProfileUpdateRequestStorageStateIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getProfileUpdateRequestStorageStateIdMember1());
        }
        return [];
    }

    /**
     * Gets the ProfileUpdateRequest_storage_state_idMember1 property value. Composed type representation for type ProfileUpdateRequest_storage_state_idMember1
     * @return ProfileUpdateRequest_storage_state_idMember1|null
    */
    public function getProfileUpdateRequestStorageStateIdMember1(): ?ProfileUpdateRequest_storage_state_idMember1 {
        return $this->profileUpdateRequest_storage_state_idMember1;
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
            $writer->writeObjectValue(null, $this->getProfileUpdateRequestStorageStateIdMember1());
        }
    }

    /**
     * Sets the ProfileUpdateRequest_storage_state_idMember1 property value. Composed type representation for type ProfileUpdateRequest_storage_state_idMember1
     * @param ProfileUpdateRequest_storage_state_idMember1|null $value Value to set for the ProfileUpdateRequest_storage_state_idMember1 property.
    */
    public function setProfileUpdateRequestStorageStateIdMember1(?ProfileUpdateRequest_storage_state_idMember1 $value): void {
        $this->profileUpdateRequest_storage_state_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
