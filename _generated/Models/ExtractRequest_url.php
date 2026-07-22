<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ExtractRequest_urlMember1, string
*/
class ExtractRequest_url implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ExtractRequest_urlMember1|null $extractRequest_urlMember1 Composed type representation for type ExtractRequest_urlMember1
    */
    private ?ExtractRequest_urlMember1 $extractRequest_urlMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest_url
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest_url {
        $result = new ExtractRequest_url();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setExtractRequestUrlMember1(new ExtractRequest_urlMember1());
        }
        return $result;
    }

    /**
     * Gets the ExtractRequest_urlMember1 property value. Composed type representation for type ExtractRequest_urlMember1
     * @return ExtractRequest_urlMember1|null
    */
    public function getExtractRequestUrlMember1(): ?ExtractRequest_urlMember1 {
        return $this->extractRequest_urlMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtractRequestUrlMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtractRequestUrlMember1());
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
            $writer->writeObjectValue(null, $this->getExtractRequestUrlMember1());
        }
    }

    /**
     * Sets the ExtractRequest_urlMember1 property value. Composed type representation for type ExtractRequest_urlMember1
     * @param ExtractRequest_urlMember1|null $value Value to set for the ExtractRequest_urlMember1 property.
    */
    public function setExtractRequestUrlMember1(?ExtractRequest_urlMember1 $value): void {
        $this->extractRequest_urlMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
