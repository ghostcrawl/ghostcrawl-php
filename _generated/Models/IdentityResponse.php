<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Response body for POST /v1/identity.
*/
class IdentityResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var IdentityResponse_expires_at|null $expires_at The expires_at property
    */
    private ?IdentityResponse_expires_at $expires_at = null;
    
    /**
     * @var IdentityResponse_identity_id|null $identity_id The identity_id property
    */
    private ?IdentityResponse_identity_id $identity_id = null;
    
    /**
     * @var IdentityPayload|null $payload Encrypted identity payload returned to the caller.
    */
    private ?IdentityPayload $payload = null;
    
    /**
     * @var IdentityResponse_workspace_id|null $workspace_id The workspace_id property
    */
    private ?IdentityResponse_workspace_id $workspace_id = null;
    
    /**
     * Instantiates a new IdentityResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityResponse {
        return new IdentityResponse();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the expires_at property value. The expires_at property
     * @return IdentityResponse_expires_at|null
    */
    public function getExpiresAt(): ?IdentityResponse_expires_at {
        return $this->expires_at;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'expires_at' => fn(ParseNode $n) => $o->setExpiresAt($n->getObjectValue([IdentityResponse_expires_at::class, 'createFromDiscriminatorValue'])),
            'identity_id' => fn(ParseNode $n) => $o->setIdentityId($n->getObjectValue([IdentityResponse_identity_id::class, 'createFromDiscriminatorValue'])),
            'payload' => fn(ParseNode $n) => $o->setPayload($n->getObjectValue([IdentityPayload::class, 'createFromDiscriminatorValue'])),
            'workspace_id' => fn(ParseNode $n) => $o->setWorkspaceId($n->getObjectValue([IdentityResponse_workspace_id::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the identity_id property value. The identity_id property
     * @return IdentityResponse_identity_id|null
    */
    public function getIdentityId(): ?IdentityResponse_identity_id {
        return $this->identity_id;
    }

    /**
     * Gets the payload property value. Encrypted identity payload returned to the caller.
     * @return IdentityPayload|null
    */
    public function getPayload(): ?IdentityPayload {
        return $this->payload;
    }

    /**
     * Gets the workspace_id property value. The workspace_id property
     * @return IdentityResponse_workspace_id|null
    */
    public function getWorkspaceId(): ?IdentityResponse_workspace_id {
        return $this->workspace_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('expires_at', $this->getExpiresAt());
        $writer->writeObjectValue('identity_id', $this->getIdentityId());
        $writer->writeObjectValue('payload', $this->getPayload());
        $writer->writeObjectValue('workspace_id', $this->getWorkspaceId());
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
     * Sets the expires_at property value. The expires_at property
     * @param IdentityResponse_expires_at|null $value Value to set for the expires_at property.
    */
    public function setExpiresAt(?IdentityResponse_expires_at $value): void {
        $this->expires_at = $value;
    }

    /**
     * Sets the identity_id property value. The identity_id property
     * @param IdentityResponse_identity_id|null $value Value to set for the identity_id property.
    */
    public function setIdentityId(?IdentityResponse_identity_id $value): void {
        $this->identity_id = $value;
    }

    /**
     * Sets the payload property value. Encrypted identity payload returned to the caller.
     * @param IdentityPayload|null $value Value to set for the payload property.
    */
    public function setPayload(?IdentityPayload $value): void {
        $this->payload = $value;
    }

    /**
     * Sets the workspace_id property value. The workspace_id property
     * @param IdentityResponse_workspace_id|null $value Value to set for the workspace_id property.
    */
    public function setWorkspaceId(?IdentityResponse_workspace_id $value): void {
        $this->workspace_id = $value;
    }

}
