<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

class ValidationError implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ValidationError_ctx|null $ctx The ctx property
    */
    private ?ValidationError_ctx $ctx = null;
    
    /**
     * @var array<string>|null $loc The loc property
    */
    private ?array $loc = null;
    
    /**
     * @var string|null $msg The msg property
    */
    private ?string $msg = null;
    
    /**
     * @var string|null $type The type property
    */
    private ?string $type = null;
    
    /**
     * Instantiates a new ValidationError and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ValidationError
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ValidationError {
        return new ValidationError();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the ctx property value. The ctx property
     * @return ValidationError_ctx|null
    */
    public function getCtx(): ?ValidationError_ctx {
        return $this->ctx;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'ctx' => fn(ParseNode $n) => $o->setCtx($n->getObjectValue([ValidationError_ctx::class, 'createFromDiscriminatorValue'])),
            'loc' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setLoc($val);
            },
            'msg' => fn(ParseNode $n) => $o->setMsg($n->getStringValue()),
            'type' => fn(ParseNode $n) => $o->setType($n->getStringValue()),
        ];
    }

    /**
     * Gets the loc property value. The loc property
     * @return array<string>|null
    */
    public function getLoc(): ?array {
        return $this->loc;
    }

    /**
     * Gets the msg property value. The msg property
     * @return string|null
    */
    public function getMsg(): ?string {
        return $this->msg;
    }

    /**
     * Gets the type property value. The type property
     * @return string|null
    */
    public function getType(): ?string {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('ctx', $this->getCtx());
        $writer->writeCollectionOfPrimitiveValues('loc', $this->getLoc());
        $writer->writeStringValue('msg', $this->getMsg());
        $writer->writeStringValue('type', $this->getType());
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
     * Sets the ctx property value. The ctx property
     * @param ValidationError_ctx|null $value Value to set for the ctx property.
    */
    public function setCtx(?ValidationError_ctx $value): void {
        $this->ctx = $value;
    }

    /**
     * Sets the loc property value. The loc property
     * @param array<string>|null $value Value to set for the loc property.
    */
    public function setLoc(?array $value): void {
        $this->loc = $value;
    }

    /**
     * Sets the msg property value. The msg property
     * @param string|null $value Value to set for the msg property.
    */
    public function setMsg(?string $value): void {
        $this->msg = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param string|null $value Value to set for the type property.
    */
    public function setType(?string $value): void {
        $this->type = $value;
    }

}
