<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Encrypted identity payload returned to the caller.
*/
class IdentityPayload implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $alg The alg property
    */
    private ?string $alg = null;
    
    /**
     * @var string|null $ciphertext The ciphertext property
    */
    private ?string $ciphertext = null;
    
    /**
     * @var string|null $iv The iv property
    */
    private ?string $iv = null;
    
    /**
     * @var string|null $key_id The key_id property
    */
    private ?string $key_id = null;
    
    /**
     * Instantiates a new IdentityPayload and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityPayload
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityPayload {
        return new IdentityPayload();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the alg property value. The alg property
     * @return string|null
    */
    public function getAlg(): ?string {
        return $this->alg;
    }

    /**
     * Gets the ciphertext property value. The ciphertext property
     * @return string|null
    */
    public function getCiphertext(): ?string {
        return $this->ciphertext;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'alg' => fn(ParseNode $n) => $o->setAlg($n->getStringValue()),
            'ciphertext' => fn(ParseNode $n) => $o->setCiphertext($n->getStringValue()),
            'iv' => fn(ParseNode $n) => $o->setIv($n->getStringValue()),
            'key_id' => fn(ParseNode $n) => $o->setKeyId($n->getStringValue()),
        ];
    }

    /**
     * Gets the iv property value. The iv property
     * @return string|null
    */
    public function getIv(): ?string {
        return $this->iv;
    }

    /**
     * Gets the key_id property value. The key_id property
     * @return string|null
    */
    public function getKeyId(): ?string {
        return $this->key_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('alg', $this->getAlg());
        $writer->writeStringValue('ciphertext', $this->getCiphertext());
        $writer->writeStringValue('iv', $this->getIv());
        $writer->writeStringValue('key_id', $this->getKeyId());
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
     * Sets the alg property value. The alg property
     * @param string|null $value Value to set for the alg property.
    */
    public function setAlg(?string $value): void {
        $this->alg = $value;
    }

    /**
     * Sets the ciphertext property value. The ciphertext property
     * @param string|null $value Value to set for the ciphertext property.
    */
    public function setCiphertext(?string $value): void {
        $this->ciphertext = $value;
    }

    /**
     * Sets the iv property value. The iv property
     * @param string|null $value Value to set for the iv property.
    */
    public function setIv(?string $value): void {
        $this->iv = $value;
    }

    /**
     * Sets the key_id property value. The key_id property
     * @param string|null $value Value to set for the key_id property.
    */
    public function setKeyId(?string $value): void {
        $this->key_id = $value;
    }

}
