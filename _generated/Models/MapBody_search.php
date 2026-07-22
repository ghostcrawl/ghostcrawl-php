<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes MapBody_searchMember1, string
*/
class MapBody_search implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var MapBody_searchMember1|null $mapBody_searchMember1 Composed type representation for type MapBody_searchMember1
    */
    private ?MapBody_searchMember1 $mapBody_searchMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MapBody_search
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MapBody_search {
        $result = new MapBody_search();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setMapBodySearchMember1(new MapBody_searchMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getMapBodySearchMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getMapBodySearchMember1());
        }
        return [];
    }

    /**
     * Gets the MapBody_searchMember1 property value. Composed type representation for type MapBody_searchMember1
     * @return MapBody_searchMember1|null
    */
    public function getMapBodySearchMember1(): ?MapBody_searchMember1 {
        return $this->mapBody_searchMember1;
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
            $writer->writeObjectValue(null, $this->getMapBodySearchMember1());
        }
    }

    /**
     * Sets the MapBody_searchMember1 property value. Composed type representation for type MapBody_searchMember1
     * @param MapBody_searchMember1|null $value Value to set for the MapBody_searchMember1 property.
    */
    public function setMapBodySearchMember1(?MapBody_searchMember1 $value): void {
        $this->mapBody_searchMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
