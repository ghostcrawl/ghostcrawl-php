<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, ScrapeRequest_timeout_msMember1
*/
class ScrapeRequest_timeout_ms implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var ScrapeRequest_timeout_msMember1|null $scrapeRequest_timeout_msMember1 Composed type representation for type ScrapeRequest_timeout_msMember1
    */
    private ?ScrapeRequest_timeout_msMember1 $scrapeRequest_timeout_msMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest_timeout_ms
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest_timeout_ms {
        $result = new ScrapeRequest_timeout_ms();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setScrapeRequestTimeoutMsMember1(new ScrapeRequest_timeout_msMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeRequestTimeoutMsMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeRequestTimeoutMsMember1());
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
     * Gets the ScrapeRequest_timeout_msMember1 property value. Composed type representation for type ScrapeRequest_timeout_msMember1
     * @return ScrapeRequest_timeout_msMember1|null
    */
    public function getScrapeRequestTimeoutMsMember1(): ?ScrapeRequest_timeout_msMember1 {
        return $this->scrapeRequest_timeout_msMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getScrapeRequestTimeoutMsMember1());
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
     * Sets the ScrapeRequest_timeout_msMember1 property value. Composed type representation for type ScrapeRequest_timeout_msMember1
     * @param ScrapeRequest_timeout_msMember1|null $value Value to set for the ScrapeRequest_timeout_msMember1 property.
    */
    public function setScrapeRequestTimeoutMsMember1(?ScrapeRequest_timeout_msMember1 $value): void {
        $this->scrapeRequest_timeout_msMember1 = $value;
    }

}
