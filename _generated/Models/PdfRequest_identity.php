<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes PdfRequest_identityMember1, string
*/
class PdfRequest_identity implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var PdfRequest_identityMember1|null $pdfRequest_identityMember1 Composed type representation for type PdfRequest_identityMember1
    */
    private ?PdfRequest_identityMember1 $pdfRequest_identityMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PdfRequest_identity
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PdfRequest_identity {
        $result = new PdfRequest_identity();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setPdfRequestIdentityMember1(new PdfRequest_identityMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getPdfRequestIdentityMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getPdfRequestIdentityMember1());
        }
        return [];
    }

    /**
     * Gets the PdfRequest_identityMember1 property value. Composed type representation for type PdfRequest_identityMember1
     * @return PdfRequest_identityMember1|null
    */
    public function getPdfRequestIdentityMember1(): ?PdfRequest_identityMember1 {
        return $this->pdfRequest_identityMember1;
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
            $writer->writeObjectValue(null, $this->getPdfRequestIdentityMember1());
        }
    }

    /**
     * Sets the PdfRequest_identityMember1 property value. Composed type representation for type PdfRequest_identityMember1
     * @param PdfRequest_identityMember1|null $value Value to set for the PdfRequest_identityMember1 property.
    */
    public function setPdfRequestIdentityMember1(?PdfRequest_identityMember1 $value): void {
        $this->pdfRequest_identityMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
