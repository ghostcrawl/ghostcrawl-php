<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes SearchRequest_freshnessMember1, string
*/
class SearchRequest_freshness implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var SearchRequest_freshnessMember1|null $searchRequest_freshnessMember1 Composed type representation for type SearchRequest_freshnessMember1
    */
    private ?SearchRequest_freshnessMember1 $searchRequest_freshnessMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SearchRequest_freshness
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SearchRequest_freshness {
        $result = new SearchRequest_freshness();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setSearchRequestFreshnessMember1(new SearchRequest_freshnessMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getSearchRequestFreshnessMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getSearchRequestFreshnessMember1());
        }
        return [];
    }

    /**
     * Gets the SearchRequest_freshnessMember1 property value. Composed type representation for type SearchRequest_freshnessMember1
     * @return SearchRequest_freshnessMember1|null
    */
    public function getSearchRequestFreshnessMember1(): ?SearchRequest_freshnessMember1 {
        return $this->searchRequest_freshnessMember1;
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
            $writer->writeObjectValue(null, $this->getSearchRequestFreshnessMember1());
        }
    }

    /**
     * Sets the SearchRequest_freshnessMember1 property value. Composed type representation for type SearchRequest_freshnessMember1
     * @param SearchRequest_freshnessMember1|null $value Value to set for the SearchRequest_freshnessMember1 property.
    */
    public function setSearchRequestFreshnessMember1(?SearchRequest_freshnessMember1 $value): void {
        $this->searchRequest_freshnessMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
