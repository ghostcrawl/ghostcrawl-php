<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ContentRequest_proxyMember1, string
*/
class ContentRequest_proxy implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ContentRequest_proxyMember1|null $contentRequest_proxyMember1 Composed type representation for type ContentRequest_proxyMember1
    */
    private ?ContentRequest_proxyMember1 $contentRequest_proxyMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ContentRequest_proxy
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ContentRequest_proxy {
        $result = new ContentRequest_proxy();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setContentRequestProxyMember1(new ContentRequest_proxyMember1());
        }
        return $result;
    }

    /**
     * Gets the ContentRequest_proxyMember1 property value. Composed type representation for type ContentRequest_proxyMember1
     * @return ContentRequest_proxyMember1|null
    */
    public function getContentRequestProxyMember1(): ?ContentRequest_proxyMember1 {
        return $this->contentRequest_proxyMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getContentRequestProxyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getContentRequestProxyMember1());
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
            $writer->writeObjectValue(null, $this->getContentRequestProxyMember1());
        }
    }

    /**
     * Sets the ContentRequest_proxyMember1 property value. Composed type representation for type ContentRequest_proxyMember1
     * @param ContentRequest_proxyMember1|null $value Value to set for the ContentRequest_proxyMember1 property.
    */
    public function setContentRequestProxyMember1(?ContentRequest_proxyMember1 $value): void {
        $this->contentRequest_proxyMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
