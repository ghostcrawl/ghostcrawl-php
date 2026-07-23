<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrapeResult_markdownMember1, string
*/
class ScrapeResult_markdown implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeResult_markdownMember1|null $scrapeResult_markdownMember1 Composed type representation for type ScrapeResult_markdownMember1
    */
    private ?ScrapeResult_markdownMember1 $scrapeResult_markdownMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult_markdown
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult_markdown {
        $result = new ScrapeResult_markdown();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrapeResultMarkdownMember1(new ScrapeResult_markdownMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeResultMarkdownMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeResultMarkdownMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeResult_markdownMember1 property value. Composed type representation for type ScrapeResult_markdownMember1
     * @return ScrapeResult_markdownMember1|null
    */
    public function getScrapeResultMarkdownMember1(): ?ScrapeResult_markdownMember1 {
        return $this->scrapeResult_markdownMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeResultMarkdownMember1());
        }
    }

    /**
     * Sets the ScrapeResult_markdownMember1 property value. Composed type representation for type ScrapeResult_markdownMember1
     * @param ScrapeResult_markdownMember1|null $value Value to set for the ScrapeResult_markdownMember1 property.
    */
    public function setScrapeResultMarkdownMember1(?ScrapeResult_markdownMember1 $value): void {
        $this->scrapeResult_markdownMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
