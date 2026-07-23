<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrapeResult_formatMember1, string
*/
class ScrapeResult_format implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeResult_formatMember1|null $scrapeResult_formatMember1 Composed type representation for type ScrapeResult_formatMember1
    */
    private ?ScrapeResult_formatMember1 $scrapeResult_formatMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult_format
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult_format {
        $result = new ScrapeResult_format();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrapeResultFormatMember1(new ScrapeResult_formatMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeResultFormatMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeResultFormatMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeResult_formatMember1 property value. Composed type representation for type ScrapeResult_formatMember1
     * @return ScrapeResult_formatMember1|null
    */
    public function getScrapeResultFormatMember1(): ?ScrapeResult_formatMember1 {
        return $this->scrapeResult_formatMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeResultFormatMember1());
        }
    }

    /**
     * Sets the ScrapeResult_formatMember1 property value. Composed type representation for type ScrapeResult_formatMember1
     * @param ScrapeResult_formatMember1|null $value Value to set for the ScrapeResult_formatMember1 property.
    */
    public function setScrapeResultFormatMember1(?ScrapeResult_formatMember1 $value): void {
        $this->scrapeResult_formatMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
