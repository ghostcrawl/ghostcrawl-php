<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, PolicyUpsertRequest_max_llm_tokensMember1
*/
class PolicyUpsertRequest_max_llm_tokens implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var PolicyUpsertRequest_max_llm_tokensMember1|null $policyUpsertRequest_max_llm_tokensMember1 Composed type representation for type PolicyUpsertRequest_max_llm_tokensMember1
    */
    private ?PolicyUpsertRequest_max_llm_tokensMember1 $policyUpsertRequest_max_llm_tokensMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PolicyUpsertRequest_max_llm_tokens
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PolicyUpsertRequest_max_llm_tokens {
        $result = new PolicyUpsertRequest_max_llm_tokens();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setPolicyUpsertRequestMaxLlmTokensMember1(new PolicyUpsertRequest_max_llm_tokensMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getPolicyUpsertRequestMaxLlmTokensMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getPolicyUpsertRequestMaxLlmTokensMember1());
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
     * Gets the PolicyUpsertRequest_max_llm_tokensMember1 property value. Composed type representation for type PolicyUpsertRequest_max_llm_tokensMember1
     * @return PolicyUpsertRequest_max_llm_tokensMember1|null
    */
    public function getPolicyUpsertRequestMaxLlmTokensMember1(): ?PolicyUpsertRequest_max_llm_tokensMember1 {
        return $this->policyUpsertRequest_max_llm_tokensMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getPolicyUpsertRequestMaxLlmTokensMember1());
        }
    }

    /**
     * Sets the integer property value. Composed type representation for type int
     * @param int|null $value Value to set for the integer property.
    */
    public function setInteger(?int $value): void {
        $this->integer = $value;
    }

    /**
     * Sets the PolicyUpsertRequest_max_llm_tokensMember1 property value. Composed type representation for type PolicyUpsertRequest_max_llm_tokensMember1
     * @param PolicyUpsertRequest_max_llm_tokensMember1|null $value Value to set for the PolicyUpsertRequest_max_llm_tokensMember1 property.
    */
    public function setPolicyUpsertRequestMaxLlmTokensMember1(?PolicyUpsertRequest_max_llm_tokensMember1 $value): void {
        $this->policyUpsertRequest_max_llm_tokensMember1 = $value;
    }

}
