<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Request body for POST /v1/scrape/batch. Accepts 1–20 URLs and a concurrency cap 1–10. All other fields mirrorthe shared scrape params from ScrapeBody and are applied uniformly toevery URL in the batch.
*/
class BatchScrapeRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var BatchScrapeRequest_behavior_actions|null $behavior_actions The behavior_actions property
    */
    private ?BatchScrapeRequest_behavior_actions $behavior_actions = null;
    
    /**
     * @var int|null $concurrency The concurrency property
    */
    private ?int $concurrency = null;
    
    /**
     * @var BatchScrapeRequest_extraction_strategy|null $extraction_strategy The extraction_strategy property
    */
    private ?BatchScrapeRequest_extraction_strategy $extraction_strategy = null;
    
    /**
     * @var BatchScrapeRequest_identity_country|null $identity_country The identity_country property
    */
    private ?BatchScrapeRequest_identity_country $identity_country = null;
    
    /**
     * @var BatchScrapeRequest_language|null $language The language property
    */
    private ?BatchScrapeRequest_language $language = null;
    
    /**
     * @var BatchScrapeRequest_output_format|null $output_format The output_format property
    */
    private ?BatchScrapeRequest_output_format $output_format = null;
    
    /**
     * @var BatchScrapeRequest_profile|null $profile The profile property
    */
    private ?BatchScrapeRequest_profile $profile = null;
    
    /**
     * @var int|null $scroll_steps The scroll_steps property
    */
    private ?int $scroll_steps = null;
    
    /**
     * @var bool|null $scroll_to_bottom The scroll_to_bottom property
    */
    private ?bool $scroll_to_bottom = null;
    
    /**
     * @var array<string>|null $urls The urls property
    */
    private ?array $urls = null;
    
    /**
     * Instantiates a new BatchScrapeRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setConcurrency(3);
        $this->setOutputFormat(new BatchScrapeRequest_output_format('html'));
        $this->setScrollSteps(3);
        $this->setScrollToBottom(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return BatchScrapeRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): BatchScrapeRequest {
        return new BatchScrapeRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the behavior_actions property value. The behavior_actions property
     * @return BatchScrapeRequest_behavior_actions|null
    */
    public function getBehaviorActions(): ?BatchScrapeRequest_behavior_actions {
        return $this->behavior_actions;
    }

    /**
     * Gets the concurrency property value. The concurrency property
     * @return int|null
    */
    public function getConcurrency(): ?int {
        return $this->concurrency;
    }

    /**
     * Gets the extraction_strategy property value. The extraction_strategy property
     * @return BatchScrapeRequest_extraction_strategy|null
    */
    public function getExtractionStrategy(): ?BatchScrapeRequest_extraction_strategy {
        return $this->extraction_strategy;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'behavior_actions' => fn(ParseNode $n) => $o->setBehaviorActions($n->getObjectValue([BatchScrapeRequest_behavior_actions::class, 'createFromDiscriminatorValue'])),
            'concurrency' => fn(ParseNode $n) => $o->setConcurrency($n->getIntegerValue()),
            'extraction_strategy' => fn(ParseNode $n) => $o->setExtractionStrategy($n->getObjectValue([BatchScrapeRequest_extraction_strategy::class, 'createFromDiscriminatorValue'])),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([BatchScrapeRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getObjectValue([BatchScrapeRequest_language::class, 'createFromDiscriminatorValue'])),
            'output_format' => fn(ParseNode $n) => $o->setOutputFormat($n->getEnumValue(BatchScrapeRequest_output_format::class)),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([BatchScrapeRequest_profile::class, 'createFromDiscriminatorValue'])),
            'scroll_steps' => fn(ParseNode $n) => $o->setScrollSteps($n->getIntegerValue()),
            'scroll_to_bottom' => fn(ParseNode $n) => $o->setScrollToBottom($n->getBooleanValue()),
            'urls' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setUrls($val);
            },
        ];
    }

    /**
     * Gets the identity_country property value. The identity_country property
     * @return BatchScrapeRequest_identity_country|null
    */
    public function getIdentityCountry(): ?BatchScrapeRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the language property value. The language property
     * @return BatchScrapeRequest_language|null
    */
    public function getLanguage(): ?BatchScrapeRequest_language {
        return $this->language;
    }

    /**
     * Gets the output_format property value. The output_format property
     * @return BatchScrapeRequest_output_format|null
    */
    public function getOutputFormat(): ?BatchScrapeRequest_output_format {
        return $this->output_format;
    }

    /**
     * Gets the profile property value. The profile property
     * @return BatchScrapeRequest_profile|null
    */
    public function getProfile(): ?BatchScrapeRequest_profile {
        return $this->profile;
    }

    /**
     * Gets the scroll_steps property value. The scroll_steps property
     * @return int|null
    */
    public function getScrollSteps(): ?int {
        return $this->scroll_steps;
    }

    /**
     * Gets the scroll_to_bottom property value. The scroll_to_bottom property
     * @return bool|null
    */
    public function getScrollToBottom(): ?bool {
        return $this->scroll_to_bottom;
    }

    /**
     * Gets the urls property value. The urls property
     * @return array<string>|null
    */
    public function getUrls(): ?array {
        return $this->urls;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('behavior_actions', $this->getBehaviorActions());
        $writer->writeIntegerValue('concurrency', $this->getConcurrency());
        $writer->writeObjectValue('extraction_strategy', $this->getExtractionStrategy());
        $writer->writeObjectValue('identity_country', $this->getIdentityCountry());
        $writer->writeObjectValue('language', $this->getLanguage());
        $writer->writeEnumValue('output_format', $this->getOutputFormat());
        $writer->writeObjectValue('profile', $this->getProfile());
        $writer->writeIntegerValue('scroll_steps', $this->getScrollSteps());
        $writer->writeBooleanValue('scroll_to_bottom', $this->getScrollToBottom());
        $writer->writeCollectionOfPrimitiveValues('urls', $this->getUrls());
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
     * Sets the behavior_actions property value. The behavior_actions property
     * @param BatchScrapeRequest_behavior_actions|null $value Value to set for the behavior_actions property.
    */
    public function setBehaviorActions(?BatchScrapeRequest_behavior_actions $value): void {
        $this->behavior_actions = $value;
    }

    /**
     * Sets the concurrency property value. The concurrency property
     * @param int|null $value Value to set for the concurrency property.
    */
    public function setConcurrency(?int $value): void {
        $this->concurrency = $value;
    }

    /**
     * Sets the extraction_strategy property value. The extraction_strategy property
     * @param BatchScrapeRequest_extraction_strategy|null $value Value to set for the extraction_strategy property.
    */
    public function setExtractionStrategy(?BatchScrapeRequest_extraction_strategy $value): void {
        $this->extraction_strategy = $value;
    }

    /**
     * Sets the identity_country property value. The identity_country property
     * @param BatchScrapeRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?BatchScrapeRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the language property value. The language property
     * @param BatchScrapeRequest_language|null $value Value to set for the language property.
    */
    public function setLanguage(?BatchScrapeRequest_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the output_format property value. The output_format property
     * @param BatchScrapeRequest_output_format|null $value Value to set for the output_format property.
    */
    public function setOutputFormat(?BatchScrapeRequest_output_format $value): void {
        $this->output_format = $value;
    }

    /**
     * Sets the profile property value. The profile property
     * @param BatchScrapeRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?BatchScrapeRequest_profile $value): void {
        $this->profile = $value;
    }

    /**
     * Sets the scroll_steps property value. The scroll_steps property
     * @param int|null $value Value to set for the scroll_steps property.
    */
    public function setScrollSteps(?int $value): void {
        $this->scroll_steps = $value;
    }

    /**
     * Sets the scroll_to_bottom property value. The scroll_to_bottom property
     * @param bool|null $value Value to set for the scroll_to_bottom property.
    */
    public function setScrollToBottom(?bool $value): void {
        $this->scroll_to_bottom = $value;
    }

    /**
     * Sets the urls property value. The urls property
     * @param array<string>|null $value Value to set for the urls property.
    */
    public function setUrls(?array $value): void {
        $this->urls = $value;
    }

}
