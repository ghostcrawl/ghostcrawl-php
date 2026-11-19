<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, ScrollBody_dyMember1
*/
class ScrollBody_dy implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var ScrollBody_dyMember1|null $scrollBody_dyMember1 Composed type representation for type ScrollBody_dyMember1
    */
    private ?ScrollBody_dyMember1 $scrollBody_dyMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrollBody_dy
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrollBody_dy {
        $result = new ScrollBody_dy();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setScrollBodyDyMember1(new ScrollBody_dyMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrollBodyDyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrollBodyDyMember1());
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
     * Gets the ScrollBody_dyMember1 property value. Composed type representation for type ScrollBody_dyMember1
     * @return ScrollBody_dyMember1|null
    */
    public function getScrollBodyDyMember1(): ?ScrollBody_dyMember1 {
        return $this->scrollBody_dyMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getScrollBodyDyMember1());
        }
    }

    /**
     * Sets the integer property value. Composed type representation for type int
     * @param int|null $value Value to set for the integer property.
    */
    public function setInteger(?int $value): void {
        $this->integer = $value;
    }

    /**
     * Sets the ScrollBody_dyMember1 property value. Composed type representation for type ScrollBody_dyMember1
     * @param ScrollBody_dyMember1|null $value Value to set for the ScrollBody_dyMember1 property.
    */
    public function setScrollBodyDyMember1(?ScrollBody_dyMember1 $value): void {
        $this->scrollBody_dyMember1 = $value;
    }

}
