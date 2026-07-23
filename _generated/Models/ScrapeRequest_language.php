<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrapeRequest_languageMember1, string
*/
class ScrapeRequest_language implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeRequest_languageMember1|null $scrapeRequest_languageMember1 Composed type representation for type ScrapeRequest_languageMember1
    */
    private ?ScrapeRequest_languageMember1 $scrapeRequest_languageMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest_language
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest_language {
        $result = new ScrapeRequest_language();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrapeRequestLanguageMember1(new ScrapeRequest_languageMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeRequestLanguageMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeRequestLanguageMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeRequest_languageMember1 property value. Composed type representation for type ScrapeRequest_languageMember1
     * @return ScrapeRequest_languageMember1|null
    */
    public function getScrapeRequestLanguageMember1(): ?ScrapeRequest_languageMember1 {
        return $this->scrapeRequest_languageMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeRequestLanguageMember1());
        }
    }

    /**
     * Sets the ScrapeRequest_languageMember1 property value. Composed type representation for type ScrapeRequest_languageMember1
     * @param ScrapeRequest_languageMember1|null $value Value to set for the ScrapeRequest_languageMember1 property.
    */
    public function setScrapeRequestLanguageMember1(?ScrapeRequest_languageMember1 $value): void {
        $this->scrapeRequest_languageMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
