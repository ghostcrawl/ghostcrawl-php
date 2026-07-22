<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityRequest_claim_browserMember1, string
*/
class IdentityRequest_claim_browser implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityRequest_claim_browserMember1|null $identityRequest_claim_browserMember1 Composed type representation for type IdentityRequest_claim_browserMember1
    */
    private ?IdentityRequest_claim_browserMember1 $identityRequest_claim_browserMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityRequest_claim_browser
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityRequest_claim_browser {
        $result = new IdentityRequest_claim_browser();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityRequestClaimBrowserMember1(new IdentityRequest_claim_browserMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityRequestClaimBrowserMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityRequestClaimBrowserMember1());
        }
        return [];
    }

    /**
     * Gets the IdentityRequest_claim_browserMember1 property value. Composed type representation for type IdentityRequest_claim_browserMember1
     * @return IdentityRequest_claim_browserMember1|null
    */
    public function getIdentityRequestClaimBrowserMember1(): ?IdentityRequest_claim_browserMember1 {
        return $this->identityRequest_claim_browserMember1;
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
            $writer->writeObjectValue(null, $this->getIdentityRequestClaimBrowserMember1());
        }
    }

    /**
     * Sets the IdentityRequest_claim_browserMember1 property value. Composed type representation for type IdentityRequest_claim_browserMember1
     * @param IdentityRequest_claim_browserMember1|null $value Value to set for the IdentityRequest_claim_browserMember1 property.
    */
    public function setIdentityRequestClaimBrowserMember1(?IdentityRequest_claim_browserMember1 $value): void {
        $this->identityRequest_claim_browserMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
