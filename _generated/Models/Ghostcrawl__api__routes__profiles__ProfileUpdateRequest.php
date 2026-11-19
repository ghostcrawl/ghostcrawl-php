<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * PUT /v1/profiles/{name} body, rename and/or rebind storage_state.
*/
class Ghostcrawl__api__routes__profiles__ProfileUpdateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name|null $name New name (rename). Unique per org.
    */
    private ?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name $name = null;
    
    /**
     * @var Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9|null $storage_state_id Rebind storage_state id. Pass null to keep; use empty string '' to clear.
    */
    private ?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9 $storage_state_id = null;
    
    /**
     * Instantiates a new Ghostcrawl__api__routes__profiles__ProfileUpdateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return Ghostcrawl__api__routes__profiles__ProfileUpdateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): Ghostcrawl__api__routes__profiles__ProfileUpdateRequest {
        return new Ghostcrawl__api__routes__profiles__ProfileUpdateRequest();
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
            'name' => fn(ParseNode $n) => $o->setName($n->getObjectValue([Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name::class, 'createFromDiscriminatorValue'])),
            'storage_state_id' => fn(ParseNode $n) => $o->setStorageStateId($n->getObjectValue([Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the name property value. New name (rename). Unique per org.
     * @return Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name|null
    */
    public function getName(): ?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name {
        return $this->name;
    }

    /**
     * Gets the storage_state_id property value. Rebind storage_state id. Pass null to keep; use empty string '' to clear.
     * @return Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9|null
    */
    public function getStorageStateId(): ?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9 {
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
     * @param Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name|null $value Value to set for the name property.
    */
    public function setName(?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_name $value): void {
        $this->name = $value;
    }

    /**
     * Sets the storage_state_id property value. Rebind storage_state id. Pass null to keep; use empty string '' to clear.
     * @param Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9|null $value Value to set for the storage_state_id property.
    */
    public function setStorageStateId(?Ghostcrawl__api__routes__profiles__ProfileUpdateRequest_960e45a9 $value): void {
        $this->storage_state_id = $value;
    }

}
