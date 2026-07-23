<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrapeRequest_proxyMember1, string
*/
class ScrapeRequest_proxy implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrapeRequest_proxyMember1|null $scrapeRequest_proxyMember1 Composed type representation for type ScrapeRequest_proxyMember1
    */
    private ?ScrapeRequest_proxyMember1 $scrapeRequest_proxyMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest_proxy
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest_proxy {
        $result = new ScrapeRequest_proxy();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrapeRequestProxyMember1(new ScrapeRequest_proxyMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeRequestProxyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeRequestProxyMember1());
        }
        return [];
    }

    /**
     * Gets the ScrapeRequest_proxyMember1 property value. Composed type representation for type ScrapeRequest_proxyMember1
     * @return ScrapeRequest_proxyMember1|null
    */
    public function getScrapeRequestProxyMember1(): ?ScrapeRequest_proxyMember1 {
        return $this->scrapeRequest_proxyMember1;
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
            $writer->writeObjectValue(null, $this->getScrapeRequestProxyMember1());
        }
    }

    /**
     * Sets the ScrapeRequest_proxyMember1 property value. Composed type representation for type ScrapeRequest_proxyMember1
     * @param ScrapeRequest_proxyMember1|null $value Value to set for the ScrapeRequest_proxyMember1 property.
    */
    public function setScrapeRequestProxyMember1(?ScrapeRequest_proxyMember1 $value): void {
        $this->scrapeRequest_proxyMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
