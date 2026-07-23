<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, ScrapeResult_token_estimateMember1
*/
class ScrapeResult_token_estimate implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var ScrapeResult_token_estimateMember1|null $scrapeResult_token_estimateMember1 Composed type representation for type ScrapeResult_token_estimateMember1
    */
    private ?ScrapeResult_token_estimateMember1 $scrapeResult_token_estimateMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult_token_estimate
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult_token_estimate {
        $result = new ScrapeResult_token_estimate();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setScrapeResultTokenEstimateMember1(new ScrapeResult_token_estimateMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeResultTokenEstimateMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeResultTokenEstimateMember1());
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
     * Gets the ScrapeResult_token_estimateMember1 property value. Composed type representation for type ScrapeResult_token_estimateMember1
     * @return ScrapeResult_token_estimateMember1|null
    */
    public function getScrapeResultTokenEstimateMember1(): ?ScrapeResult_token_estimateMember1 {
        return $this->scrapeResult_token_estimateMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getScrapeResultTokenEstimateMember1());
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
     * Sets the ScrapeResult_token_estimateMember1 property value. Composed type representation for type ScrapeResult_token_estimateMember1
     * @param ScrapeResult_token_estimateMember1|null $value Value to set for the ScrapeResult_token_estimateMember1 property.
    */
    public function setScrapeResultTokenEstimateMember1(?ScrapeResult_token_estimateMember1 $value): void {
        $this->scrapeResult_token_estimateMember1 = $value;
    }

}
