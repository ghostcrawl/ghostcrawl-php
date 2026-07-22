<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes BatchScrapeRequest_languageMember1, string
*/
class BatchScrapeRequest_language implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var BatchScrapeRequest_languageMember1|null $batchScrapeRequest_languageMember1 Composed type representation for type BatchScrapeRequest_languageMember1
    */
    private ?BatchScrapeRequest_languageMember1 $batchScrapeRequest_languageMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return BatchScrapeRequest_language
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): BatchScrapeRequest_language {
        $result = new BatchScrapeRequest_language();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setBatchScrapeRequestLanguageMember1(new BatchScrapeRequest_languageMember1());
        }
        return $result;
    }

    /**
     * Gets the BatchScrapeRequest_languageMember1 property value. Composed type representation for type BatchScrapeRequest_languageMember1
     * @return BatchScrapeRequest_languageMember1|null
    */
    public function getBatchScrapeRequestLanguageMember1(): ?BatchScrapeRequest_languageMember1 {
        return $this->batchScrapeRequest_languageMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getBatchScrapeRequestLanguageMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getBatchScrapeRequestLanguageMember1());
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
            $writer->writeObjectValue(null, $this->getBatchScrapeRequestLanguageMember1());
        }
    }

    /**
     * Sets the BatchScrapeRequest_languageMember1 property value. Composed type representation for type BatchScrapeRequest_languageMember1
     * @param BatchScrapeRequest_languageMember1|null $value Value to set for the BatchScrapeRequest_languageMember1 property.
    */
    public function setBatchScrapeRequestLanguageMember1(?BatchScrapeRequest_languageMember1 $value): void {
        $this->batchScrapeRequest_languageMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
