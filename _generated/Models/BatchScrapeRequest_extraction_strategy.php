<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes BatchScrapeRequest_extraction_strategyMember1, string
*/
class BatchScrapeRequest_extraction_strategy implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var BatchScrapeRequest_extraction_strategyMember1|null $batchScrapeRequest_extraction_strategyMember1 Composed type representation for type BatchScrapeRequest_extraction_strategyMember1
    */
    private ?BatchScrapeRequest_extraction_strategyMember1 $batchScrapeRequest_extraction_strategyMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return BatchScrapeRequest_extraction_strategy
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): BatchScrapeRequest_extraction_strategy {
        $result = new BatchScrapeRequest_extraction_strategy();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setBatchScrapeRequestExtractionStrategyMember1(new BatchScrapeRequest_extraction_strategyMember1());
        }
        return $result;
    }

    /**
     * Gets the BatchScrapeRequest_extraction_strategyMember1 property value. Composed type representation for type BatchScrapeRequest_extraction_strategyMember1
     * @return BatchScrapeRequest_extraction_strategyMember1|null
    */
    public function getBatchScrapeRequestExtractionStrategyMember1(): ?BatchScrapeRequest_extraction_strategyMember1 {
        return $this->batchScrapeRequest_extraction_strategyMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getBatchScrapeRequestExtractionStrategyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getBatchScrapeRequestExtractionStrategyMember1());
        }
        return [];
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
            $writer->writeObjectValue(null, $this->getBatchScrapeRequestExtractionStrategyMember1());
        }
    }

    /**
     * Sets the BatchScrapeRequest_extraction_strategyMember1 property value. Composed type representation for type BatchScrapeRequest_extraction_strategyMember1
     * @param BatchScrapeRequest_extraction_strategyMember1|null $value Value to set for the BatchScrapeRequest_extraction_strategyMember1 property.
    */
    public function setBatchScrapeRequestExtractionStrategyMember1(?BatchScrapeRequest_extraction_strategyMember1 $value): void {
        $this->batchScrapeRequest_extraction_strategyMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
