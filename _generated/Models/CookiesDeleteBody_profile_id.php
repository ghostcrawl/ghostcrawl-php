<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CookiesDeleteBody_profile_idMember1, string
*/
class CookiesDeleteBody_profile_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CookiesDeleteBody_profile_idMember1|null $cookiesDeleteBody_profile_idMember1 Composed type representation for type CookiesDeleteBody_profile_idMember1
    */
    private ?CookiesDeleteBody_profile_idMember1 $cookiesDeleteBody_profile_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookiesDeleteBody_profile_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookiesDeleteBody_profile_id {
        $result = new CookiesDeleteBody_profile_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCookiesDeleteBodyProfileIdMember1(new CookiesDeleteBody_profile_idMember1());
        }
        return $result;
    }

    /**
     * Gets the CookiesDeleteBody_profile_idMember1 property value. Composed type representation for type CookiesDeleteBody_profile_idMember1
     * @return CookiesDeleteBody_profile_idMember1|null
    */
    public function getCookiesDeleteBodyProfileIdMember1(): ?CookiesDeleteBody_profile_idMember1 {
        return $this->cookiesDeleteBody_profile_idMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookiesDeleteBodyProfileIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookiesDeleteBodyProfileIdMember1());
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
            $writer->writeObjectValue(null, $this->getCookiesDeleteBodyProfileIdMember1());
        }
    }

    /**
     * Sets the CookiesDeleteBody_profile_idMember1 property value. Composed type representation for type CookiesDeleteBody_profile_idMember1
     * @param CookiesDeleteBody_profile_idMember1|null $value Value to set for the CookiesDeleteBody_profile_idMember1 property.
    */
    public function setCookiesDeleteBodyProfileIdMember1(?CookiesDeleteBody_profile_idMember1 $value): void {
        $this->cookiesDeleteBody_profile_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
