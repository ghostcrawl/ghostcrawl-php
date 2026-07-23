<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Response for POST /v1/webhooks/{id}/rotate-secret. `secret` is the new signing secret. The previous secret remains valid for a short grace period so in-flight deliveries can still be verified. `prev_secret_expires_at` is when the grace period ends.
*/
class RotateSecretResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var DateTime|null $prev_secret_expires_at When the previous signing secret expires and the grace period ends.
    */
    private ?DateTime $prev_secret_expires_at = null;
    
    /**
     * @var DateTime|null $rotated_at The rotated_at property
    */
    private ?DateTime $rotated_at = null;
    
    /**
     * @var string|null $secret New signing secret. The previous secret remains valid during the grace period.
    */
    private ?string $secret = null;
    
    /**
     * @var string|null $webhook_id The webhook_id property
    */
    private ?string $webhook_id = null;
    
    /**
     * Instantiates a new RotateSecretResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return RotateSecretResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): RotateSecretResponse {
        return new RotateSecretResponse();
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
            'prev_secret_expires_at' => fn(ParseNode $n) => $o->setPrevSecretExpiresAt($n->getDateTimeValue()),
            'rotated_at' => fn(ParseNode $n) => $o->setRotatedAt($n->getDateTimeValue()),
            'secret' => fn(ParseNode $n) => $o->setSecret($n->getStringValue()),
            'webhook_id' => fn(ParseNode $n) => $o->setWebhookId($n->getStringValue()),
        ];
    }

    /**
     * Gets the prev_secret_expires_at property value. When the previous signing secret expires and the grace period ends.
     * @return DateTime|null
    */
    public function getPrevSecretExpiresAt(): ?DateTime {
        return $this->prev_secret_expires_at;
    }

    /**
     * Gets the rotated_at property value. The rotated_at property
     * @return DateTime|null
    */
    public function getRotatedAt(): ?DateTime {
        return $this->rotated_at;
    }

    /**
     * Gets the secret property value. New signing secret. The previous secret remains valid during the grace period.
     * @return string|null
    */
    public function getSecret(): ?string {
        return $this->secret;
    }

    /**
     * Gets the webhook_id property value. The webhook_id property
     * @return string|null
    */
    public function getWebhookId(): ?string {
        return $this->webhook_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeDateTimeValue('prev_secret_expires_at', $this->getPrevSecretExpiresAt());
        $writer->writeDateTimeValue('rotated_at', $this->getRotatedAt());
        $writer->writeStringValue('secret', $this->getSecret());
        $writer->writeStringValue('webhook_id', $this->getWebhookId());
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
     * Sets the prev_secret_expires_at property value. When the previous signing secret expires and the grace period ends.
     * @param DateTime|null $value Value to set for the prev_secret_expires_at property.
    */
    public function setPrevSecretExpiresAt(?DateTime $value): void {
        $this->prev_secret_expires_at = $value;
    }

    /**
     * Sets the rotated_at property value. The rotated_at property
     * @param DateTime|null $value Value to set for the rotated_at property.
    */
    public function setRotatedAt(?DateTime $value): void {
        $this->rotated_at = $value;
    }

    /**
     * Sets the secret property value. New signing secret. The previous secret remains valid during the grace period.
     * @param string|null $value Value to set for the secret property.
    */
    public function setSecret(?string $value): void {
        $this->secret = $value;
    }

    /**
     * Sets the webhook_id property value. The webhook_id property
     * @param string|null $value Value to set for the webhook_id property.
    */
    public function setWebhookId(?string $value): void {
        $this->webhook_id = $value;
    }

}
