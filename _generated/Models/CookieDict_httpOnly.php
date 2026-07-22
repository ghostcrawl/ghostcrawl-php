<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes bool, CookieDict_httpOnlyMember1
*/
class CookieDict_httpOnly implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var bool|null $boolean Composed type representation for type bool
    */
    private ?bool $boolean = null;
    
    /**
     * @var CookieDict_httpOnlyMember1|null $cookieDict_httpOnlyMember1 Composed type representation for type CookieDict_httpOnlyMember1
    */
    private ?CookieDict_httpOnlyMember1 $cookieDict_httpOnlyMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookieDict_httpOnly
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookieDict_httpOnly {
        $result = new CookieDict_httpOnly();
        if ($parseNode->getBooleanValue() !== null) {
            $result->setBoolean($parseNode->getBooleanValue());
        } else {
            $result->setCookieDictHttpOnlyMember1(new CookieDict_httpOnlyMember1());
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
     * Gets the CookieDict_httpOnlyMember1 property value. Composed type representation for type CookieDict_httpOnlyMember1
     * @return CookieDict_httpOnlyMember1|null
    */
    public function getCookieDictHttpOnlyMember1(): ?CookieDict_httpOnlyMember1 {
        return $this->cookieDict_httpOnlyMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCookieDictHttpOnlyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCookieDictHttpOnlyMember1());
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
            $writer->writeObjectValue(null, $this->getCookieDictHttpOnlyMember1());
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
     * Sets the CookieDict_httpOnlyMember1 property value. Composed type representation for type CookieDict_httpOnlyMember1
     * @param CookieDict_httpOnlyMember1|null $value Value to set for the CookieDict_httpOnlyMember1 property.
    */
    public function setCookieDictHttpOnlyMember1(?CookieDict_httpOnlyMember1 $value): void {
        $this->cookieDict_httpOnlyMember1 = $value;
    }

}
