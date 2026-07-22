<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ExtractRequest_identity_countryMember1, string
*/
class ExtractRequest_identity_country implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ExtractRequest_identity_countryMember1|null $extractRequest_identity_countryMember1 Composed type representation for type ExtractRequest_identity_countryMember1
    */
    private ?ExtractRequest_identity_countryMember1 $extractRequest_identity_countryMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest_identity_country
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest_identity_country {
        $result = new ExtractRequest_identity_country();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setExtractRequestIdentityCountryMember1(new ExtractRequest_identity_countryMember1());
        }
        return $result;
    }

    /**
     * Gets the ExtractRequest_identity_countryMember1 property value. Composed type representation for type ExtractRequest_identity_countryMember1
     * @return ExtractRequest_identity_countryMember1|null
    */
    public function getExtractRequestIdentityCountryMember1(): ?ExtractRequest_identity_countryMember1 {
        return $this->extractRequest_identity_countryMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtractRequestIdentityCountryMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtractRequestIdentityCountryMember1());
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
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getExtractRequestIdentityCountryMember1());
        }
    }

    /**
     * Sets the ExtractRequest_identity_countryMember1 property value. Composed type representation for type ExtractRequest_identity_countryMember1
     * @param ExtractRequest_identity_countryMember1|null $value Value to set for the ExtractRequest_identity_countryMember1 property.
    */
    public function setExtractRequestIdentityCountryMember1(?ExtractRequest_identity_countryMember1 $value): void {
        $this->extractRequest_identity_countryMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
