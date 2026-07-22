<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, ScrollBody_distance_pxMember1
*/
class ScrollBody_distance_px implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var ScrollBody_distance_pxMember1|null $scrollBody_distance_pxMember1 Composed type representation for type ScrollBody_distance_pxMember1
    */
    private ?ScrollBody_distance_pxMember1 $scrollBody_distance_pxMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrollBody_distance_px
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrollBody_distance_px {
        $result = new ScrollBody_distance_px();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setScrollBodyDistancePxMember1(new ScrollBody_distance_pxMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrollBodyDistancePxMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrollBodyDistancePxMember1());
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
     * Gets the ScrollBody_distance_pxMember1 property value. Composed type representation for type ScrollBody_distance_pxMember1
     * @return ScrollBody_distance_pxMember1|null
    */
    public function getScrollBodyDistancePxMember1(): ?ScrollBody_distance_pxMember1 {
        return $this->scrollBody_distance_pxMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getScrollBodyDistancePxMember1());
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
     * Sets the ScrollBody_distance_pxMember1 property value. Composed type representation for type ScrollBody_distance_pxMember1
     * @param ScrollBody_distance_pxMember1|null $value Value to set for the ScrollBody_distance_pxMember1 property.
    */
    public function setScrollBodyDistancePxMember1(?ScrollBody_distance_pxMember1 $value): void {
        $this->scrollBody_distance_pxMember1 = $value;
    }

}
