<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Response for POST /v1/webhooks (201 Created). `secret` is the plaintext signing secret returned ONCE. Store itimmediately, subsequent GET calls return WebhookPublic which excludes the secret.
*/
class WebhookCreateResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $secret Plaintext signing secret. Returned only once, store it now.
    */
    private ?string $secret = null;
    
    /**
     * @var WebhookPublic|null $webhook Public webhook subscription details. The signing secret is never included in list or get responses, it is returned only at creation time or after a secret rotation.
    */
    private ?WebhookPublic $webhook = null;
    
    /**
     * Instantiates a new WebhookCreateResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookCreateResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookCreateResponse {
        return new WebhookCreateResponse();
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
            'secret' => fn(ParseNode $n) => $o->setSecret($n->getStringValue()),
            'webhook' => fn(ParseNode $n) => $o->setWebhook($n->getObjectValue([WebhookPublic::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the secret property value. Plaintext signing secret. Returned only once, store it now.
     * @return string|null
    */
    public function getSecret(): ?string {
        return $this->secret;
    }

    /**
     * Gets the webhook property value. Public webhook subscription details. The signing secret is never included in list or get responses, it is returned only at creation time or after a secret rotation.
     * @return WebhookPublic|null
    */
    public function getWebhook(): ?WebhookPublic {
        return $this->webhook;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('secret', $this->getSecret());
        $writer->writeObjectValue('webhook', $this->getWebhook());
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
     * Sets the secret property value. Plaintext signing secret. Returned only once, store it now.
     * @param string|null $value Value to set for the secret property.
    */
    public function setSecret(?string $value): void {
        $this->secret = $value;
    }

    /**
     * Sets the webhook property value. Public webhook subscription details. The signing secret is never included in list or get responses, it is returned only at creation time or after a secret rotation.
     * @param WebhookPublic|null $value Value to set for the webhook property.
    */
    public function setWebhook(?WebhookPublic $value): void {
        $this->webhook = $value;
    }

}
