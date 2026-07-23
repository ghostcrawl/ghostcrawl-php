<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes PdfRequest_profileMember1, string
*/
class PdfRequest_profile implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var PdfRequest_profileMember1|null $pdfRequest_profileMember1 Composed type representation for type PdfRequest_profileMember1
    */
    private ?PdfRequest_profileMember1 $pdfRequest_profileMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PdfRequest_profile
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PdfRequest_profile {
        $result = new PdfRequest_profile();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setPdfRequestProfileMember1(new PdfRequest_profileMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getPdfRequestProfileMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getPdfRequestProfileMember1());
        }
        return [];
    }

    /**
     * Gets the PdfRequest_profileMember1 property value. Composed type representation for type PdfRequest_profileMember1
     * @return PdfRequest_profileMember1|null
    */
    public function getPdfRequestProfileMember1(): ?PdfRequest_profileMember1 {
        return $this->pdfRequest_profileMember1;
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
            $writer->writeObjectValue(null, $this->getPdfRequestProfileMember1());
        }
    }

    /**
     * Sets the PdfRequest_profileMember1 property value. Composed type representation for type PdfRequest_profileMember1
     * @param PdfRequest_profileMember1|null $value Value to set for the PdfRequest_profileMember1 property.
    */
    public function setPdfRequestProfileMember1(?PdfRequest_profileMember1 $value): void {
        $this->pdfRequest_profileMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
