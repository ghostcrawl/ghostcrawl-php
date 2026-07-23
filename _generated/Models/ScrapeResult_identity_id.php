<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, ScrapeResult_identity_idMember1
*/
class ScrapeResult_identity_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var ScrapeResult_identity_idMember1|null $scrapeResult_identity_idMember1 Composed type representation for type ScrapeResult_identity_idMember1
    */
    private ?ScrapeResult_identity_idMember1 $scrapeResult_identity_idMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult_identity_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult_identity_id {
        $result = new ScrapeResult_identity_id();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setScrapeResultIdentityIdMember1(new ScrapeResult_identity_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeResultIdentityIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeResultIdentityIdMember1());
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
     * Gets the ScrapeResult_identity_idMember1 property value. Composed type representation for type ScrapeResult_identity_idMember1
     * @return ScrapeResult_identity_idMember1|null
    */
    public function getScrapeResultIdentityIdMember1(): ?ScrapeResult_identity_idMember1 {
        return $this->scrapeResult_identity_idMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getScrapeResultIdentityIdMember1());
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
     * Sets the ScrapeResult_identity_idMember1 property value. Composed type representation for type ScrapeResult_identity_idMember1
     * @param ScrapeResult_identity_idMember1|null $value Value to set for the ScrapeResult_identity_idMember1 property.
    */
    public function setScrapeResultIdentityIdMember1(?ScrapeResult_identity_idMember1 $value): void {
        $this->scrapeResult_identity_idMember1 = $value;
    }

}
