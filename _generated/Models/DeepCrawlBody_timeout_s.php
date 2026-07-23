<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes DeepCrawlBody_timeout_sMember1, int
*/
class DeepCrawlBody_timeout_s implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var DeepCrawlBody_timeout_sMember1|null $deepCrawlBody_timeout_sMember1 Composed type representation for type DeepCrawlBody_timeout_sMember1
    */
    private ?DeepCrawlBody_timeout_sMember1 $deepCrawlBody_timeout_sMember1 = null;
    
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return DeepCrawlBody_timeout_s
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): DeepCrawlBody_timeout_s {
        $result = new DeepCrawlBody_timeout_s();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setDeepCrawlBodyTimeoutSMember1(new DeepCrawlBody_timeout_sMember1());
        }
        return $result;
    }

    /**
     * Gets the DeepCrawlBody_timeout_sMember1 property value. Composed type representation for type DeepCrawlBody_timeout_sMember1
     * @return DeepCrawlBody_timeout_sMember1|null
    */
    public function getDeepCrawlBodyTimeoutSMember1(): ?DeepCrawlBody_timeout_sMember1 {
        return $this->deepCrawlBody_timeout_sMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getDeepCrawlBodyTimeoutSMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getDeepCrawlBodyTimeoutSMember1());
        }
        return [];
    }

    /**
     * Gets the integer property value. Composed type representation for type int
     * @return int|null
    */
    public function getInteger(): ?int {
        return $this->integer;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getDeepCrawlBodyTimeoutSMember1());
        }
    }

    /**
     * Sets the DeepCrawlBody_timeout_sMember1 property value. Composed type representation for type DeepCrawlBody_timeout_sMember1
     * @param DeepCrawlBody_timeout_sMember1|null $value Value to set for the DeepCrawlBody_timeout_sMember1 property.
    */
    public function setDeepCrawlBodyTimeoutSMember1(?DeepCrawlBody_timeout_sMember1 $value): void {
        $this->deepCrawlBody_timeout_sMember1 = $value;
    }

    /**
     * Sets the integer property value. Composed type representation for type int
     * @param int|null $value Value to set for the integer property.
    */
    public function setInteger(?int $value): void {
        $this->integer = $value;
    }

}
