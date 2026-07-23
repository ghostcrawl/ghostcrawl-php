<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class AgentRequest implements Parsable 
{
    /**
     * @var string|null $api_key The api_key property
    */
    private ?string $api_key = null;
    
    /**
     * @var string|null $callback_url The callback_url property
    */
    private ?string $callback_url = null;
    
    /**
     * @var AgentRequest_mode|null $mode The mode property
    */
    private ?AgentRequest_mode $mode = null;
    
    /**
     * @var string|null $profile_id Optional stable profile identifier. When supplied on a successful sync `/v1/agent` call, the executed step trace is recorded into the in-process action cache (keyed by `(profile_id, task)`) and can be replayed via `POST /v1/agent/action-cache/replay`. Response payload includes `action_cache_recorded: true|false` so callers can confirm cache durability.
    */
    private ?string $profile_id = null;
    
    /**
     * @var ProxyConfig|null $proxy The proxy property
    */
    private ?ProxyConfig $proxy = null;
    
    /**
     * @var AgentRequest_task|null $task Agent task payload; URL fields are policy-validated when present.
    */
    private ?AgentRequest_task $task = null;
    
    /**
     * @var string|null $tenant_id The tenant_id property
    */
    private ?string $tenant_id = null;
    
    /**
     * @var string|null $workspace_id The workspace_id property
    */
    private ?string $workspace_id = null;
    
    /**
     * Instantiates a new AgentRequest and sets the default values.
    */
    public function __construct() {
        $this->setMode(new AgentRequest_mode('sync'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AgentRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AgentRequest {
        return new AgentRequest();
    }

    /**
     * Gets the api_key property value. The api_key property
     * @return string|null
    */
    public function getApiKey(): ?string {
        return $this->api_key;
    }

    /**
     * Gets the callback_url property value. The callback_url property
     * @return string|null
    */
    public function getCallbackUrl(): ?string {
        return $this->callback_url;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'api_key' => fn(ParseNode $n) => $o->setApiKey($n->getStringValue()),
            'callback_url' => fn(ParseNode $n) => $o->setCallbackUrl($n->getStringValue()),
            'mode' => fn(ParseNode $n) => $o->setMode($n->getEnumValue(AgentRequest_mode::class)),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getStringValue()),
            'proxy' => fn(ParseNode $n) => $o->setProxy($n->getObjectValue([ProxyConfig::class, 'createFromDiscriminatorValue'])),
            'task' => fn(ParseNode $n) => $o->setTask($n->getObjectValue([AgentRequest_task::class, 'createFromDiscriminatorValue'])),
            'tenant_id' => fn(ParseNode $n) => $o->setTenantId($n->getStringValue()),
            'workspace_id' => fn(ParseNode $n) => $o->setWorkspaceId($n->getStringValue()),
        ];
    }

    /**
     * Gets the mode property value. The mode property
     * @return AgentRequest_mode|null
    */
    public function getMode(): ?AgentRequest_mode {
        return $this->mode;
    }

    /**
     * Gets the profile_id property value. Optional stable profile identifier. When supplied on a successful sync `/v1/agent` call, the executed step trace is recorded into the in-process action cache (keyed by `(profile_id, task)`) and can be replayed via `POST /v1/agent/action-cache/replay`. Response payload includes `action_cache_recorded: true|false` so callers can confirm cache durability.
     * @return string|null
    */
    public function getProfileId(): ?string {
        return $this->profile_id;
    }

    /**
     * Gets the proxy property value. The proxy property
     * @return ProxyConfig|null
    */
    public function getProxy(): ?ProxyConfig {
        return $this->proxy;
    }

    /**
     * Gets the task property value. Agent task payload; URL fields are policy-validated when present.
     * @return AgentRequest_task|null
    */
    public function getTask(): ?AgentRequest_task {
        return $this->task;
    }

    /**
     * Gets the tenant_id property value. The tenant_id property
     * @return string|null
    */
    public function getTenantId(): ?string {
        return $this->tenant_id;
    }

    /**
     * Gets the workspace_id property value. The workspace_id property
     * @return string|null
    */
    public function getWorkspaceId(): ?string {
        return $this->workspace_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('api_key', $this->getApiKey());
        $writer->writeStringValue('callback_url', $this->getCallbackUrl());
        $writer->writeEnumValue('mode', $this->getMode());
        $writer->writeStringValue('profile_id', $this->getProfileId());
        $writer->writeObjectValue('proxy', $this->getProxy());
        $writer->writeObjectValue('task', $this->getTask());
        $writer->writeStringValue('tenant_id', $this->getTenantId());
        $writer->writeStringValue('workspace_id', $this->getWorkspaceId());
    }

    /**
     * Sets the api_key property value. The api_key property
     * @param string|null $value Value to set for the api_key property.
    */
    public function setApiKey(?string $value): void {
        $this->api_key = $value;
    }

    /**
     * Sets the callback_url property value. The callback_url property
     * @param string|null $value Value to set for the callback_url property.
    */
    public function setCallbackUrl(?string $value): void {
        $this->callback_url = $value;
    }

    /**
     * Sets the mode property value. The mode property
     * @param AgentRequest_mode|null $value Value to set for the mode property.
    */
    public function setMode(?AgentRequest_mode $value): void {
        $this->mode = $value;
    }

    /**
     * Sets the profile_id property value. Optional stable profile identifier. When supplied on a successful sync `/v1/agent` call, the executed step trace is recorded into the in-process action cache (keyed by `(profile_id, task)`) and can be replayed via `POST /v1/agent/action-cache/replay`. Response payload includes `action_cache_recorded: true|false` so callers can confirm cache durability.
     * @param string|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?string $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the proxy property value. The proxy property
     * @param ProxyConfig|null $value Value to set for the proxy property.
    */
    public function setProxy(?ProxyConfig $value): void {
        $this->proxy = $value;
    }

    /**
     * Sets the task property value. Agent task payload; URL fields are policy-validated when present.
     * @param AgentRequest_task|null $value Value to set for the task property.
    */
    public function setTask(?AgentRequest_task $value): void {
        $this->task = $value;
    }

    /**
     * Sets the tenant_id property value. The tenant_id property
     * @param string|null $value Value to set for the tenant_id property.
    */
    public function setTenantId(?string $value): void {
        $this->tenant_id = $value;
    }

    /**
     * Sets the workspace_id property value. The workspace_id property
     * @param string|null $value Value to set for the workspace_id property.
    */
    public function setWorkspaceId(?string $value): void {
        $this->workspace_id = $value;
    }

}
