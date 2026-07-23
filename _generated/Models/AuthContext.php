<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class AuthContext implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var bool|null $comp The comp property
    */
    private ?bool $comp = null;
    
    /**
     * @var bool|null $is_admin The is_admin property
    */
    private ?bool $is_admin = null;
    
    /**
     * @var string|null $key_env The key_env property
    */
    private ?string $key_env = null;
    
    /**
     * @var string|null $team_id The team_id property
    */
    private ?string $team_id = null;
    
    /**
     * @var string|null $tier The tier property
    */
    private ?string $tier = null;
    
    /**
     * @var string|null $user_id The user_id property
    */
    private ?string $user_id = null;
    
    /**
     * @var string|null $workspace_id The workspace_id property
    */
    private ?string $workspace_id = null;
    
    /**
     * Instantiates a new AuthContext and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setComp(false);
        $this->setTier('free');
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AuthContext
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AuthContext {
        return new AuthContext();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the comp property value. The comp property
     * @return bool|null
    */
    public function getComp(): ?bool {
        return $this->comp;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'comp' => fn(ParseNode $n) => $o->setComp($n->getBooleanValue()),
            'is_admin' => fn(ParseNode $n) => $o->setIsAdmin($n->getBooleanValue()),
            'key_env' => fn(ParseNode $n) => $o->setKeyEnv($n->getStringValue()),
            'team_id' => fn(ParseNode $n) => $o->setTeamId($n->getStringValue()),
            'tier' => fn(ParseNode $n) => $o->setTier($n->getStringValue()),
            'user_id' => fn(ParseNode $n) => $o->setUserId($n->getStringValue()),
            'workspace_id' => fn(ParseNode $n) => $o->setWorkspaceId($n->getStringValue()),
        ];
    }

    /**
     * Gets the is_admin property value. The is_admin property
     * @return bool|null
    */
    public function getIsAdmin(): ?bool {
        return $this->is_admin;
    }

    /**
     * Gets the key_env property value. The key_env property
     * @return string|null
    */
    public function getKeyEnv(): ?string {
        return $this->key_env;
    }

    /**
     * Gets the team_id property value. The team_id property
     * @return string|null
    */
    public function getTeamId(): ?string {
        return $this->team_id;
    }

    /**
     * Gets the tier property value. The tier property
     * @return string|null
    */
    public function getTier(): ?string {
        return $this->tier;
    }

    /**
     * Gets the user_id property value. The user_id property
     * @return string|null
    */
    public function getUserId(): ?string {
        return $this->user_id;
    }

    /**
     * Gets the workspace_id property value. The workspace_id property
     * @return string|null
    */
    public function getWorkspaceId(): ?string {
        return $this->workspace_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeBooleanValue('comp', $this->getComp());
        $writer->writeBooleanValue('is_admin', $this->getIsAdmin());
        $writer->writeStringValue('key_env', $this->getKeyEnv());
        $writer->writeStringValue('team_id', $this->getTeamId());
        $writer->writeStringValue('tier', $this->getTier());
        $writer->writeStringValue('user_id', $this->getUserId());
        $writer->writeStringValue('workspace_id', $this->getWorkspaceId());
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
     * Sets the comp property value. The comp property
     * @param bool|null $value Value to set for the comp property.
    */
    public function setComp(?bool $value): void {
        $this->comp = $value;
    }

    /**
     * Sets the is_admin property value. The is_admin property
     * @param bool|null $value Value to set for the is_admin property.
    */
    public function setIsAdmin(?bool $value): void {
        $this->is_admin = $value;
    }

    /**
     * Sets the key_env property value. The key_env property
     * @param string|null $value Value to set for the key_env property.
    */
    public function setKeyEnv(?string $value): void {
        $this->key_env = $value;
    }

    /**
     * Sets the team_id property value. The team_id property
     * @param string|null $value Value to set for the team_id property.
    */
    public function setTeamId(?string $value): void {
        $this->team_id = $value;
    }

    /**
     * Sets the tier property value. The tier property
     * @param string|null $value Value to set for the tier property.
    */
    public function setTier(?string $value): void {
        $this->tier = $value;
    }

    /**
     * Sets the user_id property value. The user_id property
     * @param string|null $value Value to set for the user_id property.
    */
    public function setUserId(?string $value): void {
        $this->user_id = $value;
    }

    /**
     * Sets the workspace_id property value. The workspace_id property
     * @param string|null $value Value to set for the workspace_id property.
    */
    public function setWorkspaceId(?string $value): void {
        $this->workspace_id = $value;
    }

}
