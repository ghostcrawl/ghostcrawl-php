<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes SearchRequest_countryMember1, string
*/
class SearchRequest_country implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var SearchRequest_countryMember1|null $searchRequest_countryMember1 Composed type representation for type SearchRequest_countryMember1
    */
    private ?SearchRequest_countryMember1 $searchRequest_countryMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SearchRequest_country
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SearchRequest_country {
        $result = new SearchRequest_country();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setSearchRequestCountryMember1(new SearchRequest_countryMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getSearchRequestCountryMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getSearchRequestCountryMember1());
        }
        return [];
    }

    /**
     * Gets the SearchRequest_countryMember1 property value. Composed type representation for type SearchRequest_countryMember1
     * @return SearchRequest_countryMember1|null
    */
    public function getSearchRequestCountryMember1(): ?SearchRequest_countryMember1 {
        return $this->searchRequest_countryMember1;
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
            $writer->writeObjectValue(null, $this->getSearchRequestCountryMember1());
        }
    }

    /**
     * Sets the SearchRequest_countryMember1 property value. Composed type representation for type SearchRequest_countryMember1
     * @param SearchRequest_countryMember1|null $value Value to set for the SearchRequest_countryMember1 property.
    */
    public function setSearchRequestCountryMember1(?SearchRequest_countryMember1 $value): void {
        $this->searchRequest_countryMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
