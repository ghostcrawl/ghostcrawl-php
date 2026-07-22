<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Public audit event shape, chain hashes excluded.
*/
class AuditEventOut implements AdditionalDataHolder, Parsable 
{
    /**
     * @var string|null $action The action property
    */
    private ?string $action = null;
    
    /**
     * @var AuditEventOut_actor_ip|null $actor_ip The actor_ip property
    */
    private ?AuditEventOut_actor_ip $actor_ip = null;
    
    /**
     * @var AuditEventOut_actor_token_id|null $actor_token_id The actor_token_id property
    */
    private ?AuditEventOut_actor_token_id $actor_token_id = null;
    
    /**
     * @var AuditEventOut_actor_user_agent|null $actor_user_agent The actor_user_agent property
    */
    private ?AuditEventOut_actor_user_agent $actor_user_agent = null;
    
    /**
     * @var AuditEventOut_actor_user_id|null $actor_user_id The actor_user_id property
    */
    private ?AuditEventOut_actor_user_id $actor_user_id = null;
    
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var DateTime|null $created_at The created_at property
    */
    private ?DateTime $created_at = null;
    
    /**
     * @var string|null $id The id property
    */
    private ?string $id = null;
    
    /**
     * @var AuditEventOut_metadata|null $metadata The metadata property
    */
    private ?AuditEventOut_metadata $metadata = null;
    
    /**
     * @var AuditEventOut_org_id|null $org_id The org_id property
    */
    private ?AuditEventOut_org_id $org_id = null;
    
    /**
     * @var string|null $outcome The outcome property
    */
    private ?string $outcome = null;
    
    /**
     * @var AuditEventOut_target_id|null $target_id The target_id property
    */
    private ?AuditEventOut_target_id $target_id = null;
    
    /**
     * @var AuditEventOut_target_kind|null $target_kind The target_kind property
    */
    private ?AuditEventOut_target_kind $target_kind = null;
    
    /**
     * Instantiates a new AuditEventOut and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AuditEventOut
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AuditEventOut {
        return new AuditEventOut();
    }

    /**
     * Gets the action property value. The action property
     * @return string|null
    */
    public function getAction(): ?string {
        return $this->action;
    }

    /**
     * Gets the actor_ip property value. The actor_ip property
     * @return AuditEventOut_actor_ip|null
    */
    public function getActorIp(): ?AuditEventOut_actor_ip {
        return $this->actor_ip;
    }

    /**
     * Gets the actor_token_id property value. The actor_token_id property
     * @return AuditEventOut_actor_token_id|null
    */
    public function getActorTokenId(): ?AuditEventOut_actor_token_id {
        return $this->actor_token_id;
    }

    /**
     * Gets the actor_user_agent property value. The actor_user_agent property
     * @return AuditEventOut_actor_user_agent|null
    */
    public function getActorUserAgent(): ?AuditEventOut_actor_user_agent {
        return $this->actor_user_agent;
    }

    /**
     * Gets the actor_user_id property value. The actor_user_id property
     * @return AuditEventOut_actor_user_id|null
    */
    public function getActorUserId(): ?AuditEventOut_actor_user_id {
        return $this->actor_user_id;
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the created_at property value. The created_at property
     * @return DateTime|null
    */
    public function getCreatedAt(): ?DateTime {
        return $this->created_at;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'action' => fn(ParseNode $n) => $o->setAction($n->getStringValue()),
            'actor_ip' => fn(ParseNode $n) => $o->setActorIp($n->getObjectValue([AuditEventOut_actor_ip::class, 'createFromDiscriminatorValue'])),
            'actor_token_id' => fn(ParseNode $n) => $o->setActorTokenId($n->getObjectValue([AuditEventOut_actor_token_id::class, 'createFromDiscriminatorValue'])),
            'actor_user_agent' => fn(ParseNode $n) => $o->setActorUserAgent($n->getObjectValue([AuditEventOut_actor_user_agent::class, 'createFromDiscriminatorValue'])),
            'actor_user_id' => fn(ParseNode $n) => $o->setActorUserId($n->getObjectValue([AuditEventOut_actor_user_id::class, 'createFromDiscriminatorValue'])),
            'created_at' => fn(ParseNode $n) => $o->setCreatedAt($n->getDateTimeValue()),
            'id' => fn(ParseNode $n) => $o->setId($n->getStringValue()),
            'metadata' => fn(ParseNode $n) => $o->setMetadata($n->getObjectValue([AuditEventOut_metadata::class, 'createFromDiscriminatorValue'])),
            'org_id' => fn(ParseNode $n) => $o->setOrgId($n->getObjectValue([AuditEventOut_org_id::class, 'createFromDiscriminatorValue'])),
            'outcome' => fn(ParseNode $n) => $o->setOutcome($n->getStringValue()),
            'target_id' => fn(ParseNode $n) => $o->setTargetId($n->getObjectValue([AuditEventOut_target_id::class, 'createFromDiscriminatorValue'])),
            'target_kind' => fn(ParseNode $n) => $o->setTargetKind($n->getObjectValue([AuditEventOut_target_kind::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the id property value. The id property
     * @return string|null
    */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Gets the metadata property value. The metadata property
     * @return AuditEventOut_metadata|null
    */
    public function getMetadata(): ?AuditEventOut_metadata {
        return $this->metadata;
    }

    /**
     * Gets the org_id property value. The org_id property
     * @return AuditEventOut_org_id|null
    */
    public function getOrgId(): ?AuditEventOut_org_id {
        return $this->org_id;
    }

    /**
     * Gets the outcome property value. The outcome property
     * @return string|null
    */
    public function getOutcome(): ?string {
        return $this->outcome;
    }

    /**
     * Gets the target_id property value. The target_id property
     * @return AuditEventOut_target_id|null
    */
    public function getTargetId(): ?AuditEventOut_target_id {
        return $this->target_id;
    }

    /**
     * Gets the target_kind property value. The target_kind property
     * @return AuditEventOut_target_kind|null
    */
    public function getTargetKind(): ?AuditEventOut_target_kind {
        return $this->target_kind;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('action', $this->getAction());
        $writer->writeObjectValue('actor_ip', $this->getActorIp());
        $writer->writeObjectValue('actor_token_id', $this->getActorTokenId());
        $writer->writeObjectValue('actor_user_agent', $this->getActorUserAgent());
        $writer->writeObjectValue('actor_user_id', $this->getActorUserId());
        $writer->writeDateTimeValue('created_at', $this->getCreatedAt());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeObjectValue('metadata', $this->getMetadata());
        $writer->writeObjectValue('org_id', $this->getOrgId());
        $writer->writeStringValue('outcome', $this->getOutcome());
        $writer->writeObjectValue('target_id', $this->getTargetId());
        $writer->writeObjectValue('target_kind', $this->getTargetKind());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the action property value. The action property
     * @param string|null $value Value to set for the action property.
    */
    public function setAction(?string $value): void {
        $this->action = $value;
    }

    /**
     * Sets the actor_ip property value. The actor_ip property
     * @param AuditEventOut_actor_ip|null $value Value to set for the actor_ip property.
    */
    public function setActorIp(?AuditEventOut_actor_ip $value): void {
        $this->actor_ip = $value;
    }

    /**
     * Sets the actor_token_id property value. The actor_token_id property
     * @param AuditEventOut_actor_token_id|null $value Value to set for the actor_token_id property.
    */
    public function setActorTokenId(?AuditEventOut_actor_token_id $value): void {
        $this->actor_token_id = $value;
    }

    /**
     * Sets the actor_user_agent property value. The actor_user_agent property
     * @param AuditEventOut_actor_user_agent|null $value Value to set for the actor_user_agent property.
    */
    public function setActorUserAgent(?AuditEventOut_actor_user_agent $value): void {
        $this->actor_user_agent = $value;
    }

    /**
     * Sets the actor_user_id property value. The actor_user_id property
     * @param AuditEventOut_actor_user_id|null $value Value to set for the actor_user_id property.
    */
    public function setActorUserId(?AuditEventOut_actor_user_id $value): void {
        $this->actor_user_id = $value;
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the created_at property value. The created_at property
     * @param DateTime|null $value Value to set for the created_at property.
    */
    public function setCreatedAt(?DateTime $value): void {
        $this->created_at = $value;
    }

    /**
     * Sets the id property value. The id property
     * @param string|null $value Value to set for the id property.
    */
    public function setId(?string $value): void {
        $this->id = $value;
    }

    /**
     * Sets the metadata property value. The metadata property
     * @param AuditEventOut_metadata|null $value Value to set for the metadata property.
    */
    public function setMetadata(?AuditEventOut_metadata $value): void {
        $this->metadata = $value;
    }

    /**
     * Sets the org_id property value. The org_id property
     * @param AuditEventOut_org_id|null $value Value to set for the org_id property.
    */
    public function setOrgId(?AuditEventOut_org_id $value): void {
        $this->org_id = $value;
    }

    /**
     * Sets the outcome property value. The outcome property
     * @param string|null $value Value to set for the outcome property.
    */
    public function setOutcome(?string $value): void {
        $this->outcome = $value;
    }

    /**
     * Sets the target_id property value. The target_id property
     * @param AuditEventOut_target_id|null $value Value to set for the target_id property.
    */
    public function setTargetId(?AuditEventOut_target_id $value): void {
        $this->target_id = $value;
    }

    /**
     * Sets the target_kind property value. The target_kind property
     * @param AuditEventOut_target_kind|null $value Value to set for the target_kind property.
    */
    public function setTargetKind(?AuditEventOut_target_kind $value): void {
        $this->target_kind = $value;
    }

}
