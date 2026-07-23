<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScreenshotRequest_proxyMember1, string
*/
class ScreenshotRequest_proxy implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScreenshotRequest_proxyMember1|null $screenshotRequest_proxyMember1 Composed type representation for type ScreenshotRequest_proxyMember1
    */
    private ?ScreenshotRequest_proxyMember1 $screenshotRequest_proxyMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScreenshotRequest_proxy
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScreenshotRequest_proxy {
        $result = new ScreenshotRequest_proxy();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScreenshotRequestProxyMember1(new ScreenshotRequest_proxyMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScreenshotRequestProxyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScreenshotRequestProxyMember1());
        }
        return [];
    }

    /**
     * Gets the ScreenshotRequest_proxyMember1 property value. Composed type representation for type ScreenshotRequest_proxyMember1
     * @return ScreenshotRequest_proxyMember1|null
    */
    public function getScreenshotRequestProxyMember1(): ?ScreenshotRequest_proxyMember1 {
        return $this->screenshotRequest_proxyMember1;
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
            $writer->writeObjectValue(null, $this->getScreenshotRequestProxyMember1());
        }
    }

    /**
     * Sets the ScreenshotRequest_proxyMember1 property value. Composed type representation for type ScreenshotRequest_proxyMember1
     * @param ScreenshotRequest_proxyMember1|null $value Value to set for the ScreenshotRequest_proxyMember1 property.
    */
    public function setScreenshotRequestProxyMember1(?ScreenshotRequest_proxyMember1 $value): void {
        $this->screenshotRequest_proxyMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
