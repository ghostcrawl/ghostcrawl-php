<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class AgentRequest_task_steps implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $instruction Required for observe/act.
    */
    private ?string $instruction = null;
    
    /**
     * @var AgentRequest_task_steps_schema|null $schema Required for extract.
    */
    private ?AgentRequest_task_steps_schema $schema = null;
    
    /**
     * @var AgentRequest_task_steps_type|null $type The type property
    */
    private ?AgentRequest_task_steps_type $type = null;
    
    /**
     * Instantiates a new AgentRequest_task_steps and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AgentRequest_task_steps
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AgentRequest_task_steps {
        return new AgentRequest_task_steps();
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
            'instruction' => fn(ParseNode $n) => $o->setInstruction($n->getStringValue()),
            'schema' => fn(ParseNode $n) => $o->setSchema($n->getObjectValue([AgentRequest_task_steps_schema::class, 'createFromDiscriminatorValue'])),
            'type' => fn(ParseNode $n) => $o->setType($n->getEnumValue(AgentRequest_task_steps_type::class)),
        ];
    }

    /**
     * Gets the instruction property value. Required for observe/act.
     * @return string|null
    */
    public function getInstruction(): ?string {
        return $this->instruction;
    }

    /**
     * Gets the schema property value. Required for extract.
     * @return AgentRequest_task_steps_schema|null
    */
    public function getSchema(): ?AgentRequest_task_steps_schema {
        return $this->schema;
    }

    /**
     * Gets the type property value. The type property
     * @return AgentRequest_task_steps_type|null
    */
    public function getType(): ?AgentRequest_task_steps_type {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('instruction', $this->getInstruction());
        $writer->writeObjectValue('schema', $this->getSchema());
        $writer->writeEnumValue('type', $this->getType());
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
     * Sets the instruction property value. Required for observe/act.
     * @param string|null $value Value to set for the instruction property.
    */
    public function setInstruction(?string $value): void {
        $this->instruction = $value;
    }

    /**
     * Sets the schema property value. Required for extract.
     * @param AgentRequest_task_steps_schema|null $value Value to set for the schema property.
    */
    public function setSchema(?AgentRequest_task_steps_schema $value): void {
        $this->schema = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param AgentRequest_task_steps_type|null $value Value to set for the type property.
    */
    public function setType(?AgentRequest_task_steps_type $value): void {
        $this->type = $value;
    }

}
