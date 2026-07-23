<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WaitBody_selectorMember1
*/
class WaitBody_selector implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * @var WaitBody_selectorMember1|null $waitBody_selectorMember1 Composed type representation for type WaitBody_selectorMember1
    */
    private ?WaitBody_selectorMember1 $waitBody_selectorMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WaitBody_selector
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WaitBody_selector {
        $result = new WaitBody_selector();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setWaitBodySelectorMember1(new WaitBody_selectorMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWaitBodySelectorMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWaitBodySelectorMember1());
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
     * Gets the WaitBody_selectorMember1 property value. Composed type representation for type WaitBody_selectorMember1
     * @return WaitBody_selectorMember1|null
    */
    public function getWaitBodySelectorMember1(): ?WaitBody_selectorMember1 {
        return $this->waitBody_selectorMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getWaitBodySelectorMember1());
        }
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

    /**
     * Sets the WaitBody_selectorMember1 property value. Composed type representation for type WaitBody_selectorMember1
     * @param WaitBody_selectorMember1|null $value Value to set for the WaitBody_selectorMember1 property.
    */
    public function setWaitBodySelectorMember1(?WaitBody_selectorMember1 $value): void {
        $this->waitBody_selectorMember1 = $value;
    }

}
