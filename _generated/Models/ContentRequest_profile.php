<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ContentRequest_profileMember1, string
*/
class ContentRequest_profile implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ContentRequest_profileMember1|null $contentRequest_profileMember1 Composed type representation for type ContentRequest_profileMember1
    */
    private ?ContentRequest_profileMember1 $contentRequest_profileMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ContentRequest_profile
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ContentRequest_profile {
        $result = new ContentRequest_profile();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setContentRequestProfileMember1(new ContentRequest_profileMember1());
        }
        return $result;
    }

    /**
     * Gets the ContentRequest_profileMember1 property value. Composed type representation for type ContentRequest_profileMember1
     * @return ContentRequest_profileMember1|null
    */
    public function getContentRequestProfileMember1(): ?ContentRequest_profileMember1 {
        return $this->contentRequest_profileMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getContentRequestProfileMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getContentRequestProfileMember1());
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
            $writer->writeObjectValue(null, $this->getContentRequestProfileMember1());
        }
    }

    /**
     * Sets the ContentRequest_profileMember1 property value. Composed type representation for type ContentRequest_profileMember1
     * @param ContentRequest_profileMember1|null $value Value to set for the ContentRequest_profileMember1 property.
    */
    public function setContentRequestProfileMember1(?ContentRequest_profileMember1 $value): void {
        $this->contentRequest_profileMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
