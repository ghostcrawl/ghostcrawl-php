<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class PolicyUpsertRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $cutoff_policy The cutoff_policy property
    */
    private ?string $cutoff_policy = null;
    
    /**
     * @var PolicyUpsertRequest_max_crawl_pages|null $max_crawl_pages The max_crawl_pages property
    */
    private ?PolicyUpsertRequest_max_crawl_pages $max_crawl_pages = null;
    
    /**
     * @var PolicyUpsertRequest_max_llm_calls|null $max_llm_calls The max_llm_calls property
    */
    private ?PolicyUpsertRequest_max_llm_calls $max_llm_calls = null;
    
    /**
     * @var PolicyUpsertRequest_max_llm_tokens|null $max_llm_tokens The max_llm_tokens property
    */
    private ?PolicyUpsertRequest_max_llm_tokens $max_llm_tokens = null;
    
    /**
     * @var string|null $scope_id The scope_id property
    */
    private ?string $scope_id = null;
    
    /**
     * @var string|null $scope_type The scope_type property
    */
    private ?string $scope_type = null;
    
    /**
     * @var int|null $warning_threshold_pct The warning_threshold_pct property
    */
    private ?int $warning_threshold_pct = null;
    
    /**
     * Instantiates a new PolicyUpsertRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setCutoffPolicy('hard');
        $this->setWarningThresholdPct(80);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PolicyUpsertRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PolicyUpsertRequest {
        return new PolicyUpsertRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the cutoff_policy property value. The cutoff_policy property
     * @return string|null
    */
    public function getCutoffPolicy(): ?string {
        return $this->cutoff_policy;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'cutoff_policy' => fn(ParseNode $n) => $o->setCutoffPolicy($n->getStringValue()),
            'max_crawl_pages' => fn(ParseNode $n) => $o->setMaxCrawlPages($n->getObjectValue([PolicyUpsertRequest_max_crawl_pages::class, 'createFromDiscriminatorValue'])),
            'max_llm_calls' => fn(ParseNode $n) => $o->setMaxLlmCalls($n->getObjectValue([PolicyUpsertRequest_max_llm_calls::class, 'createFromDiscriminatorValue'])),
            'max_llm_tokens' => fn(ParseNode $n) => $o->setMaxLlmTokens($n->getObjectValue([PolicyUpsertRequest_max_llm_tokens::class, 'createFromDiscriminatorValue'])),
            'scope_id' => fn(ParseNode $n) => $o->setScopeId($n->getStringValue()),
            'scope_type' => fn(ParseNode $n) => $o->setScopeType($n->getStringValue()),
            'warning_threshold_pct' => fn(ParseNode $n) => $o->setWarningThresholdPct($n->getIntegerValue()),
        ];
    }

    /**
     * Gets the max_crawl_pages property value. The max_crawl_pages property
     * @return PolicyUpsertRequest_max_crawl_pages|null
    */
    public function getMaxCrawlPages(): ?PolicyUpsertRequest_max_crawl_pages {
        return $this->max_crawl_pages;
    }

    /**
     * Gets the max_llm_calls property value. The max_llm_calls property
     * @return PolicyUpsertRequest_max_llm_calls|null
    */
    public function getMaxLlmCalls(): ?PolicyUpsertRequest_max_llm_calls {
        return $this->max_llm_calls;
    }

    /**
     * Gets the max_llm_tokens property value. The max_llm_tokens property
     * @return PolicyUpsertRequest_max_llm_tokens|null
    */
    public function getMaxLlmTokens(): ?PolicyUpsertRequest_max_llm_tokens {
        return $this->max_llm_tokens;
    }

    /**
     * Gets the scope_id property value. The scope_id property
     * @return string|null
    */
    public function getScopeId(): ?string {
        return $this->scope_id;
    }

    /**
     * Gets the scope_type property value. The scope_type property
     * @return string|null
    */
    public function getScopeType(): ?string {
        return $this->scope_type;
    }

    /**
     * Gets the warning_threshold_pct property value. The warning_threshold_pct property
     * @return int|null
    */
    public function getWarningThresholdPct(): ?int {
        return $this->warning_threshold_pct;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('cutoff_policy', $this->getCutoffPolicy());
        $writer->writeObjectValue('max_crawl_pages', $this->getMaxCrawlPages());
        $writer->writeObjectValue('max_llm_calls', $this->getMaxLlmCalls());
        $writer->writeObjectValue('max_llm_tokens', $this->getMaxLlmTokens());
        $writer->writeStringValue('scope_id', $this->getScopeId());
        $writer->writeStringValue('scope_type', $this->getScopeType());
        $writer->writeIntegerValue('warning_threshold_pct', $this->getWarningThresholdPct());
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
     * Sets the cutoff_policy property value. The cutoff_policy property
     * @param string|null $value Value to set for the cutoff_policy property.
    */
    public function setCutoffPolicy(?string $value): void {
        $this->cutoff_policy = $value;
    }

    /**
     * Sets the max_crawl_pages property value. The max_crawl_pages property
     * @param PolicyUpsertRequest_max_crawl_pages|null $value Value to set for the max_crawl_pages property.
    */
    public function setMaxCrawlPages(?PolicyUpsertRequest_max_crawl_pages $value): void {
        $this->max_crawl_pages = $value;
    }

    /**
     * Sets the max_llm_calls property value. The max_llm_calls property
     * @param PolicyUpsertRequest_max_llm_calls|null $value Value to set for the max_llm_calls property.
    */
    public function setMaxLlmCalls(?PolicyUpsertRequest_max_llm_calls $value): void {
        $this->max_llm_calls = $value;
    }

    /**
     * Sets the max_llm_tokens property value. The max_llm_tokens property
     * @param PolicyUpsertRequest_max_llm_tokens|null $value Value to set for the max_llm_tokens property.
    */
    public function setMaxLlmTokens(?PolicyUpsertRequest_max_llm_tokens $value): void {
        $this->max_llm_tokens = $value;
    }

    /**
     * Sets the scope_id property value. The scope_id property
     * @param string|null $value Value to set for the scope_id property.
    */
    public function setScopeId(?string $value): void {
        $this->scope_id = $value;
    }

    /**
     * Sets the scope_type property value. The scope_type property
     * @param string|null $value Value to set for the scope_type property.
    */
    public function setScopeType(?string $value): void {
        $this->scope_type = $value;
    }

    /**
     * Sets the warning_threshold_pct property value. The warning_threshold_pct property
     * @param int|null $value Value to set for the warning_threshold_pct property.
    */
    public function setWarningThresholdPct(?int $value): void {
        $this->warning_threshold_pct = $value;
    }

}
