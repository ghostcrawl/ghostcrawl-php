<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CookieDict_domainMember1, string
*/
class CookieDict_domain implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CookieDict_domainMember1|null $cookieDict_domainMember1 Composed type representation for type CookieDict_domainMember1
    */
    private ?CookieDict_domainMember1 $cookieDict_domainMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookieDict_domain
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookieDict_domain {
        $result = new CookieDict_domain();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCookieDictDomainMember1(new CookieDict_domainMember1());
        }
        return $result;
    }

    /**
     * Gets the CookieDict_domainMember1 property value. Composed type representation for type CookieDict_domainMember1
     * @return CookieDict_domainMember1|null
    */
    public function getCookieDictDomainMember1(): ?CookieDict_domainMember1 {
        return $this->cookieDict_domainMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookieDictDomainMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookieDictDomainMember1());
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
            $writer->writeObjectValue(null, $this->getCookieDictDomainMember1());
        }
    }

    /**
     * Sets the CookieDict_domainMember1 property value. Composed type representation for type CookieDict_domainMember1
     * @param CookieDict_domainMember1|null $value Value to set for the CookieDict_domainMember1 property.
    */
    public function setCookieDictDomainMember1(?CookieDict_domainMember1 $value): void {
        $this->cookieDict_domainMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
