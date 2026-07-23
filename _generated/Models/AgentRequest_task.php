<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Agent task payload; URL fields are policy-validated when present.
*/
class AgentRequest_task implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $goal The goal property
    */
    private ?string $goal = null;
    
    /**
     * @var string|null $start_url The start_url property
    */
    private ?string $start_url = null;
    
    /**
     * @var array<AgentRequest_task_steps>|null $steps Typed agent-step baseline contract (observe/act/extract).
    */
    private ?array $steps = null;
    
    /**
     * @var string|null $target_url The target_url property
    */
    private ?string $target_url = null;
    
    /**
     * @var string|null $url The url property
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new AgentRequest_task and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AgentRequest_task
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AgentRequest_task {
        return new AgentRequest_task();
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
            'goal' => fn(ParseNode $n) => $o->setGoal($n->getStringValue()),
            'start_url' => fn(ParseNode $n) => $o->setStartUrl($n->getStringValue()),
            'steps' => fn(ParseNode $n) => $o->setSteps($n->getCollectionOfObjectValues([AgentRequest_task_steps::class, 'createFromDiscriminatorValue'])),
            'target_url' => fn(ParseNode $n) => $o->setTargetUrl($n->getStringValue()),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the goal property value. The goal property
     * @return string|null
    */
    public function getGoal(): ?string {
        return $this->goal;
    }

    /**
     * Gets the start_url property value. The start_url property
     * @return string|null
    */
    public function getStartUrl(): ?string {
        return $this->start_url;
    }

    /**
     * Gets the steps property value. Typed agent-step baseline contract (observe/act/extract).
     * @return array<AgentRequest_task_steps>|null
    */
    public function getSteps(): ?array {
        return $this->steps;
    }

    /**
     * Gets the target_url property value. The target_url property
     * @return string|null
    */
    public function getTargetUrl(): ?string {
        return $this->target_url;
    }

    /**
     * Gets the url property value. The url property
     * @return string|null
    */
    public function getUrl(): ?string {
        return $this->url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('goal', $this->getGoal());
        $writer->writeStringValue('start_url', $this->getStartUrl());
        $writer->writeCollectionOfObjectValues('steps', $this->getSteps());
        $writer->writeStringValue('target_url', $this->getTargetUrl());
        $writer->writeStringValue('url', $this->getUrl());
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
     * Sets the goal property value. The goal property
     * @param string|null $value Value to set for the goal property.
    */
    public function setGoal(?string $value): void {
        $this->goal = $value;
    }

    /**
     * Sets the start_url property value. The start_url property
     * @param string|null $value Value to set for the start_url property.
    */
    public function setStartUrl(?string $value): void {
        $this->start_url = $value;
    }

    /**
     * Sets the steps property value. Typed agent-step baseline contract (observe/act/extract).
     * @param array<AgentRequest_task_steps>|null $value Value to set for the steps property.
    */
    public function setSteps(?array $value): void {
        $this->steps = $value;
    }

    /**
     * Sets the target_url property value. The target_url property
     * @param string|null $value Value to set for the target_url property.
    */
    public function setTargetUrl(?string $value): void {
        $this->target_url = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
