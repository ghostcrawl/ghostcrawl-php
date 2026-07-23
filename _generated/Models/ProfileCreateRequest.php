<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/profiles body, create a named persistent profile.
*/
class ProfileCreateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $name Profile name. Unique per org (409 on conflict).
    */
    private ?string $name = null;
    
    /**
     * @var ProfileCreateRequest_storage_state_id|null $storage_state_id Optional storage_state id to bind (cookies/localStorage).
    */
    private ?ProfileCreateRequest_storage_state_id $storage_state_id = null;
    
    /**
     * Instantiates a new ProfileCreateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ProfileCreateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ProfileCreateRequest {
        return new ProfileCreateRequest();
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
            'name' => fn(ParseNode $n) => $o->setName($n->getStringValue()),
            'storage_state_id' => fn(ParseNode $n) => $o->setStorageStateId($n->getObjectValue([ProfileCreateRequest_storage_state_id::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the name property value. Profile name. Unique per org (409 on conflict).
     * @return string|null
    */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Gets the storage_state_id property value. Optional storage_state id to bind (cookies/localStorage).
     * @return ProfileCreateRequest_storage_state_id|null
    */
    public function getStorageStateId(): ?ProfileCreateRequest_storage_state_id {
        return $this->storage_state_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('name', $this->getName());
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
     * Sets the name property value. Profile name. Unique per org (409 on conflict).
     * @param string|null $value Value to set for the name property.
    */
    public function setName(?string $value): void {
        $this->name = $value;
    }

    /**
     * Sets the storage_state_id property value. Optional storage_state id to bind (cookies/localStorage).
     * @param ProfileCreateRequest_storage_state_id|null $value Value to set for the storage_state_id property.
    */
    public function setStorageStateId(?ProfileCreateRequest_storage_state_id $value): void {
        $this->storage_state_id = $value;
    }

}
