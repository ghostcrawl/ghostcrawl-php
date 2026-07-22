<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Composed type wrapper for classes array, ScrapeRequest_urlsMember1
*/
class ScrapeRequest_urls implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeRequest_urlsMember1|null $scrapeRequest_urlsMember1 Composed type representation for type ScrapeRequest_urlsMember1
    */
    private ?ScrapeRequest_urlsMember1 $scrapeRequest_urlsMember1 = null;
    
    /**
     * @var array<string>|null $string Composed type representation for type array
    */
    private ?array $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest_urls
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest_urls {
        $result = new ScrapeRequest_urls();
        if ($parseNode->getCollectionOfPrimitiveValues('string') !== null) {
            $result->setString($parseNode->getCollectionOfPrimitiveValues('string'));
        } else {
            $result->setScrapeRequestUrlsMember1(new ScrapeRequest_urlsMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeRequestUrlsMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeRequestUrlsMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeRequest_urlsMember1 property value. Composed type representation for type ScrapeRequest_urlsMember1
     * @return ScrapeRequest_urlsMember1|null
    */
    public function getScrapeRequestUrlsMember1(): ?ScrapeRequest_urlsMember1 {
        return $this->scrapeRequest_urlsMember1;
    }

    /**
     * Gets the string property value. Composed type representation for type array
     * @return array<string>|null
    */
    public function getString(): ?array {
        return $this->string;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeCollectionOfPrimitiveValues(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getScrapeRequestUrlsMember1());
        }
    }

    /**
     * Sets the ScrapeRequest_urlsMember1 property value. Composed type representation for type ScrapeRequest_urlsMember1
     * @param ScrapeRequest_urlsMember1|null $value Value to set for the ScrapeRequest_urlsMember1 property.
    */
    public function setScrapeRequestUrlsMember1(?ScrapeRequest_urlsMember1 $value): void {
        $this->scrapeRequest_urlsMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type array
     * @param array<string>|null $value Value to set for the string property.
    */
    public function setString(?array $value): void {
        $this->string = $value;
    }

}
