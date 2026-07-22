<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScrollBody_selectorMember1, string
*/
class ScrollBody_selector implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScrollBody_selectorMember1|null $scrollBody_selectorMember1 Composed type representation for type ScrollBody_selectorMember1
    */
    private ?ScrollBody_selectorMember1 $scrollBody_selectorMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrollBody_selector
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrollBody_selector {
        $result = new ScrollBody_selector();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScrollBodySelectorMember1(new ScrollBody_selectorMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrollBodySelectorMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrollBodySelectorMember1());
        }
        return [];
    }

    /**
     * Gets the ScrollBody_selectorMember1 property value. Composed type representation for type ScrollBody_selectorMember1
     * @return ScrollBody_selectorMember1|null
    */
    public function getScrollBodySelectorMember1(): ?ScrollBody_selectorMember1 {
        return $this->scrollBody_selectorMember1;
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
            $writer->writeObjectValue(null, $this->getScrollBodySelectorMember1());
        }
    }

    /**
     * Sets the ScrollBody_selectorMember1 property value. Composed type representation for type ScrollBody_selectorMember1
     * @param ScrollBody_selectorMember1|null $value Value to set for the ScrollBody_selectorMember1 property.
    */
    public function setScrollBodySelectorMember1(?ScrollBody_selectorMember1 $value): void {
        $this->scrollBody_selectorMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
