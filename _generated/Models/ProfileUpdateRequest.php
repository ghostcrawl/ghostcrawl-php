<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * PUT /v1/profiles/{name} body, rename and/or rebind storage_state.
*/
class ProfileUpdateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ProfileUpdateRequest_name|null $name New name (rename). Unique per org.
    */
    private ?ProfileUpdateRequest_name $name = null;
    
    /**
     * @var ProfileUpdateRequest_storage_state_id|null $storage_state_id Rebind storage_state id. Pass null to keep; use empty string '' to clear.
    */
    private ?ProfileUpdateRequest_storage_state_id $storage_state_id = null;
    
    /**
     * Instantiates a new ProfileUpdateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ProfileUpdateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ProfileUpdateRequest {
        return new ProfileUpdateRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'name' => fn(ParseNode $n) => $o->setName($n->getObjectValue([ProfileUpdateRequest_name::class, 'createFromDiscriminatorValue'])),
            'storage_state_id' => fn(ParseNode $n) => $o->setStorageStateId($n->getObjectValue([ProfileUpdateRequest_storage_state_id::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the name property value. New name (rename). Unique per org.
     * @return ProfileUpdateRequest_name|null
    */
    public function getName(): ?ProfileUpdateRequest_name {
        return $this->name;
    }

    /**
     * Gets the storage_state_id property value. Rebind storage_state id. Pass null to keep; use empty string '' to clear.
     * @return ProfileUpdateRequest_storage_state_id|null
    */
    public function getStorageStateId(): ?ProfileUpdateRequest_storage_state_id {
        return $this->storage_state_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('name', $this->getName());
        $writer->writeObjectValue('storage_state_id', $this->getStorageStateId());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the name property value. New name (rename). Unique per org.
     * @param ProfileUpdateRequest_name|null $value Value to set for the name property.
    */
    public function setName(?ProfileUpdateRequest_name $value): void {
        $this->name = $value;
    }

    /**
     * Sets the storage_state_id property value. Rebind storage_state id. Pass null to keep; use empty string '' to clear.
     * @param ProfileUpdateRequest_storage_state_id|null $value Value to set for the storage_state_id property.
    */
    public function setStorageStateId(?ProfileUpdateRequest_storage_state_id $value): void {
        $this->storage_state_id = $value;
    }

}
