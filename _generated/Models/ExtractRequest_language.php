<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ExtractRequest_languageMember1, string
*/
class ExtractRequest_language implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ExtractRequest_languageMember1|null $extractRequest_languageMember1 Composed type representation for type ExtractRequest_languageMember1
    */
    private ?ExtractRequest_languageMember1 $extractRequest_languageMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest_language
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest_language {
        $result = new ExtractRequest_language();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setExtractRequestLanguageMember1(new ExtractRequest_languageMember1());
        }
        return $result;
    }

    /**
     * Gets the ExtractRequest_languageMember1 property value. Composed type representation for type ExtractRequest_languageMember1
     * @return ExtractRequest_languageMember1|null
    */
    public function getExtractRequestLanguageMember1(): ?ExtractRequest_languageMember1 {
        return $this->extractRequest_languageMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtractRequestLanguageMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtractRequestLanguageMember1());
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
            $writer->writeObjectValue(null, $this->getExtractRequestLanguageMember1());
        }
    }

    /**
     * Sets the ExtractRequest_languageMember1 property value. Composed type representation for type ExtractRequest_languageMember1
     * @param ExtractRequest_languageMember1|null $value Value to set for the ExtractRequest_languageMember1 property.
    */
    public function setExtractRequestLanguageMember1(?ExtractRequest_languageMember1 $value): void {
        $this->extractRequest_languageMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
