<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Public webhook subscription details. The signing secret is never included in list or get responses, it is returned only at creation time or after a secret rotation.
*/
class WebhookPublic implements AdditionalDataHolder, Parsable 
{
    /**
     * @var bool|null $active The active property
    */
    private ?bool $active = null;
    
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var bool|null $allow_private_targets The allow_private_targets property
    */
    private ?bool $allow_private_targets = null;
    
    /**
     * @var DateTime|null $created_at The created_at property
    */
    private ?DateTime $created_at = null;
    
    /**
     * @var array<string>|null $event_types The event_types property
    */
    private ?array $event_types = null;
    
    /**
     * @var string|null $id The id property
    */
    private ?string $id = null;
    
    /**
     * @var string|null $org_id The org_id property
    */
    private ?string $org_id = null;
    
    /**
     * @var string|null $owner_user_id The owner_user_id property
    */
    private ?string $owner_user_id = null;
    
    /**
     * @var WebhookPublic_secret_rotated_at|null $secret_rotated_at The secret_rotated_at property
    */
    private ?WebhookPublic_secret_rotated_at $secret_rotated_at = null;
    
    /**
     * @var string|null $url The url property
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new WebhookPublic and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookPublic
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookPublic {
        return new WebhookPublic();
    }

    /**
     * Gets the active property value. The active property
     * @return bool|null
    */
    public function getActive(): ?bool {
        return $this->active;
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the allow_private_targets property value. The allow_private_targets property
     * @return bool|null
    */
    public function getAllowPrivateTargets(): ?bool {
        return $this->allow_private_targets;
    }

    /**
     * Gets the created_at property value. The created_at property
     * @return DateTime|null
    */
    public function getCreatedAt(): ?DateTime {
        return $this->created_at;
    }

    /**
     * Gets the event_types property value. The event_types property
     * @return array<string>|null
    */
    public function getEventTypes(): ?array {
        return $this->event_types;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'active' => fn(ParseNode $n) => $o->setActive($n->getBooleanValue()),
            'allow_private_targets' => fn(ParseNode $n) => $o->setAllowPrivateTargets($n->getBooleanValue()),
            'created_at' => fn(ParseNode $n) => $o->setCreatedAt($n->getDateTimeValue()),
            'event_types' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setEventTypes($val);
            },
            'id' => fn(ParseNode $n) => $o->setId($n->getStringValue()),
            'org_id' => fn(ParseNode $n) => $o->setOrgId($n->getStringValue()),
            'owner_user_id' => fn(ParseNode $n) => $o->setOwnerUserId($n->getStringValue()),
            'secret_rotated_at' => fn(ParseNode $n) => $o->setSecretRotatedAt($n->getObjectValue([WebhookPublic_secret_rotated_at::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
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
     * Gets the org_id property value. The org_id property
     * @return string|null
    */
    public function getOrgId(): ?string {
        return $this->org_id;
    }

    /**
     * Gets the owner_user_id property value. The owner_user_id property
     * @return string|null
    */
    public function getOwnerUserId(): ?string {
        return $this->owner_user_id;
    }

    /**
     * Gets the secret_rotated_at property value. The secret_rotated_at property
     * @return WebhookPublic_secret_rotated_at|null
    */
    public function getSecretRotatedAt(): ?WebhookPublic_secret_rotated_at {
        return $this->secret_rotated_at;
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
        $writer->writeBooleanValue('active', $this->getActive());
        $writer->writeBooleanValue('allow_private_targets', $this->getAllowPrivateTargets());
        $writer->writeDateTimeValue('created_at', $this->getCreatedAt());
        $writer->writeCollectionOfPrimitiveValues('event_types', $this->getEventTypes());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeStringValue('org_id', $this->getOrgId());
        $writer->writeStringValue('owner_user_id', $this->getOwnerUserId());
        $writer->writeObjectValue('secret_rotated_at', $this->getSecretRotatedAt());
        $writer->writeStringValue('url', $this->getUrl());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the active property value. The active property
     * @param bool|null $value Value to set for the active property.
    */
    public function setActive(?bool $value): void {
        $this->active = $value;
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the allow_private_targets property value. The allow_private_targets property
     * @param bool|null $value Value to set for the allow_private_targets property.
    */
    public function setAllowPrivateTargets(?bool $value): void {
        $this->allow_private_targets = $value;
    }

    /**
     * Sets the created_at property value. The created_at property
     * @param DateTime|null $value Value to set for the created_at property.
    */
    public function setCreatedAt(?DateTime $value): void {
        $this->created_at = $value;
    }

    /**
     * Sets the event_types property value. The event_types property
     * @param array<string>|null $value Value to set for the event_types property.
    */
    public function setEventTypes(?array $value): void {
        $this->event_types = $value;
    }

    /**
     * Sets the id property value. The id property
     * @param string|null $value Value to set for the id property.
    */
    public function setId(?string $value): void {
        $this->id = $value;
    }

    /**
     * Sets the org_id property value. The org_id property
     * @param string|null $value Value to set for the org_id property.
    */
    public function setOrgId(?string $value): void {
        $this->org_id = $value;
    }

    /**
     * Sets the owner_user_id property value. The owner_user_id property
     * @param string|null $value Value to set for the owner_user_id property.
    */
    public function setOwnerUserId(?string $value): void {
        $this->owner_user_id = $value;
    }

    /**
     * Sets the secret_rotated_at property value. The secret_rotated_at property
     * @param WebhookPublic_secret_rotated_at|null $value Value to set for the secret_rotated_at property.
    */
    public function setSecretRotatedAt(?WebhookPublic_secret_rotated_at $value): void {
        $this->secret_rotated_at = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
