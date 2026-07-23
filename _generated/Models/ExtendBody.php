<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Body for POST /v1/sessions/{id}/extend.
*/
class ExtendBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ExtendBody_ttl_seconds|null $ttl_seconds New TTL in seconds (30s. 24h). Omit for the store default.
    */
    private ?ExtendBody_ttl_seconds $ttl_seconds = null;
    
    /**
     * Instantiates a new ExtendBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtendBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtendBody {
        return new ExtendBody();
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
            'ttl_seconds' => fn(ParseNode $n) => $o->setTtlSeconds($n->getObjectValue([ExtendBody_ttl_seconds::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the ttl_seconds property value. New TTL in seconds (30s. 24h). Omit for the store default.
     * @return ExtendBody_ttl_seconds|null
    */
    public function getTtlSeconds(): ?ExtendBody_ttl_seconds {
        return $this->ttl_seconds;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('ttl_seconds', $this->getTtlSeconds());
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
     * Sets the ttl_seconds property value. New TTL in seconds (30s. 24h). Omit for the store default.
     * @param ExtendBody_ttl_seconds|null $value Value to set for the ttl_seconds property.
    */
    public function setTtlSeconds(?ExtendBody_ttl_seconds $value): void {
        $this->ttl_seconds = $value;
    }

}
