<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Request body for POST /v1/webhooks.
*/
class WebhookCreateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var bool|null $allow_private_targets Allow private/internal IP targets (hosted mode only). Requires webhooks:admin scope when deployment_mode=hosted.
    */
    private ?bool $allow_private_targets = null;
    
    /**
     * @var array<string>|null $event_types Event types to subscribe to. Must be non-empty subset of: ['agent.run.completed', 'agent.run.failed', 'budget.exceeded', 'budget.warning', 'cost.daily.threshold_critical', 'cost.daily.threshold_warning', 'cost.month_end.projected_overrun', 'crawl.completed', 'dataset.updated', 'extract.completed', 'extract.failed', 'manual_test', 'recording.saved', 'scrape.completed', 'scrape.failed', 'session.ended', 'team.api_key.created', 'team.api_key.revoked', 'team.signup.verified'].
    */
    private ?array $event_types = null;
    
    /**
     * @var string|null $url Destination URL for webhook delivery. Must be HTTPS.
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new WebhookCreateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setAllowPrivateTargets(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookCreateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookCreateRequest {
        return new WebhookCreateRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the allow_private_targets property value. Allow private/internal IP targets (hosted mode only). Requires webhooks:admin scope when deployment_mode=hosted.
     * @return bool|null
    */
    public function getAllowPrivateTargets(): ?bool {
        return $this->allow_private_targets;
    }

    /**
     * Gets the event_types property value. Event types to subscribe to. Must be non-empty subset of: ['agent.run.completed', 'agent.run.failed', 'budget.exceeded', 'budget.warning', 'cost.daily.threshold_critical', 'cost.daily.threshold_warning', 'cost.month_end.projected_overrun', 'crawl.completed', 'dataset.updated', 'extract.completed', 'extract.failed', 'manual_test', 'recording.saved', 'scrape.completed', 'scrape.failed', 'session.ended', 'team.api_key.created', 'team.api_key.revoked', 'team.signup.verified'].
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
            'allow_private_targets' => fn(ParseNode $n) => $o->setAllowPrivateTargets($n->getBooleanValue()),
            'event_types' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setEventTypes($val);
            },
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the url property value. Destination URL for webhook delivery. Must be HTTPS.
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
        $writer->writeBooleanValue('allow_private_targets', $this->getAllowPrivateTargets());
        $writer->writeCollectionOfPrimitiveValues('event_types', $this->getEventTypes());
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
     * Sets the allow_private_targets property value. Allow private/internal IP targets (hosted mode only). Requires webhooks:admin scope when deployment_mode=hosted.
     * @param bool|null $value Value to set for the allow_private_targets property.
    */
    public function setAllowPrivateTargets(?bool $value): void {
        $this->allow_private_targets = $value;
    }

    /**
     * Sets the event_types property value. Event types to subscribe to. Must be non-empty subset of: ['agent.run.completed', 'agent.run.failed', 'budget.exceeded', 'budget.warning', 'cost.daily.threshold_critical', 'cost.daily.threshold_warning', 'cost.month_end.projected_overrun', 'crawl.completed', 'dataset.updated', 'extract.completed', 'extract.failed', 'manual_test', 'recording.saved', 'scrape.completed', 'scrape.failed', 'session.ended', 'team.api_key.created', 'team.api_key.revoked', 'team.signup.verified'].
     * @param array<string>|null $value Value to set for the event_types property.
    */
    public function setEventTypes(?array $value): void {
        $this->event_types = $value;
    }

    /**
     * Sets the url property value. Destination URL for webhook delivery. Must be HTTPS.
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
