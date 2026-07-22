<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class MeResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var MeResponse_created_at|null $created_at The created_at property
    */
    private ?MeResponse_created_at $created_at = null;
    
    /**
     * @var string|null $email The email property
    */
    private ?string $email = null;
    
    /**
     * @var bool|null $email_verified The email_verified property
    */
    private ?bool $email_verified = null;
    
    /**
     * @var TeamResponse|null $primary_team The primary_team property
    */
    private ?TeamResponse $primary_team = null;
    
    /**
     * @var string|null $user_id The user_id property
    */
    private ?string $user_id = null;
    
    /**
     * Instantiates a new MeResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MeResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MeResponse {
        return new MeResponse();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the created_at property value. The created_at property
     * @return MeResponse_created_at|null
    */
    public function getCreatedAt(): ?MeResponse_created_at {
        return $this->created_at;
    }

    /**
     * Gets the email property value. The email property
     * @return string|null
    */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Gets the email_verified property value. The email_verified property
     * @return bool|null
    */
    public function getEmailVerified(): ?bool {
        return $this->email_verified;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'created_at' => fn(ParseNode $n) => $o->setCreatedAt($n->getObjectValue([MeResponse_created_at::class, 'createFromDiscriminatorValue'])),
            'email' => fn(ParseNode $n) => $o->setEmail($n->getStringValue()),
            'email_verified' => fn(ParseNode $n) => $o->setEmailVerified($n->getBooleanValue()),
            'primary_team' => fn(ParseNode $n) => $o->setPrimaryTeam($n->getObjectValue([TeamResponse::class, 'createFromDiscriminatorValue'])),
            'user_id' => fn(ParseNode $n) => $o->setUserId($n->getStringValue()),
        ];
    }

    /**
     * Gets the primary_team property value. The primary_team property
     * @return TeamResponse|null
    */
    public function getPrimaryTeam(): ?TeamResponse {
        return $this->primary_team;
    }

    /**
     * Gets the user_id property value. The user_id property
     * @return string|null
    */
    public function getUserId(): ?string {
        return $this->user_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('created_at', $this->getCreatedAt());
        $writer->writeStringValue('email', $this->getEmail());
        $writer->writeBooleanValue('email_verified', $this->getEmailVerified());
        $writer->writeObjectValue('primary_team', $this->getPrimaryTeam());
        $writer->writeStringValue('user_id', $this->getUserId());
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
     * Sets the created_at property value. The created_at property
     * @param MeResponse_created_at|null $value Value to set for the created_at property.
    */
    public function setCreatedAt(?MeResponse_created_at $value): void {
        $this->created_at = $value;
    }

    /**
     * Sets the email property value. The email property
     * @param string|null $value Value to set for the email property.
    */
    public function setEmail(?string $value): void {
        $this->email = $value;
    }

    /**
     * Sets the email_verified property value. The email_verified property
     * @param bool|null $value Value to set for the email_verified property.
    */
    public function setEmailVerified(?bool $value): void {
        $this->email_verified = $value;
    }

    /**
     * Sets the primary_team property value. The primary_team property
     * @param TeamResponse|null $value Value to set for the primary_team property.
    */
    public function setPrimaryTeam(?TeamResponse $value): void {
        $this->primary_team = $value;
    }

    /**
     * Sets the user_id property value. The user_id property
     * @param string|null $value Value to set for the user_id property.
    */
    public function setUserId(?string $value): void {
        $this->user_id = $value;
    }

}
