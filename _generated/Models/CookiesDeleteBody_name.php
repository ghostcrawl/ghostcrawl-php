<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CookiesDeleteBody_nameMember1, string
*/
class CookiesDeleteBody_name implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CookiesDeleteBody_nameMember1|null $cookiesDeleteBody_nameMember1 Composed type representation for type CookiesDeleteBody_nameMember1
    */
    private ?CookiesDeleteBody_nameMember1 $cookiesDeleteBody_nameMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookiesDeleteBody_name
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookiesDeleteBody_name {
        $result = new CookiesDeleteBody_name();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCookiesDeleteBodyNameMember1(new CookiesDeleteBody_nameMember1());
        }
        return $result;
    }

    /**
     * Gets the CookiesDeleteBody_nameMember1 property value. Composed type representation for type CookiesDeleteBody_nameMember1
     * @return CookiesDeleteBody_nameMember1|null
    */
    public function getCookiesDeleteBodyNameMember1(): ?CookiesDeleteBody_nameMember1 {
        return $this->cookiesDeleteBody_nameMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookiesDeleteBodyNameMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookiesDeleteBodyNameMember1());
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
            $writer->writeObjectValue(null, $this->getCookiesDeleteBodyNameMember1());
        }
    }

    /**
     * Sets the CookiesDeleteBody_nameMember1 property value. Composed type representation for type CookiesDeleteBody_nameMember1
     * @param CookiesDeleteBody_nameMember1|null $value Value to set for the CookiesDeleteBody_nameMember1 property.
    */
    public function setCookiesDeleteBodyNameMember1(?CookiesDeleteBody_nameMember1 $value): void {
        $this->cookiesDeleteBody_nameMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
