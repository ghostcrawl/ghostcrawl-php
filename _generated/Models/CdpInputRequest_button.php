<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CdpInputRequest_buttonMember1, string
*/
class CdpInputRequest_button implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CdpInputRequest_buttonMember1|null $cdpInputRequest_buttonMember1 Composed type representation for type CdpInputRequest_buttonMember1
    */
    private ?CdpInputRequest_buttonMember1 $cdpInputRequest_buttonMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CdpInputRequest_button
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CdpInputRequest_button {
        $result = new CdpInputRequest_button();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCdpInputRequestButtonMember1(new CdpInputRequest_buttonMember1());
        }
        return $result;
    }

    /**
     * Gets the CdpInputRequest_buttonMember1 property value. Composed type representation for type CdpInputRequest_buttonMember1
     * @return CdpInputRequest_buttonMember1|null
    */
    public function getCdpInputRequestButtonMember1(): ?CdpInputRequest_buttonMember1 {
        return $this->cdpInputRequest_buttonMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCdpInputRequestButtonMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCdpInputRequestButtonMember1());
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
            $writer->writeObjectValue(null, $this->getCdpInputRequestButtonMember1());
        }
    }

    /**
     * Sets the CdpInputRequest_buttonMember1 property value. Composed type representation for type CdpInputRequest_buttonMember1
     * @param CdpInputRequest_buttonMember1|null $value Value to set for the CdpInputRequest_buttonMember1 property.
    */
    public function setCdpInputRequestButtonMember1(?CdpInputRequest_buttonMember1 $value): void {
        $this->cdpInputRequest_buttonMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
