<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class SessionCreateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var SessionCreateRequest_engine|null $engine The engine property
    */
    private ?SessionCreateRequest_engine $engine = null;
    
    /**
     * @var SessionCreateRequest_profile|null $profile Rehydrates the saved identity bundle for this session, same deterministic fingerprint as /v1/scrape with profile=<name>.
    */
    private ?SessionCreateRequest_profile $profile = null;
    
    /**
     * Instantiates a new SessionCreateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setEngine(new SessionCreateRequest_engine('chrome'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SessionCreateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SessionCreateRequest {
        return new SessionCreateRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the engine property value. The engine property
     * @return SessionCreateRequest_engine|null
    */
    public function getEngine(): ?SessionCreateRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(SessionCreateRequest_engine::class)),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([SessionCreateRequest_profile::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the profile property value. Rehydrates the saved identity bundle for this session, same deterministic fingerprint as /v1/scrape with profile=<name>.
     * @return SessionCreateRequest_profile|null
    */
    public function getProfile(): ?SessionCreateRequest_profile {
        return $this->profile;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeEnumValue('engine', $this->getEngine());
        $writer->writeObjectValue('profile', $this->getProfile());
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
     * Sets the engine property value. The engine property
     * @param SessionCreateRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?SessionCreateRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the profile property value. Rehydrates the saved identity bundle for this session, same deterministic fingerprint as /v1/scrape with profile=<name>.
     * @param SessionCreateRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?SessionCreateRequest_profile $value): void {
        $this->profile = $value;
    }

}
