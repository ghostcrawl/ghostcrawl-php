<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityRequest_proxyMember1, string
*/
class IdentityRequest_proxy implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityRequest_proxyMember1|null $identityRequest_proxyMember1 Composed type representation for type IdentityRequest_proxyMember1
    */
    private ?IdentityRequest_proxyMember1 $identityRequest_proxyMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityRequest_proxy
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityRequest_proxy {
        $result = new IdentityRequest_proxy();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityRequestProxyMember1(new IdentityRequest_proxyMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityRequestProxyMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityRequestProxyMember1());
        }
        return [];
    }

    /**
     * Gets the IdentityRequest_proxyMember1 property value. Composed type representation for type IdentityRequest_proxyMember1
     * @return IdentityRequest_proxyMember1|null
    */
    public function getIdentityRequestProxyMember1(): ?IdentityRequest_proxyMember1 {
        return $this->identityRequest_proxyMember1;
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
            $writer->writeObjectValue(null, $this->getIdentityRequestProxyMember1());
        }
    }

    /**
     * Sets the IdentityRequest_proxyMember1 property value. Composed type representation for type IdentityRequest_proxyMember1
     * @param IdentityRequest_proxyMember1|null $value Value to set for the IdentityRequest_proxyMember1 property.
    */
    public function setIdentityRequestProxyMember1(?IdentityRequest_proxyMember1 $value): void {
        $this->identityRequest_proxyMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
