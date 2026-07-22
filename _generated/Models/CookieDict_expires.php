<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CookieDict_expiresMember1, float
*/
class CookieDict_expires implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CookieDict_expiresMember1|null $cookieDict_expiresMember1 Composed type representation for type CookieDict_expiresMember1
    */
    private ?CookieDict_expiresMember1 $cookieDict_expiresMember1 = null;
    
    /**
     * @var float|null $double Composed type representation for type float
    */
    private ?float $double = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookieDict_expires
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookieDict_expires {
        $result = new CookieDict_expires();
        if ($parseNode->getFloatValue() !== null) {
            $result->setDouble($parseNode->getFloatValue());
        } else {
            $result->setCookieDictExpiresMember1(new CookieDict_expiresMember1());
        }
        return $result;
    }

    /**
     * Gets the CookieDict_expiresMember1 property value. Composed type representation for type CookieDict_expiresMember1
     * @return CookieDict_expiresMember1|null
    */
    public function getCookieDictExpiresMember1(): ?CookieDict_expiresMember1 {
        return $this->cookieDict_expiresMember1;
    }

    /**
     * Gets the double property value. Composed type representation for type float
     * @return float|null
    */
    public function getDouble(): ?float {
        return $this->double;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookieDictExpiresMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookieDictExpiresMember1());
        }
        return [];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getDouble() !== null) {
            $writer->writeFloatValue(null, $this->getDouble());
        } else {
            $writer->writeObjectValue(null, $this->getCookieDictExpiresMember1());
        }
    }

    /**
     * Sets the CookieDict_expiresMember1 property value. Composed type representation for type CookieDict_expiresMember1
     * @param CookieDict_expiresMember1|null $value Value to set for the CookieDict_expiresMember1 property.
    */
    public function setCookieDictExpiresMember1(?CookieDict_expiresMember1 $value): void {
        $this->cookieDict_expiresMember1 = $value;
    }

    /**
     * Sets the double property value. Composed type representation for type float
     * @param float|null $value Value to set for the double property.
    */
    public function setDouble(?float $value): void {
        $this->double = $value;
    }

}
