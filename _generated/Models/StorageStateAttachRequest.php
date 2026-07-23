<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * sticky-attach to a profile.
*/
class StorageStateAttachRequest implements Parsable 
{
    /**
     * @var string|null $profile_id Profile to attach this storage state to (sticky per).
    */
    private ?string $profile_id = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return StorageStateAttachRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): StorageStateAttachRequest {
        return new StorageStateAttachRequest();
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getStringValue()),
        ];
    }

    /**
     * Gets the profile_id property value. Profile to attach this storage state to (sticky per).
     * @return string|null
    */
    public function getProfileId(): ?string {
        return $this->profile_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('profile_id', $this->getProfileId());
    }

    /**
     * Sets the profile_id property value. Profile to attach this storage state to (sticky per).
     * @param string|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?string $value): void {
        $this->profile_id = $value;
    }

}
