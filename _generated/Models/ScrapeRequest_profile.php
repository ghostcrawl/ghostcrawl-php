<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrapeRequest_profileMember1, string
*/
class ScrapeRequest_profile implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeRequest_profileMember1|null $scrapeRequest_profileMember1 Composed type representation for type ScrapeRequest_profileMember1
    */
    private ?ScrapeRequest_profileMember1 $scrapeRequest_profileMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest_profile
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest_profile {
        $result = new ScrapeRequest_profile();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrapeRequestProfileMember1(new ScrapeRequest_profileMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeRequestProfileMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeRequestProfileMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeRequest_profileMember1 property value. Composed type representation for type ScrapeRequest_profileMember1
     * @return ScrapeRequest_profileMember1|null
    */
    public function getScrapeRequestProfileMember1(): ?ScrapeRequest_profileMember1 {
        return $this->scrapeRequest_profileMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeRequestProfileMember1());
        }
    }

    /**
     * Sets the ScrapeRequest_profileMember1 property value. Composed type representation for type ScrapeRequest_profileMember1
     * @param ScrapeRequest_profileMember1|null $value Value to set for the ScrapeRequest_profileMember1 property.
    */
    public function setScrapeRequestProfileMember1(?ScrapeRequest_profileMember1 $value): void {
        $this->scrapeRequest_profileMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
