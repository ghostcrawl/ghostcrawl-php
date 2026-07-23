<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrapeResult_statusMember1, string
*/
class ScrapeResult_status implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeResult_statusMember1|null $scrapeResult_statusMember1 Composed type representation for type ScrapeResult_statusMember1
    */
    private ?ScrapeResult_statusMember1 $scrapeResult_statusMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult_status
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult_status {
        $result = new ScrapeResult_status();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrapeResultStatusMember1(new ScrapeResult_statusMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeResultStatusMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeResultStatusMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeResult_statusMember1 property value. Composed type representation for type ScrapeResult_statusMember1
     * @return ScrapeResult_statusMember1|null
    */
    public function getScrapeResultStatusMember1(): ?ScrapeResult_statusMember1 {
        return $this->scrapeResult_statusMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeResultStatusMember1());
        }
    }

    /**
     * Sets the ScrapeResult_statusMember1 property value. Composed type representation for type ScrapeResult_statusMember1
     * @param ScrapeResult_statusMember1|null $value Value to set for the ScrapeResult_statusMember1 property.
    */
    public function setScrapeResultStatusMember1(?ScrapeResult_statusMember1 $value): void {
        $this->scrapeResult_statusMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
