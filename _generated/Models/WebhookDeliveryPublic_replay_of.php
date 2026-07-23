<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes string, WebhookDeliveryPublic_replay_ofMember1
*/
class WebhookDeliveryPublic_replay_of implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var string|null $guid Composed type representation for type string
    */
    private ?string $guid = null;
    
    /**
     * @var WebhookDeliveryPublic_replay_ofMember1|null $webhookDeliveryPublic_replay_ofMember1 Composed type representation for type WebhookDeliveryPublic_replay_ofMember1
    */
    private ?WebhookDeliveryPublic_replay_ofMember1 $webhookDeliveryPublic_replay_ofMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryPublic_replay_of
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryPublic_replay_of {
        $result = new WebhookDeliveryPublic_replay_of();
        if ($parseNode->getStringValue() !== null) {
            $result->setGuid($parseNode->getStringValue());
        } else {
            $result->setWebhookDeliveryPublicReplayOfMember1(new WebhookDeliveryPublic_replay_ofMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getWebhookDeliveryPublicReplayOfMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getWebhookDeliveryPublicReplayOfMember1());
        }
        return [];
    }

    /**
     * Gets the Guid property value. Composed type representation for type string
     * @return string|null
    */
    public function getGuid(): ?string {
        return $this->guid;
    }

    /**
     * Gets the WebhookDeliveryPublic_replay_ofMember1 property value. Composed type representation for type WebhookDeliveryPublic_replay_ofMember1
     * @return WebhookDeliveryPublic_replay_ofMember1|null
    */
    public function getWebhookDeliveryPublicReplayOfMember1(): ?WebhookDeliveryPublic_replay_ofMember1 {
        return $this->webhookDeliveryPublic_replay_ofMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getGuid() !== null) {
            $writer->writeStringValue(null, $this->getGuid());
        } else {
            $writer->writeObjectValue(null, $this->getWebhookDeliveryPublicReplayOfMember1());
        }
    }

    /**
     * Sets the Guid property value. Composed type representation for type string
     * @param string|null $value Value to set for the Guid property.
    */
    public function setGuid(?string $value): void {
        $this->guid = $value;
    }

    /**
     * Sets the WebhookDeliveryPublic_replay_ofMember1 property value. Composed type representation for type WebhookDeliveryPublic_replay_ofMember1
     * @param WebhookDeliveryPublic_replay_ofMember1|null $value Value to set for the WebhookDeliveryPublic_replay_ofMember1 property.
    */
    public function setWebhookDeliveryPublicReplayOfMember1(?WebhookDeliveryPublic_replay_ofMember1 $value): void {
        $this->webhookDeliveryPublic_replay_ofMember1 = $value;
    }

}
