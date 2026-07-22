<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityRequest_device_modelMember1, string
*/
class IdentityRequest_device_model implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityRequest_device_modelMember1|null $identityRequest_device_modelMember1 Composed type representation for type IdentityRequest_device_modelMember1
    */
    private ?IdentityRequest_device_modelMember1 $identityRequest_device_modelMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityRequest_device_model
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityRequest_device_model {
        $result = new IdentityRequest_device_model();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityRequestDeviceModelMember1(new IdentityRequest_device_modelMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityRequestDeviceModelMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityRequestDeviceModelMember1());
        }
        return [];
    }

    /**
     * Gets the IdentityRequest_device_modelMember1 property value. Composed type representation for type IdentityRequest_device_modelMember1
     * @return IdentityRequest_device_modelMember1|null
    */
    public function getIdentityRequestDeviceModelMember1(): ?IdentityRequest_device_modelMember1 {
        return $this->identityRequest_device_modelMember1;
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
            $writer->writeObjectValue(null, $this->getIdentityRequestDeviceModelMember1());
        }
    }

    /**
     * Sets the IdentityRequest_device_modelMember1 property value. Composed type representation for type IdentityRequest_device_modelMember1
     * @param IdentityRequest_device_modelMember1|null $value Value to set for the IdentityRequest_device_modelMember1 property.
    */
    public function setIdentityRequestDeviceModelMember1(?IdentityRequest_device_modelMember1 $value): void {
        $this->identityRequest_device_modelMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
