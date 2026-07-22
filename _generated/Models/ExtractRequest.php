<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/extract request body, schema-driven extraction (deterministic) + bring-your-own-model extraction. Two extraction modes: - Deterministic (default, model_provider absent): CSS/regex/keyword extraction. Requires 'schema'. Returns {"url","data","token_estimate"}. - Bring-your-own-model (model_provider present): GhostCrawl fetches and prepares clean Markdown; your connected model performs the semantic extraction (you are not billed for model inference here, only the request quota). Returns {"urls","data","token_estimate"}. Security notes:- The 'schema' field is validated before any fetch (fail-fast input guard).- URLs are validated against private, loopback, and metadata targets before any fetch.- Error responses never echo the schema body, fetched content, or model credentials.- model_provider.api_key is request-scoped only: never persisted, logged, or returned in any response body or error message.
*/
class ExtractRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ExtractRequest_behavior_actions|null $behavior_actions BYO behavior: trusted-input actions replayed on the loaded page instead of the built-in human session. Sanitized + bounded server-side (max 256 actions). Available on every tier.
    */
    private ?ExtractRequest_behavior_actions $behavior_actions = null;
    
    /**
     * @var ExtractRequest_engine|null $engine Engine override: auto (default) | chrome | firefox | webkit.
    */
    private ?ExtractRequest_engine $engine = null;
    
    /**
     * @var ExtractRequest_identity_country|null $identity_country Optional two-letter country code to pin (geo-filters the exit and derives timezone; tier-gated). Omitted = timezone follows the exit.
    */
    private ?ExtractRequest_identity_country $identity_country = null;
    
    /**
     * @var ExtractRequest_language|null $language Optional browser language tag (e.g. 'en-US','es-ES'). Sets the identity's locale and language headers coherently, independent of the exit country. Available on every tier.
    */
    private ?ExtractRequest_language $language = null;
    
    /**
     * @var ExtractRequest_prompt|null $prompt Free-form extraction instruction for BYO-LLM mode. Allowed without a schema (schema-less prose extraction). Ignored in deterministic mode (model_provider absent).
    */
    private ?ExtractRequest_prompt $prompt = null;
    
    /**
     * @var ExtractRequest_url|null $url URL to fetch and extract from (single-URL mode). Required when 'urls' is not provided.
    */
    private ?ExtractRequest_url $url = null;
    
    /**
     * @var ExtractRequest_urls|null $urls Multi-URL cross-page aggregation (bring-your-own-model mode only). Each URL is fetched and converted to clean Markdown, then concatenated with per-URL delimiter headers; one aggregated model call extracts across all pages. Bounded to ≤10 URLs. Cannot be combined with 'url' when both are provided.
    */
    private ?ExtractRequest_urls $urls = null;
    
    /**
     * Instantiates a new ExtractRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setEngine(new ExtractRequest_engine('auto'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest {
        return new ExtractRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the behavior_actions property value. BYO behavior: trusted-input actions replayed on the loaded page instead of the built-in human session. Sanitized + bounded server-side (max 256 actions). Available on every tier.
     * @return ExtractRequest_behavior_actions|null
    */
    public function getBehaviorActions(): ?ExtractRequest_behavior_actions {
        return $this->behavior_actions;
    }

    /**
     * Gets the engine property value. Engine override: auto (default) | chrome | firefox | webkit.
     * @return ExtractRequest_engine|null
    */
    public function getEngine(): ?ExtractRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'behavior_actions' => fn(ParseNode $n) => $o->setBehaviorActions($n->getObjectValue([ExtractRequest_behavior_actions::class, 'createFromDiscriminatorValue'])),
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(ExtractRequest_engine::class)),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([ExtractRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getObjectValue([ExtractRequest_language::class, 'createFromDiscriminatorValue'])),
            'prompt' => fn(ParseNode $n) => $o->setPrompt($n->getObjectValue([ExtractRequest_prompt::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getObjectValue([ExtractRequest_url::class, 'createFromDiscriminatorValue'])),
            'urls' => fn(ParseNode $n) => $o->setUrls($n->getObjectValue([ExtractRequest_urls::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the identity_country property value. Optional two-letter country code to pin (geo-filters the exit and derives timezone; tier-gated). Omitted = timezone follows the exit.
     * @return ExtractRequest_identity_country|null
    */
    public function getIdentityCountry(): ?ExtractRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the language property value. Optional browser language tag (e.g. 'en-US','es-ES'). Sets the identity's locale and language headers coherently, independent of the exit country. Available on every tier.
     * @return ExtractRequest_language|null
    */
    public function getLanguage(): ?ExtractRequest_language {
        return $this->language;
    }

    /**
     * Gets the prompt property value. Free-form extraction instruction for BYO-LLM mode. Allowed without a schema (schema-less prose extraction). Ignored in deterministic mode (model_provider absent).
     * @return ExtractRequest_prompt|null
    */
    public function getPrompt(): ?ExtractRequest_prompt {
        return $this->prompt;
    }

    /**
     * Gets the url property value. URL to fetch and extract from (single-URL mode). Required when 'urls' is not provided.
     * @return ExtractRequest_url|null
    */
    public function getUrl(): ?ExtractRequest_url {
        return $this->url;
    }

    /**
     * Gets the urls property value. Multi-URL cross-page aggregation (bring-your-own-model mode only). Each URL is fetched and converted to clean Markdown, then concatenated with per-URL delimiter headers; one aggregated model call extracts across all pages. Bounded to ≤10 URLs. Cannot be combined with 'url' when both are provided.
     * @return ExtractRequest_urls|null
    */
    public function getUrls(): ?ExtractRequest_urls {
        return $this->urls;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('behavior_actions', $this->getBehaviorActions());
        $writer->writeEnumValue('engine', $this->getEngine());
        $writer->writeObjectValue('identity_country', $this->getIdentityCountry());
        $writer->writeObjectValue('language', $this->getLanguage());
        $writer->writeObjectValue('prompt', $this->getPrompt());
        $writer->writeObjectValue('url', $this->getUrl());
        $writer->writeObjectValue('urls', $this->getUrls());
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
     * Sets the behavior_actions property value. BYO behavior: trusted-input actions replayed on the loaded page instead of the built-in human session. Sanitized + bounded server-side (max 256 actions). Available on every tier.
     * @param ExtractRequest_behavior_actions|null $value Value to set for the behavior_actions property.
    */
    public function setBehaviorActions(?ExtractRequest_behavior_actions $value): void {
        $this->behavior_actions = $value;
    }

    /**
     * Sets the engine property value. Engine override: auto (default) | chrome | firefox | webkit.
     * @param ExtractRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?ExtractRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the identity_country property value. Optional two-letter country code to pin (geo-filters the exit and derives timezone; tier-gated). Omitted = timezone follows the exit.
     * @param ExtractRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?ExtractRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the language property value. Optional browser language tag (e.g. 'en-US','es-ES'). Sets the identity's locale and language headers coherently, independent of the exit country. Available on every tier.
     * @param ExtractRequest_language|null $value Value to set for the language property.
    */
    public function setLanguage(?ExtractRequest_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the prompt property value. Free-form extraction instruction for BYO-LLM mode. Allowed without a schema (schema-less prose extraction). Ignored in deterministic mode (model_provider absent).
     * @param ExtractRequest_prompt|null $value Value to set for the prompt property.
    */
    public function setPrompt(?ExtractRequest_prompt $value): void {
        $this->prompt = $value;
    }

    /**
     * Sets the url property value. URL to fetch and extract from (single-URL mode). Required when 'urls' is not provided.
     * @param ExtractRequest_url|null $value Value to set for the url property.
    */
    public function setUrl(?ExtractRequest_url $value): void {
        $this->url = $value;
    }

    /**
     * Sets the urls property value. Multi-URL cross-page aggregation (bring-your-own-model mode only). Each URL is fetched and converted to clean Markdown, then concatenated with per-URL delimiter headers; one aggregated model call extracts across all pages. Bounded to ≤10 URLs. Cannot be combined with 'url' when both are provided.
     * @param ExtractRequest_urls|null $value Value to set for the urls property.
    */
    public function setUrls(?ExtractRequest_urls $value): void {
        $this->urls = $value;
    }

}
