<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes PdfRequest_languageMember1, string
*/
class PdfRequest_language implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var PdfRequest_languageMember1|null $pdfRequest_languageMember1 Composed type representation for type PdfRequest_languageMember1
    */
    private ?PdfRequest_languageMember1 $pdfRequest_languageMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PdfRequest_language
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PdfRequest_language {
        $result = new PdfRequest_language();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setPdfRequestLanguageMember1(new PdfRequest_languageMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getPdfRequestLanguageMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getPdfRequestLanguageMember1());
        }
        return [];
    }

    /**
     * Gets the PdfRequest_languageMember1 property value. Composed type representation for type PdfRequest_languageMember1
     * @return PdfRequest_languageMember1|null
    */
    public function getPdfRequestLanguageMember1(): ?PdfRequest_languageMember1 {
        return $this->pdfRequest_languageMember1;
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
            $writer->writeObjectValue(null, $this->getPdfRequestLanguageMember1());
        }
    }

    /**
     * Sets the PdfRequest_languageMember1 property value. Composed type representation for type PdfRequest_languageMember1
     * @param PdfRequest_languageMember1|null $value Value to set for the PdfRequest_languageMember1 property.
    */
    public function setPdfRequestLanguageMember1(?PdfRequest_languageMember1 $value): void {
        $this->pdfRequest_languageMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
