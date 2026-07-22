<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityRequest_sourceMember1, string
*/
class IdentityRequest_source implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityRequest_sourceMember1|null $identityRequest_sourceMember1 Composed type representation for type IdentityRequest_sourceMember1
    */
    private ?IdentityRequest_sourceMember1 $identityRequest_sourceMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityRequest_source
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityRequest_source {
        $result = new IdentityRequest_source();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityRequestSourceMember1(new IdentityRequest_sourceMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityRequestSourceMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityRequestSourceMember1());
        }
        return [];
    }

    /**
     * Gets the IdentityRequest_sourceMember1 property value. Composed type representation for type IdentityRequest_sourceMember1
     * @return IdentityRequest_sourceMember1|null
    */
    public function getIdentityRequestSourceMember1(): ?IdentityRequest_sourceMember1 {
        return $this->identityRequest_sourceMember1;
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
            $writer->writeObjectValue(null, $this->getIdentityRequestSourceMember1());
        }
    }

    /**
     * Sets the IdentityRequest_sourceMember1 property value. Composed type representation for type IdentityRequest_sourceMember1
     * @param IdentityRequest_sourceMember1|null $value Value to set for the IdentityRequest_sourceMember1 property.
    */
    public function setIdentityRequestSourceMember1(?IdentityRequest_sourceMember1 $value): void {
        $this->identityRequest_sourceMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
