<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ExtendBody_ttl_secondsMember1, int
*/
class ExtendBody_ttl_seconds implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ExtendBody_ttl_secondsMember1|null $extendBody_ttl_secondsMember1 Composed type representation for type ExtendBody_ttl_secondsMember1
    */
    private ?ExtendBody_ttl_secondsMember1 $extendBody_ttl_secondsMember1 = null;
    
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtendBody_ttl_seconds
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtendBody_ttl_seconds {
        $result = new ExtendBody_ttl_seconds();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setExtendBodyTtlSecondsMember1(new ExtendBody_ttl_secondsMember1());
        }
        return $result;
    }

    /**
     * Gets the ExtendBody_ttl_secondsMember1 property value. Composed type representation for type ExtendBody_ttl_secondsMember1
     * @return ExtendBody_ttl_secondsMember1|null
    */
    public function getExtendBodyTtlSecondsMember1(): ?ExtendBody_ttl_secondsMember1 {
        return $this->extendBody_ttl_secondsMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtendBodyTtlSecondsMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtendBodyTtlSecondsMember1());
        }
        return [];
    }

    /**
     * Gets the integer property value. Composed type representation for type int
     * @return int|null
    */
    public function getInteger(): ?int {
        return $this->integer;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getExtendBodyTtlSecondsMember1());
        }
    }

    /**
     * Sets the ExtendBody_ttl_secondsMember1 property value. Composed type representation for type ExtendBody_ttl_secondsMember1
     * @param ExtendBody_ttl_secondsMember1|null $value Value to set for the ExtendBody_ttl_secondsMember1 property.
    */
    public function setExtendBodyTtlSecondsMember1(?ExtendBody_ttl_secondsMember1 $value): void {
        $this->extendBody_ttl_secondsMember1 = $value;
    }

    /**
     * Sets the integer property value. Composed type representation for type int
     * @param int|null $value Value to set for the integer property.
    */
    public function setInteger(?int $value): void {
        $this->integer = $value;
    }

}
