<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Composed type wrapper for classes array, ExtractRequest_urlsMember1
*/
class ExtractRequest_urls implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ExtractRequest_urlsMember1|null $extractRequest_urlsMember1 Composed type representation for type ExtractRequest_urlsMember1
    */
    private ?ExtractRequest_urlsMember1 $extractRequest_urlsMember1 = null;
    
    /**
     * @var array<string>|null $string Composed type representation for type array
    */
    private ?array $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest_urls
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest_urls {
        $result = new ExtractRequest_urls();
        if ($parseNode->getCollectionOfPrimitiveValues('string') !== null) {
            $result->setString($parseNode->getCollectionOfPrimitiveValues('string'));
        } else {
            $result->setExtractRequestUrlsMember1(new ExtractRequest_urlsMember1());
        }
        return $result;
    }

    /**
     * Gets the ExtractRequest_urlsMember1 property value. Composed type representation for type ExtractRequest_urlsMember1
     * @return ExtractRequest_urlsMember1|null
    */
    public function getExtractRequestUrlsMember1(): ?ExtractRequest_urlsMember1 {
        return $this->extractRequest_urlsMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtractRequestUrlsMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtractRequestUrlsMember1());
        }
        return [];
    }

    /**
     * Gets the string property value. Composed type representation for type array
     * @return array<string>|null
    */
    public function getString(): ?array {
        return $this->string;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeCollectionOfPrimitiveValues(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getExtractRequestUrlsMember1());
        }
    }

    /**
     * Sets the ExtractRequest_urlsMember1 property value. Composed type representation for type ExtractRequest_urlsMember1
     * @param ExtractRequest_urlsMember1|null $value Value to set for the ExtractRequest_urlsMember1 property.
    */
    public function setExtractRequestUrlsMember1(?ExtractRequest_urlsMember1 $value): void {
        $this->extractRequest_urlsMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type array
     * @param array<string>|null $value Value to set for the string property.
    */
    public function setString(?array $value): void {
        $this->string = $value;
    }

}
