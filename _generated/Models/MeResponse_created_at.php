<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes MeResponse_created_atMember1, string
*/
class MeResponse_created_at implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var MeResponse_created_atMember1|null $meResponse_created_atMember1 Composed type representation for type MeResponse_created_atMember1
    */
    private ?MeResponse_created_atMember1 $meResponse_created_atMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MeResponse_created_at
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MeResponse_created_at {
        $result = new MeResponse_created_at();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setMeResponseCreatedAtMember1(new MeResponse_created_atMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getMeResponseCreatedAtMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getMeResponseCreatedAtMember1());
        }
        return [];
    }

    /**
     * Gets the MeResponse_created_atMember1 property value. Composed type representation for type MeResponse_created_atMember1
     * @return MeResponse_created_atMember1|null
    */
    public function getMeResponseCreatedAtMember1(): ?MeResponse_created_atMember1 {
        return $this->meResponse_created_atMember1;
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
            $writer->writeObjectValue(null, $this->getMeResponseCreatedAtMember1());
        }
    }

    /**
     * Sets the MeResponse_created_atMember1 property value. Composed type representation for type MeResponse_created_atMember1
     * @param MeResponse_created_atMember1|null $value Value to set for the MeResponse_created_atMember1 property.
    */
    public function setMeResponseCreatedAtMember1(?MeResponse_created_atMember1 $value): void {
        $this->meResponse_created_atMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
