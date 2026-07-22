<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityResponse_expires_atMember1, string
*/
class IdentityResponse_expires_at implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityResponse_expires_atMember1|null $identityResponse_expires_atMember1 Composed type representation for type IdentityResponse_expires_atMember1
    */
    private ?IdentityResponse_expires_atMember1 $identityResponse_expires_atMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityResponse_expires_at
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityResponse_expires_at {
        $result = new IdentityResponse_expires_at();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityResponseExpiresAtMember1(new IdentityResponse_expires_atMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityResponseExpiresAtMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityResponseExpiresAtMember1());
        }
        return [];
    }

    /**
     * Gets the IdentityResponse_expires_atMember1 property value. Composed type representation for type IdentityResponse_expires_atMember1
     * @return IdentityResponse_expires_atMember1|null
    */
    public function getIdentityResponseExpiresAtMember1(): ?IdentityResponse_expires_atMember1 {
        return $this->identityResponse_expires_atMember1;
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
            $writer->writeObjectValue(null, $this->getIdentityResponseExpiresAtMember1());
        }
    }

    /**
     * Sets the IdentityResponse_expires_atMember1 property value. Composed type representation for type IdentityResponse_expires_atMember1
     * @param IdentityResponse_expires_atMember1|null $value Value to set for the IdentityResponse_expires_atMember1 property.
    */
    public function setIdentityResponseExpiresAtMember1(?IdentityResponse_expires_atMember1 $value): void {
        $this->identityResponse_expires_atMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
