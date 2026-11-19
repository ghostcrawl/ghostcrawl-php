<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes CdpInputRequest_urlMember1, string
*/
class CdpInputRequest_url implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var CdpInputRequest_urlMember1|null $cdpInputRequest_urlMember1 Composed type representation for type CdpInputRequest_urlMember1
    */
    private ?CdpInputRequest_urlMember1 $cdpInputRequest_urlMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CdpInputRequest_url
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CdpInputRequest_url {
        $result = new CdpInputRequest_url();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setCdpInputRequestUrlMember1(new CdpInputRequest_urlMember1());
        }
        return $result;
    }

    /**
     * Gets the CdpInputRequest_urlMember1 property value. Composed type representation for type CdpInputRequest_urlMember1
     * @return CdpInputRequest_urlMember1|null
    */
    public function getCdpInputRequestUrlMember1(): ?CdpInputRequest_urlMember1 {
        return $this->cdpInputRequest_urlMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getCdpInputRequestUrlMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getCdpInputRequestUrlMember1());
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
            $writer->writeObjectValue(null, $this->getCdpInputRequestUrlMember1());
        }
    }

    /**
     * Sets the CdpInputRequest_urlMember1 property value. Composed type representation for type CdpInputRequest_urlMember1
     * @param CdpInputRequest_urlMember1|null $value Value to set for the CdpInputRequest_urlMember1 property.
    */
    public function setCdpInputRequestUrlMember1(?CdpInputRequest_urlMember1 $value): void {
        $this->cdpInputRequest_urlMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
