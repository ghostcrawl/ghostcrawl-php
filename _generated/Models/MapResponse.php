<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Response envelope for POST /v1/map.
*/
class MapResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var array<string>|null $links The links property
    */
    private ?array $links = null;
    
    /**
     * @var bool|null $success The success property
    */
    private ?bool $success = null;
    
    /**
     * @var MapResponse_truncated_to_server_max|null $truncated_to_server_max The truncated_to_server_max property
    */
    private ?MapResponse_truncated_to_server_max $truncated_to_server_max = null;
    
    /**
     * Instantiates a new MapResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MapResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MapResponse {
        return new MapResponse();
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
            'links' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setLinks($val);
            },
            'success' => fn(ParseNode $n) => $o->setSuccess($n->getBooleanValue()),
            'truncated_to_server_max' => fn(ParseNode $n) => $o->setTruncatedToServerMax($n->getObjectValue([MapResponse_truncated_to_server_max::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the links property value. The links property
     * @return array<string>|null
    */
    public function getLinks(): ?array {
        return $this->links;
    }

    /**
     * Gets the success property value. The success property
     * @return bool|null
    */
    public function getSuccess(): ?bool {
        return $this->success;
    }

    /**
     * Gets the truncated_to_server_max property value. The truncated_to_server_max property
     * @return MapResponse_truncated_to_server_max|null
    */
    public function getTruncatedToServerMax(): ?MapResponse_truncated_to_server_max {
        return $this->truncated_to_server_max;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfPrimitiveValues('links', $this->getLinks());
        $writer->writeBooleanValue('success', $this->getSuccess());
        $writer->writeObjectValue('truncated_to_server_max', $this->getTruncatedToServerMax());
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
     * Sets the links property value. The links property
     * @param array<string>|null $value Value to set for the links property.
    */
    public function setLinks(?array $value): void {
        $this->links = $value;
    }

    /**
     * Sets the success property value. The success property
     * @param bool|null $value Value to set for the success property.
    */
    public function setSuccess(?bool $value): void {
        $this->success = $value;
    }

    /**
     * Sets the truncated_to_server_max property value. The truncated_to_server_max property
     * @param MapResponse_truncated_to_server_max|null $value Value to set for the truncated_to_server_max property.
    */
    public function setTruncatedToServerMax(?MapResponse_truncated_to_server_max $value): void {
        $this->truncated_to_server_max = $value;
    }

}
