<?php

namespace GhostCrawl\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes DateTime, WebhookPublic_secret_rotated_atMember1
*/
class WebhookPublic_secret_rotated_at implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var DateTime|null $dateTimeOffset Composed type representation for type DateTime
    */
    private ?DateTime $dateTimeOffset = null;
    
    /**
     * @var WebhookPublic_secret_rotated_atMember1|null $webhookPublic_secret_rotated_atMember1 Composed type representation for type WebhookPublic_secret_rotated_atMember1
    */
    private ?WebhookPublic_secret_rotated_atMember1 $webhookPublic_secret_rotated_atMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookPublic_secret_rotated_at
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookPublic_secret_rotated_at {
        $result = new WebhookPublic_secret_rotated_at();
        if ($parseNode->getDateTimeValue() !== null) {
            $result->setDateTimeOffset($parseNode->getDateTimeValue());
        } else {
            $result->setWebhookPublicSecretRotatedAtMember1(new WebhookPublic_secret_rotated_atMember1());
        }
        return $result;
    }

    /**
     * Gets the DateTimeOffset property value. Composed type representation for type DateTime
     * @return DateTime|null
    */
    public function getDateTimeOffset(): ?DateTime {
        return $this->dateTimeOffset;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookPublicSecretRotatedAtMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookPublicSecretRotatedAtMember1());
        }
        return [];
    }

    /**
     * Gets the WebhookPublic_secret_rotated_atMember1 property value. Composed type representation for type WebhookPublic_secret_rotated_atMember1
     * @return WebhookPublic_secret_rotated_atMember1|null
    */
    public function getWebhookPublicSecretRotatedAtMember1(): ?WebhookPublic_secret_rotated_atMember1 {
        return $this->webhookPublic_secret_rotated_atMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getDateTimeOffset() !== null) {
            $writer->writeDateTimeValue(null, $this->getDateTimeOffset());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookPublicSecretRotatedAtMember1());
        }
    }

    /**
     * Sets the DateTimeOffset property value. Composed type representation for type DateTime
     * @param DateTime|null $value Value to set for the DateTimeOffset property.
    */
    public function setDateTimeOffset(?DateTime $value): void {
        $this->dateTimeOffset = $value;
    }

    /**
     * Sets the WebhookPublic_secret_rotated_atMember1 property value. Composed type representation for type WebhookPublic_secret_rotated_atMember1
     * @param WebhookPublic_secret_rotated_atMember1|null $value Value to set for the WebhookPublic_secret_rotated_atMember1 property.
    */
    public function setWebhookPublicSecretRotatedAtMember1(?WebhookPublic_secret_rotated_atMember1 $value): void {
        $this->webhookPublic_secret_rotated_atMember1 = $value;
    }

}
