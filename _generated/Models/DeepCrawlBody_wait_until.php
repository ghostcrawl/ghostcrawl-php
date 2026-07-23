<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes DeepCrawlBody_wait_untilMember1, string
*/
class DeepCrawlBody_wait_until implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var DeepCrawlBody_wait_untilMember1|null $deepCrawlBody_wait_untilMember1 Composed type representation for type DeepCrawlBody_wait_untilMember1
    */
    private ?DeepCrawlBody_wait_untilMember1 $deepCrawlBody_wait_untilMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return DeepCrawlBody_wait_until
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): DeepCrawlBody_wait_until {
        $result = new DeepCrawlBody_wait_until();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setDeepCrawlBodyWaitUntilMember1(new DeepCrawlBody_wait_untilMember1());
        }
        return $result;
    }

    /**
     * Gets the DeepCrawlBody_wait_untilMember1 property value. Composed type representation for type DeepCrawlBody_wait_untilMember1
     * @return DeepCrawlBody_wait_untilMember1|null
    */
    public function getDeepCrawlBodyWaitUntilMember1(): ?DeepCrawlBody_wait_untilMember1 {
        return $this->deepCrawlBody_wait_untilMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getDeepCrawlBodyWaitUntilMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getDeepCrawlBodyWaitUntilMember1());
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
            $writer->writeObjectValue(null, $this->getDeepCrawlBodyWaitUntilMember1());
        }
    }

    /**
     * Sets the DeepCrawlBody_wait_untilMember1 property value. Composed type representation for type DeepCrawlBody_wait_untilMember1
     * @param DeepCrawlBody_wait_untilMember1|null $value Value to set for the DeepCrawlBody_wait_untilMember1 property.
    */
    public function setDeepCrawlBodyWaitUntilMember1(?DeepCrawlBody_wait_untilMember1 $value): void {
        $this->deepCrawlBody_wait_untilMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
