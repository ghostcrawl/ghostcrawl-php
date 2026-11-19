<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CdpInputRequest_textMember1, string
*/
class CdpInputRequest_text implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CdpInputRequest_textMember1|null $cdpInputRequest_textMember1 Composed type representation for type CdpInputRequest_textMember1
    */
    private ?CdpInputRequest_textMember1 $cdpInputRequest_textMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CdpInputRequest_text
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CdpInputRequest_text {
        $result = new CdpInputRequest_text();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCdpInputRequestTextMember1(new CdpInputRequest_textMember1());
        }
        return $result;
    }

    /**
     * Gets the CdpInputRequest_textMember1 property value. Composed type representation for type CdpInputRequest_textMember1
     * @return CdpInputRequest_textMember1|null
    */
    public function getCdpInputRequestTextMember1(): ?CdpInputRequest_textMember1 {
        return $this->cdpInputRequest_textMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCdpInputRequestTextMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCdpInputRequestTextMember1());
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
            $writer->writeObjectValue(null, $this->getCdpInputRequestTextMember1());
        }
    }

    /**
     * Sets the CdpInputRequest_textMember1 property value. Composed type representation for type CdpInputRequest_textMember1
     * @param CdpInputRequest_textMember1|null $value Value to set for the CdpInputRequest_textMember1 property.
    */
    public function setCdpInputRequestTextMember1(?CdpInputRequest_textMember1 $value): void {
        $this->cdpInputRequest_textMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
