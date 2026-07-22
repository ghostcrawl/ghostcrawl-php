<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class EvalBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $profile_id The profile_id property
    */
    private ?string $profile_id = null;
    
    /**
     * @var string|null $script The script property
    */
    private ?string $script = null;
    
    /**
     * Instantiates a new EvalBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return EvalBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): EvalBody {
        return new EvalBody();
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
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getStringValue()),
            'script' => fn(ParseNode $n) => $o->setScript($n->getStringValue()),
        ];
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return string|null
    */
    public function getProfileId(): ?string {
        return $this->profile_id;
    }

    /**
     * Gets the script property value. The script property
     * @return string|null
    */
    public function getScript(): ?string {
        return $this->script;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('profile_id', $this->getProfileId());
        $writer->writeStringValue('script', $this->getScript());
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
     * Sets the profile_id property value. The profile_id property
     * @param string|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?string $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the script property value. The script property
     * @param string|null $value Value to set for the script property.
    */
    public function setScript(?string $value): void {
        $this->script = $value;
    }

}
