<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360, string Original name: ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_id
*/
class Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9 implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360|null $ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1 Composed type representation for type Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360
    */
    private ?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360 $ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9 {
        $result = new Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setGhostcrawlApiRoutesProfilesProfileUpdateRequestStorageStateIdMember1(new Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getGhostcrawlApiRoutesProfilesProfileUpdateRequestStorageStateIdMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getGhostcrawlApiRoutesProfilesProfileUpdateRequestStorageStateIdMember1());
        }
        return [];
    }

    /**
     * Gets the ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1 property value. Composed type representation for type Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360
     * @return Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360|null
    */
    public function getGhostcrawlApiRoutesProfilesProfileUpdateRequestStorageStateIdMember1(): ?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360 {
        return $this->ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1;
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
            $writer->writeObjectValue(null, $this->getGhostcrawlApiRoutesProfilesProfileUpdateRequestStorageStateIdMember1());
        }
    }

    /**
     * Sets the ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1 property value. Composed type representation for type Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360
     * @param Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360|null $value Value to set for the ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1 property.
    */
    public function setGhostcrawlApiRoutesProfilesProfileUpdateRequestStorageStateIdMember1(?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_4fb82360 $value): void {
        $this->ghostcrawl__api__routes__profiles__ProfileUpdateRequest_storage_state_idMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
