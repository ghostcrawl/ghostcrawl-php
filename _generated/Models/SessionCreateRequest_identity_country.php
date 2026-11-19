<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes SessionCreateRequest_identity_countryMember1, string
*/
class SessionCreateRequest_identity_country implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var SessionCreateRequest_identity_countryMember1|null $sessionCreateRequest_identity_countryMember1 Composed type representation for type SessionCreateRequest_identity_countryMember1
    */
    private ?SessionCreateRequest_identity_countryMember1 $sessionCreateRequest_identity_countryMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SessionCreateRequest_identity_country
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SessionCreateRequest_identity_country {
        $result = new SessionCreateRequest_identity_country();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setSessionCreateRequestIdentityCountryMember1(new SessionCreateRequest_identity_countryMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getSessionCreateRequestIdentityCountryMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getSessionCreateRequestIdentityCountryMember1());
        }
        return [];
    }

    /**
     * Gets the SessionCreateRequest_identity_countryMember1 property value. Composed type representation for type SessionCreateRequest_identity_countryMember1
     * @return SessionCreateRequest_identity_countryMember1|null
    */
    public function getSessionCreateRequestIdentityCountryMember1(): ?SessionCreateRequest_identity_countryMember1 {
        return $this->sessionCreateRequest_identity_countryMember1;
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
            $writer->writeObjectValue(null, $this->getSessionCreateRequestIdentityCountryMember1());
        }
    }

    /**
     * Sets the SessionCreateRequest_identity_countryMember1 property value. Composed type representation for type SessionCreateRequest_identity_countryMember1
     * @param SessionCreateRequest_identity_countryMember1|null $value Value to set for the SessionCreateRequest_identity_countryMember1 property.
    */
    public function setSessionCreateRequestIdentityCountryMember1(?SessionCreateRequest_identity_countryMember1 $value): void {
        $this->sessionCreateRequest_identity_countryMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
