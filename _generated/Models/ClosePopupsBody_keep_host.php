<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ClosePopupsBody_keep_hostMember1, string
*/
class ClosePopupsBody_keep_host implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ClosePopupsBody_keep_hostMember1|null $closePopupsBody_keep_hostMember1 Composed type representation for type ClosePopupsBody_keep_hostMember1
    */
    private ?ClosePopupsBody_keep_hostMember1 $closePopupsBody_keep_hostMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ClosePopupsBody_keep_host
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ClosePopupsBody_keep_host {
        $result = new ClosePopupsBody_keep_host();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setClosePopupsBodyKeepHostMember1(new ClosePopupsBody_keep_hostMember1());
        }
        return $result;
    }

    /**
     * Gets the ClosePopupsBody_keep_hostMember1 property value. Composed type representation for type ClosePopupsBody_keep_hostMember1
     * @return ClosePopupsBody_keep_hostMember1|null
    */
    public function getClosePopupsBodyKeepHostMember1(): ?ClosePopupsBody_keep_hostMember1 {
        return $this->closePopupsBody_keep_hostMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getClosePopupsBodyKeepHostMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getClosePopupsBodyKeepHostMember1());
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
            $writer->writeObjectValue(null, $this->getClosePopupsBodyKeepHostMember1());
        }
    }

    /**
     * Sets the ClosePopupsBody_keep_hostMember1 property value. Composed type representation for type ClosePopupsBody_keep_hostMember1
     * @param ClosePopupsBody_keep_hostMember1|null $value Value to set for the ClosePopupsBody_keep_hostMember1 property.
    */
    public function setClosePopupsBodyKeepHostMember1(?ClosePopupsBody_keep_hostMember1 $value): void {
        $this->closePopupsBody_keep_hostMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
