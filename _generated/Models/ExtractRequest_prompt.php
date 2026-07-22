<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ExtractRequest_promptMember1, string
*/
class ExtractRequest_prompt implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ExtractRequest_promptMember1|null $extractRequest_promptMember1 Composed type representation for type ExtractRequest_promptMember1
    */
    private ?ExtractRequest_promptMember1 $extractRequest_promptMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest_prompt
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest_prompt {
        $result = new ExtractRequest_prompt();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setExtractRequestPromptMember1(new ExtractRequest_promptMember1());
        }
        return $result;
    }

    /**
     * Gets the ExtractRequest_promptMember1 property value. Composed type representation for type ExtractRequest_promptMember1
     * @return ExtractRequest_promptMember1|null
    */
    public function getExtractRequestPromptMember1(): ?ExtractRequest_promptMember1 {
        return $this->extractRequest_promptMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtractRequestPromptMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtractRequestPromptMember1());
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
            $writer->writeObjectValue(null, $this->getExtractRequestPromptMember1());
        }
    }

    /**
     * Sets the ExtractRequest_promptMember1 property value. Composed type representation for type ExtractRequest_promptMember1
     * @param ExtractRequest_promptMember1|null $value Value to set for the ExtractRequest_promptMember1 property.
    */
    public function setExtractRequestPromptMember1(?ExtractRequest_promptMember1 $value): void {
        $this->extractRequest_promptMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
