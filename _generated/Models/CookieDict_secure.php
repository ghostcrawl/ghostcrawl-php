<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes bool, CookieDict_secureMember1
*/
class CookieDict_secure implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var bool|null $boolean Composed type representation for type bool
    */
    private ?bool $boolean = null;
    
    /**
     * @var CookieDict_secureMember1|null $cookieDict_secureMember1 Composed type representation for type CookieDict_secureMember1
    */
    private ?CookieDict_secureMember1 $cookieDict_secureMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookieDict_secure
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookieDict_secure {
        $result = new CookieDict_secure();
        if ($parseNode->getBooleanValue() !== null) {
            $result->setBoolean($parseNode->getBooleanValue());
        } else {
            $result->setCookieDictSecureMember1(new CookieDict_secureMember1());
        }
        return $result;
    }

    /**
     * Gets the boolean property value. Composed type representation for type bool
     * @return bool|null
    */
    public function getBoolean(): ?bool {
        return $this->boolean;
    }

    /**
     * Gets the CookieDict_secureMember1 property value. Composed type representation for type CookieDict_secureMember1
     * @return CookieDict_secureMember1|null
    */
    public function getCookieDictSecureMember1(): ?CookieDict_secureMember1 {
        return $this->cookieDict_secureMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookieDictSecureMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookieDictSecureMember1());
        }
        return [];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getBoolean() !== null) {
            $writer->writeBooleanValue(null, $this->getBoolean());
        } else {
            $writer->writeObjectValue(null, $this->getCookieDictSecureMember1());
        }
    }

    /**
     * Sets the boolean property value. Composed type representation for type bool
     * @param bool|null $value Value to set for the boolean property.
    */
    public function setBoolean(?bool $value): void {
        $this->boolean = $value;
    }

    /**
     * Sets the CookieDict_secureMember1 property value. Composed type representation for type CookieDict_secureMember1
     * @param CookieDict_secureMember1|null $value Value to set for the CookieDict_secureMember1 property.
    */
    public function setCookieDictSecureMember1(?CookieDict_secureMember1 $value): void {
        $this->cookieDict_secureMember1 = $value;
    }

}
