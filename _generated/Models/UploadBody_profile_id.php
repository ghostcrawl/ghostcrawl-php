<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, UploadBody_profile_idMember1
*/
class UploadBody_profile_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var UploadBody_profile_idMember1|null $uploadBody_profile_idMember1 Composed type representation for type UploadBody_profile_idMember1
    */
    private ?UploadBody_profile_idMember1 $uploadBody_profile_idMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return UploadBody_profile_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): UploadBody_profile_id {
        $result = new UploadBody_profile_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setUploadBodyProfileIdMember1(new UploadBody_profile_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getUploadBodyProfileIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getUploadBodyProfileIdMember1());
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
     * Gets the UploadBody_profile_idMember1 property value. Composed type representation for type UploadBody_profile_idMember1
     * @return UploadBody_profile_idMember1|null
    */
    public function getUploadBodyProfileIdMember1(): ?UploadBody_profile_idMember1 {
        return $this->uploadBody_profile_idMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getUploadBodyProfileIdMember1());
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
     * Sets the UploadBody_profile_idMember1 property value. Composed type representation for type UploadBody_profile_idMember1
     * @param UploadBody_profile_idMember1|null $value Value to set for the UploadBody_profile_idMember1 property.
    */
    public function setUploadBodyProfileIdMember1(?UploadBody_profile_idMember1 $value): void {
        $this->uploadBody_profile_idMember1 = $value;
    }

}
