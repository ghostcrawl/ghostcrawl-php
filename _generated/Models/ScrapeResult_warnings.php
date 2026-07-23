<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Composed type wrapper for classes array, ScrapeResult_warningsMember1
*/
class ScrapeResult_warnings implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeResult_warningsMember1|null $scrapeResult_warningsMember1 Composed type representation for type ScrapeResult_warningsMember1
    */
    private ?ScrapeResult_warningsMember1 $scrapeResult_warningsMember1 = null;
    
    /**
     * @var array<string>|null $string Composed type representation for type array
    */
    private ?array $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult_warnings
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult_warnings {
        $result = new ScrapeResult_warnings();
        if ($parseNode->getCollectionOfPrimitiveValues('string') !== null) {
            $result->setString($parseNode->getCollectionOfPrimitiveValues('string'));
        } else {
            $result->setScrapeResultWarningsMember1(new ScrapeResult_warningsMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeResultWarningsMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeResultWarningsMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeResult_warningsMember1 property value. Composed type representation for type ScrapeResult_warningsMember1
     * @return ScrapeResult_warningsMember1|null
    */
    public function getScrapeResultWarningsMember1(): ?ScrapeResult_warningsMember1 {
        return $this->scrapeResult_warningsMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeResultWarningsMember1());
        }
    }

    /**
     * Sets the ScrapeResult_warningsMember1 property value. Composed type representation for type ScrapeResult_warningsMember1
     * @param ScrapeResult_warningsMember1|null $value Value to set for the ScrapeResult_warningsMember1 property.
    */
    public function setScrapeResultWarningsMember1(?ScrapeResult_warningsMember1 $value): void {
        $this->scrapeResult_warningsMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type array
     * @param array<string>|null $value Value to set for the string property.
    */
    public function setString(?array $value): void {
        $this->string = $value;
    }

}
