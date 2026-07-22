<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes IdentityRequest_viewportMember1, string, ViewportExact
*/
class IdentityRequest_viewport implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var IdentityRequest_viewportMember1|null $identityRequest_viewportMember1 Composed type representation for type IdentityRequest_viewportMember1
    */
    private ?IdentityRequest_viewportMember1 $identityRequest_viewportMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var ViewportExact|null $viewportExact Composed type representation for type ViewportExact
    */
    private ?ViewportExact $viewportExact = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityRequest_viewport
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityRequest_viewport {
        $result = new IdentityRequest_viewport();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setIdentityRequestViewportMember1(new IdentityRequest_viewportMember1());
            $result->setViewportExact(new ViewportExact());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getIdentityRequestViewportMember1() !== null || $this->getViewportExact() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getIdentityRequestViewportMember1(), $this->getViewportExact());
        }
        return [];
    }

    /**
     * Gets the IdentityRequest_viewportMember1 property value. Composed type representation for type IdentityRequest_viewportMember1
     * @return IdentityRequest_viewportMember1|null
    */
    public function getIdentityRequestViewportMember1(): ?IdentityRequest_viewportMember1 {
        return $this->identityRequest_viewportMember1;
    }

    /**
     * Gets the string property value. Composed type representation for type string
     * @return string|null
    */
    public function getString(): ?string {
        return $this->string;
    }

    /**
     * Gets the ViewportExact property value. Composed type representation for type ViewportExact
     * @return ViewportExact|null
    */
    public function getViewportExact(): ?ViewportExact {
        return $this->viewportExact;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getIdentityRequestViewportMember1(), $this->getViewportExact());
        }
    }

    /**
     * Sets the IdentityRequest_viewportMember1 property value. Composed type representation for type IdentityRequest_viewportMember1
     * @param IdentityRequest_viewportMember1|null $value Value to set for the IdentityRequest_viewportMember1 property.
    */
    public function setIdentityRequestViewportMember1(?IdentityRequest_viewportMember1 $value): void {
        $this->identityRequest_viewportMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

    /**
     * Sets the ViewportExact property value. Composed type representation for type ViewportExact
     * @param ViewportExact|null $value Value to set for the ViewportExact property.
    */
    public function setViewportExact(?ViewportExact $value): void {
        $this->viewportExact = $value;
    }

}
