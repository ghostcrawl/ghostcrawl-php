<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/schedules body.
*/
class ScheduleCreateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $cron_expr 5-field cron expression, e.g. '0 9 * * 1'.
    */
    private ?string $cron_expr = null;
    
    /**
     * @var ScheduleCreateRequest_job_params|null $job_params Full scrape/crawl request body.
    */
    private ?ScheduleCreateRequest_job_params $job_params = null;
    
    /**
     * @var string|null $job_type 'scrape', 'crawl', or 'change_monitor'.
    */
    private ?string $job_type = null;
    
    /**
     * @var bool|null $monitor_mode When True, fires notify_webhook only when content hash changes.
    */
    private ?bool $monitor_mode = null;
    
    /**
     * @var string|null $name Schedule name. Unique per org (409 on conflict).
    */
    private ?string $name = null;
    
    /**
     * @var ScheduleCreateRequest_notify_webhook|null $notify_webhook HTTPS webhook URL for change-monitor notifications.
    */
    private ?ScheduleCreateRequest_notify_webhook $notify_webhook = null;
    
    /**
     * Instantiates a new ScheduleCreateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setMonitorMode(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScheduleCreateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScheduleCreateRequest {
        return new ScheduleCreateRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the cron_expr property value. 5-field cron expression, e.g. '0 9 * * 1'.
     * @return string|null
    */
    public function getCronExpr(): ?string {
        return $this->cron_expr;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'cron_expr' => fn(ParseNode $n) => $o->setCronExpr($n->getStringValue()),
            'job_params' => fn(ParseNode $n) => $o->setJobParams($n->getObjectValue([ScheduleCreateRequest_job_params::class, 'createFromDiscriminatorValue'])),
            'job_type' => fn(ParseNode $n) => $o->setJobType($n->getStringValue()),
            'monitor_mode' => fn(ParseNode $n) => $o->setMonitorMode($n->getBooleanValue()),
            'name' => fn(ParseNode $n) => $o->setName($n->getStringValue()),
            'notify_webhook' => fn(ParseNode $n) => $o->setNotifyWebhook($n->getObjectValue([ScheduleCreateRequest_notify_webhook::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the job_params property value. Full scrape/crawl request body.
     * @return ScheduleCreateRequest_job_params|null
    */
    public function getJobParams(): ?ScheduleCreateRequest_job_params {
        return $this->job_params;
    }

    /**
     * Gets the job_type property value. 'scrape', 'crawl', or 'change_monitor'.
     * @return string|null
    */
    public function getJobType(): ?string {
        return $this->job_type;
    }

    /**
     * Gets the monitor_mode property value. When True, fires notify_webhook only when content hash changes.
     * @return bool|null
    */
    public function getMonitorMode(): ?bool {
        return $this->monitor_mode;
    }

    /**
     * Gets the name property value. Schedule name. Unique per org (409 on conflict).
     * @return string|null
    */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Gets the notify_webhook property value. HTTPS webhook URL for change-monitor notifications.
     * @return ScheduleCreateRequest_notify_webhook|null
    */
    public function getNotifyWebhook(): ?ScheduleCreateRequest_notify_webhook {
        return $this->notify_webhook;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('cron_expr', $this->getCronExpr());
        $writer->writeObjectValue('job_params', $this->getJobParams());
        $writer->writeStringValue('job_type', $this->getJobType());
        $writer->writeBooleanValue('monitor_mode', $this->getMonitorMode());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeObjectValue('notify_webhook', $this->getNotifyWebhook());
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
     * Sets the cron_expr property value. 5-field cron expression, e.g. '0 9 * * 1'.
     * @param string|null $value Value to set for the cron_expr property.
    */
    public function setCronExpr(?string $value): void {
        $this->cron_expr = $value;
    }

    /**
     * Sets the job_params property value. Full scrape/crawl request body.
     * @param ScheduleCreateRequest_job_params|null $value Value to set for the job_params property.
    */
    public function setJobParams(?ScheduleCreateRequest_job_params $value): void {
        $this->job_params = $value;
    }

    /**
     * Sets the job_type property value. 'scrape', 'crawl', or 'change_monitor'.
     * @param string|null $value Value to set for the job_type property.
    */
    public function setJobType(?string $value): void {
        $this->job_type = $value;
    }

    /**
     * Sets the monitor_mode property value. When True, fires notify_webhook only when content hash changes.
     * @param bool|null $value Value to set for the monitor_mode property.
    */
    public function setMonitorMode(?bool $value): void {
        $this->monitor_mode = $value;
    }

    /**
     * Sets the name property value. Schedule name. Unique per org (409 on conflict).
     * @param string|null $value Value to set for the name property.
    */
    public function setName(?string $value): void {
        $this->name = $value;
    }

    /**
     * Sets the notify_webhook property value. HTTPS webhook URL for change-monitor notifications.
     * @param ScheduleCreateRequest_notify_webhook|null $value Value to set for the notify_webhook property.
    */
    public function setNotifyWebhook(?ScheduleCreateRequest_notify_webhook $value): void {
        $this->notify_webhook = $value;
    }

}
