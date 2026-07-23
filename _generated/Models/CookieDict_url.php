<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CookieDict_urlMember1, string
*/
class CookieDict_url implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CookieDict_urlMember1|null $cookieDict_urlMember1 Composed type representation for type CookieDict_urlMember1
    */
    private ?CookieDict_urlMember1 $cookieDict_urlMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookieDict_url
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookieDict_url {
        $result = new CookieDict_url();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCookieDictUrlMember1(new CookieDict_urlMember1());
        }
        return $result;
    }

    /**
     * Gets the CookieDict_urlMember1 property value. Composed type representation for type CookieDict_urlMember1
     * @return CookieDict_urlMember1|null
    */
    public function getCookieDictUrlMember1(): ?CookieDict_urlMember1 {
        return $this->cookieDict_urlMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookieDictUrlMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookieDictUrlMember1());
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
            $writer->writeObjectValue(null, $this->getCookieDictUrlMember1());
        }
    }

    /**
     * Sets the CookieDict_urlMember1 property value. Composed type representation for type CookieDict_urlMember1
     * @param CookieDict_urlMember1|null $value Value to set for the CookieDict_urlMember1 property.
    */
    public function setCookieDictUrlMember1(?CookieDict_urlMember1 $value): void {
        $this->cookieDict_urlMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
