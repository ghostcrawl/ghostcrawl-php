<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes SearchRequest_verticalMember1, string
*/
class SearchRequest_vertical implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var SearchRequest_verticalMember1|null $searchRequest_verticalMember1 Composed type representation for type SearchRequest_verticalMember1
    */
    private ?SearchRequest_verticalMember1 $searchRequest_verticalMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SearchRequest_vertical
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SearchRequest_vertical {
        $result = new SearchRequest_vertical();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setSearchRequestVerticalMember1(new SearchRequest_verticalMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getSearchRequestVerticalMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getSearchRequestVerticalMember1());
        }
        return [];
    }

    /**
     * Gets the SearchRequest_verticalMember1 property value. Composed type representation for type SearchRequest_verticalMember1
     * @return SearchRequest_verticalMember1|null
    */
    public function getSearchRequestVerticalMember1(): ?SearchRequest_verticalMember1 {
        return $this->searchRequest_verticalMember1;
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
            $writer->writeObjectValue(null, $this->getSearchRequestVerticalMember1());
        }
    }

    /**
     * Sets the SearchRequest_verticalMember1 property value. Composed type representation for type SearchRequest_verticalMember1
     * @param SearchRequest_verticalMember1|null $value Value to set for the SearchRequest_verticalMember1 property.
    */
    public function setSearchRequestVerticalMember1(?SearchRequest_verticalMember1 $value): void {
        $this->searchRequest_verticalMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
