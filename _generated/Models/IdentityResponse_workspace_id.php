<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityResponse_workspace_idMember1, string
*/
class IdentityResponse_workspace_id implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityResponse_workspace_idMember1|null $identityResponse_workspace_idMember1 Composed type representation for type IdentityResponse_workspace_idMember1
    */
    private ?IdentityResponse_workspace_idMember1 $identityResponse_workspace_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityResponse_workspace_id
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityResponse_workspace_id {
        $result = new IdentityResponse_workspace_id();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityResponseWorkspaceIdMember1(new IdentityResponse_workspace_idMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityResponseWorkspaceIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityResponseWorkspaceIdMember1());
        }
        return [];
    }

    /**
     * Gets the IdentityResponse_workspace_idMember1 property value. Composed type representation for type IdentityResponse_workspace_idMember1
     * @return IdentityResponse_workspace_idMember1|null
    */
    public function getIdentityResponseWorkspaceIdMember1(): ?IdentityResponse_workspace_idMember1 {
        return $this->identityResponse_workspace_idMember1;
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
            $writer->writeObjectValue(null, $this->getIdentityResponseWorkspaceIdMember1());
        }
    }

    /**
     * Sets the IdentityResponse_workspace_idMember1 property value. Composed type representation for type IdentityResponse_workspace_idMember1
     * @param IdentityResponse_workspace_idMember1|null $value Value to set for the IdentityResponse_workspace_idMember1 property.
    */
    public function setIdentityResponseWorkspaceIdMember1(?IdentityResponse_workspace_idMember1 $value): void {
        $this->identityResponse_workspace_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
