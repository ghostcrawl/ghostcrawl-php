<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class MouseBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var array<MouseBody_ops>|null $ops The ops property
    */
    private ?array $ops = null;
    
    /**
     * @var MouseBody_profile_id|null $profile_id The profile_id property
    */
    private ?MouseBody_profile_id $profile_id = null;
    
    /**
     * @var MouseBody_session_id|null $session_id The session_id property
    */
    private ?MouseBody_session_id $session_id = null;
    
    /**
     * Instantiates a new MouseBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MouseBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MouseBody {
        return new MouseBody();
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
            'ops' => fn(ParseNode $n) => $o->setOps($n->getCollectionOfObjectValues([MouseBody_ops::class, 'createFromDiscriminatorValue'])),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getObjectValue([MouseBody_profile_id::class, 'createFromDiscriminatorValue'])),
            'session_id' => fn(ParseNode $n) => $o->setSessionId($n->getObjectValue([MouseBody_session_id::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the ops property value. The ops property
     * @return array<MouseBody_ops>|null
    */
    public function getOps(): ?array {
        return $this->ops;
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return MouseBody_profile_id|null
    */
    public function getProfileId(): ?MouseBody_profile_id {
        return $this->profile_id;
    }

    /**
     * Gets the session_id property value. The session_id property
     * @return MouseBody_session_id|null
    */
    public function getSessionId(): ?MouseBody_session_id {
        return $this->session_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfObjectValues('ops', $this->getOps());
        $writer->writeObjectValue('profile_id', $this->getProfileId());
        $writer->writeObjectValue('session_id', $this->getSessionId());
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
     * Sets the ops property value. The ops property
     * @param array<MouseBody_ops>|null $value Value to set for the ops property.
    */
    public function setOps(?array $value): void {
        $this->ops = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param MouseBody_profile_id|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?MouseBody_profile_id $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the session_id property value. The session_id property
     * @param MouseBody_session_id|null $value Value to set for the session_id property.
    */
    public function setSessionId(?MouseBody_session_id $value): void {
        $this->session_id = $value;
    }

}
