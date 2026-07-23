<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, MapResponse_truncated_to_server_maxMember1
*/
class MapResponse_truncated_to_server_max implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var MapResponse_truncated_to_server_maxMember1|null $mapResponse_truncated_to_server_maxMember1 Composed type representation for type MapResponse_truncated_to_server_maxMember1
    */
    private ?MapResponse_truncated_to_server_maxMember1 $mapResponse_truncated_to_server_maxMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MapResponse_truncated_to_server_max
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MapResponse_truncated_to_server_max {
        $result = new MapResponse_truncated_to_server_max();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setMapResponseTruncatedToServerMaxMember1(new MapResponse_truncated_to_server_maxMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getMapResponseTruncatedToServerMaxMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getMapResponseTruncatedToServerMaxMember1());
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
     * Gets the MapResponse_truncated_to_server_maxMember1 property value. Composed type representation for type MapResponse_truncated_to_server_maxMember1
     * @return MapResponse_truncated_to_server_maxMember1|null
    */
    public function getMapResponseTruncatedToServerMaxMember1(): ?MapResponse_truncated_to_server_maxMember1 {
        return $this->mapResponse_truncated_to_server_maxMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getMapResponseTruncatedToServerMaxMember1());
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
     * Sets the MapResponse_truncated_to_server_maxMember1 property value. Composed type representation for type MapResponse_truncated_to_server_maxMember1
     * @param MapResponse_truncated_to_server_maxMember1|null $value Value to set for the MapResponse_truncated_to_server_maxMember1 property.
    */
    public function setMapResponseTruncatedToServerMaxMember1(?MapResponse_truncated_to_server_maxMember1 $value): void {
        $this->mapResponse_truncated_to_server_maxMember1 = $value;
    }

}
