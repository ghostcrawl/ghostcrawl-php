<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

class DeepCrawlBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var array<FilterSpec>|null $filters The filters property
    */
    private ?array $filters = null;
    
    /**
     * @var bool|null $include_sitemaps The include_sitemaps property
    */
    private ?bool $include_sitemaps = null;
    
    /**
     * @var int|null $max_depth The max_depth property
    */
    private ?int $max_depth = null;
    
    /**
     * @var int|null $max_urls The max_urls property
    */
    private ?int $max_urls = null;
    
    /**
     * @var bool|null $respect_robots The respect_robots property
    */
    private ?bool $respect_robots = null;
    
    /**
     * @var ScorerSpec|null $scorer The scorer property
    */
    private ?ScorerSpec $scorer = null;
    
    /**
     * @var array<string>|null $seed_urls The seed_urls property
    */
    private ?array $seed_urls = null;
    
    /**
     * @var string|null $strategy The strategy property
    */
    private ?string $strategy = null;
    
    /**
     * @var bool|null $stream The stream property
    */
    private ?bool $stream = null;
    
    /**
     * @var DeepCrawlBody_webhook_url|null $webhook_url The webhook_url property
    */
    private ?DeepCrawlBody_webhook_url $webhook_url = null;
    
    /**
     * Instantiates a new DeepCrawlBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setIncludeSitemaps(false);
        $this->setMaxDepth(3);
        $this->setMaxUrls(1000);
        $this->setRespectRobots(true);
        $this->setStrategy('bfs');
        $this->setStream(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return DeepCrawlBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): DeepCrawlBody {
        return new DeepCrawlBody();
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
            'filters' => fn(ParseNode $n) => $o->setFilters($n->getCollectionOfObjectValues([FilterSpec::class, 'createFromDiscriminatorValue'])),
            'include_sitemaps' => fn(ParseNode $n) => $o->setIncludeSitemaps($n->getBooleanValue()),
            'max_depth' => fn(ParseNode $n) => $o->setMaxDepth($n->getIntegerValue()),
            'max_urls' => fn(ParseNode $n) => $o->setMaxUrls($n->getIntegerValue()),
            'respect_robots' => fn(ParseNode $n) => $o->setRespectRobots($n->getBooleanValue()),
            'scorer' => fn(ParseNode $n) => $o->setScorer($n->getObjectValue([ScorerSpec::class, 'createFromDiscriminatorValue'])),
            'seed_urls' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setSeedUrls($val);
            },
            'strategy' => fn(ParseNode $n) => $o->setStrategy($n->getStringValue()),
            'stream' => fn(ParseNode $n) => $o->setStream($n->getBooleanValue()),
            'webhook_url' => fn(ParseNode $n) => $o->setWebhookUrl($n->getObjectValue([DeepCrawlBody_webhook_url::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the filters property value. The filters property
     * @return array<FilterSpec>|null
    */
    public function getFilters(): ?array {
        return $this->filters;
    }

    /**
     * Gets the include_sitemaps property value. The include_sitemaps property
     * @return bool|null
    */
    public function getIncludeSitemaps(): ?bool {
        return $this->include_sitemaps;
    }

    /**
     * Gets the max_depth property value. The max_depth property
     * @return int|null
    */
    public function getMaxDepth(): ?int {
        return $this->max_depth;
    }

    /**
     * Gets the max_urls property value. The max_urls property
     * @return int|null
    */
    public function getMaxUrls(): ?int {
        return $this->max_urls;
    }

    /**
     * Gets the respect_robots property value. The respect_robots property
     * @return bool|null
    */
    public function getRespectRobots(): ?bool {
        return $this->respect_robots;
    }

    /**
     * Gets the scorer property value. The scorer property
     * @return ScorerSpec|null
    */
    public function getScorer(): ?ScorerSpec {
        return $this->scorer;
    }

    /**
     * Gets the seed_urls property value. The seed_urls property
     * @return array<string>|null
    */
    public function getSeedUrls(): ?array {
        return $this->seed_urls;
    }

    /**
     * Gets the strategy property value. The strategy property
     * @return string|null
    */
    public function getStrategy(): ?string {
        return $this->strategy;
    }

    /**
     * Gets the stream property value. The stream property
     * @return bool|null
    */
    public function getStream(): ?bool {
        return $this->stream;
    }

    /**
     * Gets the webhook_url property value. The webhook_url property
     * @return DeepCrawlBody_webhook_url|null
    */
    public function getWebhookUrl(): ?DeepCrawlBody_webhook_url {
        return $this->webhook_url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfObjectValues('filters', $this->getFilters());
        $writer->writeBooleanValue('include_sitemaps', $this->getIncludeSitemaps());
        $writer->writeIntegerValue('max_depth', $this->getMaxDepth());
        $writer->writeIntegerValue('max_urls', $this->getMaxUrls());
        $writer->writeBooleanValue('respect_robots', $this->getRespectRobots());
        $writer->writeObjectValue('scorer', $this->getScorer());
        $writer->writeCollectionOfPrimitiveValues('seed_urls', $this->getSeedUrls());
        $writer->writeStringValue('strategy', $this->getStrategy());
        $writer->writeBooleanValue('stream', $this->getStream());
        $writer->writeObjectValue('webhook_url', $this->getWebhookUrl());
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
     * Sets the filters property value. The filters property
     * @param array<FilterSpec>|null $value Value to set for the filters property.
    */
    public function setFilters(?array $value): void {
        $this->filters = $value;
    }

    /**
     * Sets the include_sitemaps property value. The include_sitemaps property
     * @param bool|null $value Value to set for the include_sitemaps property.
    */
    public function setIncludeSitemaps(?bool $value): void {
        $this->include_sitemaps = $value;
    }

    /**
     * Sets the max_depth property value. The max_depth property
     * @param int|null $value Value to set for the max_depth property.
    */
    public function setMaxDepth(?int $value): void {
        $this->max_depth = $value;
    }

    /**
     * Sets the max_urls property value. The max_urls property
     * @param int|null $value Value to set for the max_urls property.
    */
    public function setMaxUrls(?int $value): void {
        $this->max_urls = $value;
    }

    /**
     * Sets the respect_robots property value. The respect_robots property
     * @param bool|null $value Value to set for the respect_robots property.
    */
    public function setRespectRobots(?bool $value): void {
        $this->respect_robots = $value;
    }

    /**
     * Sets the scorer property value. The scorer property
     * @param ScorerSpec|null $value Value to set for the scorer property.
    */
    public function setScorer(?ScorerSpec $value): void {
        $this->scorer = $value;
    }

    /**
     * Sets the seed_urls property value. The seed_urls property
     * @param array<string>|null $value Value to set for the seed_urls property.
    */
    public function setSeedUrls(?array $value): void {
        $this->seed_urls = $value;
    }

    /**
     * Sets the strategy property value. The strategy property
     * @param string|null $value Value to set for the strategy property.
    */
    public function setStrategy(?string $value): void {
        $this->strategy = $value;
    }

    /**
     * Sets the stream property value. The stream property
     * @param bool|null $value Value to set for the stream property.
    */
    public function setStream(?bool $value): void {
        $this->stream = $value;
    }

    /**
     * Sets the webhook_url property value. The webhook_url property
     * @param DeepCrawlBody_webhook_url|null $value Value to set for the webhook_url property.
    */
    public function setWebhookUrl(?DeepCrawlBody_webhook_url $value): void {
        $this->webhook_url = $value;
    }

}
