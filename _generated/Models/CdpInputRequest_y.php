<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CdpInputRequest_yMember1, float
*/
class CdpInputRequest_y implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CdpInputRequest_yMember1|null $cdpInputRequest_yMember1 Composed type representation for type CdpInputRequest_yMember1
    */
    private ?CdpInputRequest_yMember1 $cdpInputRequest_yMember1 = null;
    
    /**
     * @var float|null $double Composed type representation for type float
    */
    private ?float $double = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CdpInputRequest_y
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CdpInputRequest_y {
        $result = new CdpInputRequest_y();
        if ($parseNode->getFloatValue() !== null) {
            $result->setDouble($parseNode->getFloatValue());
        } else {
            $result->setCdpInputRequestYMember1(new CdpInputRequest_yMember1());
        }
        return $result;
    }

    /**
     * Gets the CdpInputRequest_yMember1 property value. Composed type representation for type CdpInputRequest_yMember1
     * @return CdpInputRequest_yMember1|null
    */
    public function getCdpInputRequestYMember1(): ?CdpInputRequest_yMember1 {
        return $this->cdpInputRequest_yMember1;
    }

    /**
     * Gets the double property value. Composed type representation for type float
     * @return float|null
    */
    public function getDouble(): ?float {
        return $this->double;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCdpInputRequestYMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCdpInputRequestYMember1());
        }
        return [];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getDouble() !== null) {
            $writer->writeFloatValue(null, $this->getDouble());
        } else {
            $writer->writeObjectValue(null, $this->getCdpInputRequestYMember1());
        }
    }

    /**
     * Sets the CdpInputRequest_yMember1 property value. Composed type representation for type CdpInputRequest_yMember1
     * @param CdpInputRequest_yMember1|null $value Value to set for the CdpInputRequest_yMember1 property.
    */
    public function setCdpInputRequestYMember1(?CdpInputRequest_yMember1 $value): void {
        $this->cdpInputRequest_yMember1 = $value;
    }

    /**
     * Sets the double property value. Composed type representation for type float
     * @param float|null $value Value to set for the double property.
    */
    public function setDouble(?float $value): void {
        $this->double = $value;
    }

}
