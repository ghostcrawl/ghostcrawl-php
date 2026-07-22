<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class TeamResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $created_at The created_at property
    */
    private ?string $created_at = null;
    
    /**
     * @var string|null $name The name property
    */
    private ?string $name = null;
    
    /**
     * @var string|null $team_id The team_id property
    */
    private ?string $team_id = null;
    
    /**
     * @var string|null $tier The tier property
    */
    private ?string $tier = null;
    
    /**
     * Instantiates a new TeamResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return TeamResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TeamResponse {
        return new TeamResponse();
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
     * @return string|null
    */
    public function getCreatedAt(): ?string {
        return $this->created_at;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'created_at' => fn(ParseNode $n) => $o->setCreatedAt($n->getStringValue()),
            'name' => fn(ParseNode $n) => $o->setName($n->getStringValue()),
            'team_id' => fn(ParseNode $n) => $o->setTeamId($n->getStringValue()),
            'tier' => fn(ParseNode $n) => $o->setTier($n->getStringValue()),
        ];
    }

    /**
     * Gets the name property value. The name property
     * @return string|null
    */
    public function getName(): ?string {
        return $this->name;
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
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('created_at', $this->getCreatedAt());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeStringValue('team_id', $this->getTeamId());
        $writer->writeStringValue('tier', $this->getTier());
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
     * @param string|null $value Value to set for the created_at property.
    */
    public function setCreatedAt(?string $value): void {
        $this->created_at = $value;
    }

    /**
     * Sets the name property value. The name property
     * @param string|null $value Value to set for the name property.
    */
    public function setName(?string $value): void {
        $this->name = $value;
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

}
