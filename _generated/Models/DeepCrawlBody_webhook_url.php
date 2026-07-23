<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes DeepCrawlBody_webhook_urlMember1, string
*/
class DeepCrawlBody_webhook_url implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var DeepCrawlBody_webhook_urlMember1|null $deepCrawlBody_webhook_urlMember1 Composed type representation for type DeepCrawlBody_webhook_urlMember1
    */
    private ?DeepCrawlBody_webhook_urlMember1 $deepCrawlBody_webhook_urlMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return DeepCrawlBody_webhook_url
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): DeepCrawlBody_webhook_url {
        $result = new DeepCrawlBody_webhook_url();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setDeepCrawlBodyWebhookUrlMember1(new DeepCrawlBody_webhook_urlMember1());
        }
        return $result;
    }

    /**
     * Gets the DeepCrawlBody_webhook_urlMember1 property value. Composed type representation for type DeepCrawlBody_webhook_urlMember1
     * @return DeepCrawlBody_webhook_urlMember1|null
    */
    public function getDeepCrawlBodyWebhookUrlMember1(): ?DeepCrawlBody_webhook_urlMember1 {
        return $this->deepCrawlBody_webhook_urlMember1;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getDeepCrawlBodyWebhookUrlMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getDeepCrawlBodyWebhookUrlMember1());
        }
        return [];
    }

    /**
     * Gets the string property value. Composed type representation for type string
     * @return string|null
    */
    public function getString(): ?string {
        return $this->string;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getDeepCrawlBodyWebhookUrlMember1());
        }
    }

    /**
     * Sets the DeepCrawlBody_webhook_urlMember1 property value. Composed type representation for type DeepCrawlBody_webhook_urlMember1
     * @param DeepCrawlBody_webhook_urlMember1|null $value Value to set for the DeepCrawlBody_webhook_urlMember1 property.
    */
    public function setDeepCrawlBodyWebhookUrlMember1(?DeepCrawlBody_webhook_urlMember1 $value): void {
        $this->deepCrawlBody_webhook_urlMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
