<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/scrape request body (-03 identity-aware shape).
*/
class ScrapeRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ScrapeRequest_batch_identity_mode|null $batch_identity_mode "persist" (default): same identity for all URLs in a batch. "randomize": fresh identity per URL (each counts against quota).
    */
    private ?ScrapeRequest_batch_identity_mode $batch_identity_mode = null;
    
    /**
     * @var ScrapeRequest_behavior_actions|null $behavior_actions BYO behavior: a list of trusted-input actions replayed on the loaded page instead of the built-in human session. Each item is {"kind":"move","x":int,"y":int} | {"kind":"wheel","x":int,"y":int,"dy":int} | {"kind":"dwell","ms":int}. Sanitized + bounded server-side (max 256 actions). Available on every tier.
    */
    private ?ScrapeRequest_behavior_actions $behavior_actions = null;
    
    /**
     * @var int|null $chunk_tokens Maximum tokens per markdown chunk. Clamped server-side to [256, 32768] regardless of caller input.
    */
    private ?int $chunk_tokens = null;
    
    /**
     * @var ScrapeRequest_engine|null $engine Engine override. 'auto' (default): the identity's fingerprint decides the engine. 'chrome'|'firefox'|'webkit': force that engine, enforced only if coherent with the identity (e.g. iOS identities are always webkit); incoherent picks are rejected, never coerced to a hybrid.
    */
    private ?ScrapeRequest_engine $engine = null;
    
    /**
     * @var ScrapeRequest_format|null $format Response format. 'html' (default): the fully rendered DOM. 'markdown': returns a {markdown, chunks, citations, token_estimate} envelope with prompt-injection-neutralized, token-budgeted output. 'pdf': returns application/pdf bytes (Chrome identities only; Firefox and WebKit return 400 pdf_engine_unsupported).
    */
    private ?ScrapeRequest_format $format = null;
    
    /**
     * @var bool|null $full_page When screenshot=true, capture the FULL document height instead of just the visible viewport. Ignored when screenshot_selector is set.
    */
    private ?bool $full_page = null;
    
    /**
     * @var ScrapeRequest_identity|null $identity Previously-persisted identity_id from POST /v1/identity (persist=true).
    */
    private ?ScrapeRequest_identity $identity = null;
    
    /**
     * @var ScrapeRequest_identity_country|null $identity_country Optional two-letter country code (e.g. 'US','DE'). When set, the exit is geo-filtered to that country and the identity's timezone is derived from it. When omitted, the timezone follows the rotating exit country. Language is independent, see the `language` field.
    */
    private ?ScrapeRequest_identity_country $identity_country = null;
    
    /**
     * @var bool|null $include_citations When format=markdown, include deduplicated citation list {url, anchor_text} from the scraped page.
    */
    private ?bool $include_citations = null;
    
    /**
     * @var ScrapeRequest_language|null $language Optional browser language tag (e.g. 'en-US','es-ES','de-DE'). Sets the identity's locale and language headers coherently, independent of the exit country. When omitted, the identity's default locale is used. Available on every tier.
    */
    private ?ScrapeRequest_language $language = null;
    
    /**
     * @var ScrapeRequest_profile|null $profile Named persistent profile (multi-accounting). Resolves to a durable identity_id (→ same deterministic fingerprint) + optional saved storage_state (→ cookies/localStorage) for the calling org. Reuses the exact identity+cookies on every request, with no 30-minute sticky-session expiry. 404 if the named profile does not exist for the org.
    */
    private ?ScrapeRequest_profile $profile = null;
    
    /**
     * @var ScrapeRequest_proxy|null $proxy Bring-your-own proxy URL. Schemes: socks5, socks5h, http, https. Any credentials in the URL are redacted from logs. Example: socks5://user:pass@host:1080.
    */
    private ?ScrapeRequest_proxy $proxy = null;
    
    /**
     * @var ScrapeRequest_routing_mode|null $routing_mode Routing mode. auto (default) = we pick the cheapest network that succeeds and automatically escalate on a block. standard = normal targets only. premium = always use our premium network. Most callers should leave this at auto.
    */
    private ?ScrapeRequest_routing_mode $routing_mode = null;
    
    /**
     * @var bool|null $screenshot When true, a screenshot is captured during the fetch and returned as a base64-encoded PNG in result['screenshot']. Off by default.
    */
    private ?bool $screenshot = null;
    
    /**
     * @var ScrapeRequest_screenshot_selector|null $screenshot_selector When screenshot=true, clip the capture to the first DOM element matching this CSS selector (element screenshot). Takes precedence over full_page.
    */
    private ?ScrapeRequest_screenshot_selector $screenshot_selector = null;
    
    /**
     * @var ScrapeRequest_session|null $session Sticky-session token (paid tiers). Requests sharing a token reuse the same identity → same exit + cookies (returning-visitor coherence). Bounded TTL; opaque [A-Za-z0-9._-], max 128 chars.
    */
    private ?ScrapeRequest_session $session = null;
    
    /**
     * @var bool|null $stream When true, returns text/event-stream with one SSE event per chunk. Per-tenant concurrency is capped (default 5). Final 'done' event carries estimated_llm_input_tokens.
    */
    private ?bool $stream = null;
    
    /**
     * @var ScrapeRequest_timeout_ms|null $timeout_ms Optional per-request timeout in milliseconds. Clamped server-side to ≤120000 ms (120s); values outside [0, 120000] are rejected (422).
    */
    private ?ScrapeRequest_timeout_ms $timeout_ms = null;
    
    /**
     * @var ScrapeRequest_url|null $url The url property
    */
    private ?ScrapeRequest_url $url = null;
    
    /**
     * @var ScrapeRequest_urls|null $urls The urls property
    */
    private ?ScrapeRequest_urls $urls = null;
    
    /**
     * Instantiates a new ScrapeRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setBatchIdentityMode(new ScrapeRequest_batch_identity_mode('persist'));
        $this->setChunkTokens(8192);
        $this->setEngine(new ScrapeRequest_engine('auto'));
        $this->setFormat(new ScrapeRequest_format('html'));
        $this->setFullPage(false);
        $this->setIncludeCitations(true);
        $this->setRoutingMode(new ScrapeRequest_routing_mode('auto'));
        $this->setScreenshot(false);
        $this->setStream(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest {
        return new ScrapeRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the batch_identity_mode property value. "persist" (default): same identity for all URLs in a batch. "randomize": fresh identity per URL (each counts against quota).
     * @return ScrapeRequest_batch_identity_mode|null
    */
    public function getBatchIdentityMode(): ?ScrapeRequest_batch_identity_mode {
        return $this->batch_identity_mode;
    }

    /**
     * Gets the behavior_actions property value. BYO behavior: a list of trusted-input actions replayed on the loaded page instead of the built-in human session. Each item is {"kind":"move","x":int,"y":int} | {"kind":"wheel","x":int,"y":int,"dy":int} | {"kind":"dwell","ms":int}. Sanitized + bounded server-side (max 256 actions). Available on every tier.
     * @return ScrapeRequest_behavior_actions|null
    */
    public function getBehaviorActions(): ?ScrapeRequest_behavior_actions {
        return $this->behavior_actions;
    }

    /**
     * Gets the chunk_tokens property value. Maximum tokens per markdown chunk. Clamped server-side to [256, 32768] regardless of caller input.
     * @return int|null
    */
    public function getChunkTokens(): ?int {
        return $this->chunk_tokens;
    }

    /**
     * Gets the engine property value. Engine override. 'auto' (default): the identity's fingerprint decides the engine. 'chrome'|'firefox'|'webkit': force that engine, enforced only if coherent with the identity (e.g. iOS identities are always webkit); incoherent picks are rejected, never coerced to a hybrid.
     * @return ScrapeRequest_engine|null
    */
    public function getEngine(): ?ScrapeRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'batch_identity_mode' => fn(ParseNode $n) => $o->setBatchIdentityMode($n->getEnumValue(ScrapeRequest_batch_identity_mode::class)),
            'behavior_actions' => fn(ParseNode $n) => $o->setBehaviorActions($n->getObjectValue([ScrapeRequest_behavior_actions::class, 'createFromDiscriminatorValue'])),
            'chunk_tokens' => fn(ParseNode $n) => $o->setChunkTokens($n->getIntegerValue()),
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(ScrapeRequest_engine::class)),
            'format' => fn(ParseNode $n) => $o->setFormat($n->getEnumValue(ScrapeRequest_format::class)),
            'full_page' => fn(ParseNode $n) => $o->setFullPage($n->getBooleanValue()),
            'identity' => fn(ParseNode $n) => $o->setIdentity($n->getObjectValue([ScrapeRequest_identity::class, 'createFromDiscriminatorValue'])),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([ScrapeRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'include_citations' => fn(ParseNode $n) => $o->setIncludeCitations($n->getBooleanValue()),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getObjectValue([ScrapeRequest_language::class, 'createFromDiscriminatorValue'])),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([ScrapeRequest_profile::class, 'createFromDiscriminatorValue'])),
            'proxy' => fn(ParseNode $n) => $o->setProxy($n->getObjectValue([ScrapeRequest_proxy::class, 'createFromDiscriminatorValue'])),
            'routing_mode' => fn(ParseNode $n) => $o->setRoutingMode($n->getEnumValue(ScrapeRequest_routing_mode::class)),
            'screenshot' => fn(ParseNode $n) => $o->setScreenshot($n->getBooleanValue()),
            'screenshot_selector' => fn(ParseNode $n) => $o->setScreenshotSelector($n->getObjectValue([ScrapeRequest_screenshot_selector::class, 'createFromDiscriminatorValue'])),
            'session' => fn(ParseNode $n) => $o->setSession($n->getObjectValue([ScrapeRequest_session::class, 'createFromDiscriminatorValue'])),
            'stream' => fn(ParseNode $n) => $o->setStream($n->getBooleanValue()),
            'timeout_ms' => fn(ParseNode $n) => $o->setTimeoutMs($n->getObjectValue([ScrapeRequest_timeout_ms::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getObjectValue([ScrapeRequest_url::class, 'createFromDiscriminatorValue'])),
            'urls' => fn(ParseNode $n) => $o->setUrls($n->getObjectValue([ScrapeRequest_urls::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the format property value. Response format. 'html' (default): the fully rendered DOM. 'markdown': returns a {markdown, chunks, citations, token_estimate} envelope with prompt-injection-neutralized, token-budgeted output. 'pdf': returns application/pdf bytes (Chrome identities only; Firefox and WebKit return 400 pdf_engine_unsupported).
     * @return ScrapeRequest_format|null
    */
    public function getFormat(): ?ScrapeRequest_format {
        return $this->format;
    }

    /**
     * Gets the full_page property value. When screenshot=true, capture the FULL document height instead of just the visible viewport. Ignored when screenshot_selector is set.
     * @return bool|null
    */
    public function getFullPage(): ?bool {
        return $this->full_page;
    }

    /**
     * Gets the identity property value. Previously-persisted identity_id from POST /v1/identity (persist=true).
     * @return ScrapeRequest_identity|null
    */
    public function getIdentity(): ?ScrapeRequest_identity {
        return $this->identity;
    }

    /**
     * Gets the identity_country property value. Optional two-letter country code (e.g. 'US','DE'). When set, the exit is geo-filtered to that country and the identity's timezone is derived from it. When omitted, the timezone follows the rotating exit country. Language is independent, see the `language` field.
     * @return ScrapeRequest_identity_country|null
    */
    public function getIdentityCountry(): ?ScrapeRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the include_citations property value. When format=markdown, include deduplicated citation list {url, anchor_text} from the scraped page.
     * @return bool|null
    */
    public function getIncludeCitations(): ?bool {
        return $this->include_citations;
    }

    /**
     * Gets the language property value. Optional browser language tag (e.g. 'en-US','es-ES','de-DE'). Sets the identity's locale and language headers coherently, independent of the exit country. When omitted, the identity's default locale is used. Available on every tier.
     * @return ScrapeRequest_language|null
    */
    public function getLanguage(): ?ScrapeRequest_language {
        return $this->language;
    }

    /**
     * Gets the profile property value. Named persistent profile (multi-accounting). Resolves to a durable identity_id (→ same deterministic fingerprint) + optional saved storage_state (→ cookies/localStorage) for the calling org. Reuses the exact identity+cookies on every request, with no 30-minute sticky-session expiry. 404 if the named profile does not exist for the org.
     * @return ScrapeRequest_profile|null
    */
    public function getProfile(): ?ScrapeRequest_profile {
        return $this->profile;
    }

    /**
     * Gets the proxy property value. Bring-your-own proxy URL. Schemes: socks5, socks5h, http, https. Any credentials in the URL are redacted from logs. Example: socks5://user:pass@host:1080.
     * @return ScrapeRequest_proxy|null
    */
    public function getProxy(): ?ScrapeRequest_proxy {
        return $this->proxy;
    }

    /**
     * Gets the routing_mode property value. Routing mode. auto (default) = we pick the cheapest network that succeeds and automatically escalate on a block. standard = normal targets only. premium = always use our premium network. Most callers should leave this at auto.
     * @return ScrapeRequest_routing_mode|null
    */
    public function getRoutingMode(): ?ScrapeRequest_routing_mode {
        return $this->routing_mode;
    }

    /**
     * Gets the screenshot property value. When true, a screenshot is captured during the fetch and returned as a base64-encoded PNG in result['screenshot']. Off by default.
     * @return bool|null
    */
    public function getScreenshot(): ?bool {
        return $this->screenshot;
    }

    /**
     * Gets the screenshot_selector property value. When screenshot=true, clip the capture to the first DOM element matching this CSS selector (element screenshot). Takes precedence over full_page.
     * @return ScrapeRequest_screenshot_selector|null
    */
    public function getScreenshotSelector(): ?ScrapeRequest_screenshot_selector {
        return $this->screenshot_selector;
    }

    /**
     * Gets the session property value. Sticky-session token (paid tiers). Requests sharing a token reuse the same identity → same exit + cookies (returning-visitor coherence). Bounded TTL; opaque [A-Za-z0-9._-], max 128 chars.
     * @return ScrapeRequest_session|null
    */
    public function getSession(): ?ScrapeRequest_session {
        return $this->session;
    }

    /**
     * Gets the stream property value. When true, returns text/event-stream with one SSE event per chunk. Per-tenant concurrency is capped (default 5). Final 'done' event carries estimated_llm_input_tokens.
     * @return bool|null
    */
    public function getStream(): ?bool {
        return $this->stream;
    }

    /**
     * Gets the timeout_ms property value. Optional per-request timeout in milliseconds. Clamped server-side to ≤120000 ms (120s); values outside [0, 120000] are rejected (422).
     * @return ScrapeRequest_timeout_ms|null
    */
    public function getTimeoutMs(): ?ScrapeRequest_timeout_ms {
        return $this->timeout_ms;
    }

    /**
     * Gets the url property value. The url property
     * @return ScrapeRequest_url|null
    */
    public function getUrl(): ?ScrapeRequest_url {
        return $this->url;
    }

    /**
     * Gets the urls property value. The urls property
     * @return ScrapeRequest_urls|null
    */
    public function getUrls(): ?ScrapeRequest_urls {
        return $this->urls;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeEnumValue('batch_identity_mode', $this->getBatchIdentityMode());
        $writer->writeObjectValue('behavior_actions', $this->getBehaviorActions());
        $writer->writeIntegerValue('chunk_tokens', $this->getChunkTokens());
        $writer->writeEnumValue('engine', $this->getEngine());
        $writer->writeEnumValue('format', $this->getFormat());
        $writer->writeBooleanValue('full_page', $this->getFullPage());
        $writer->writeObjectValue('identity', $this->getIdentity());
        $writer->writeObjectValue('identity_country', $this->getIdentityCountry());
        $writer->writeBooleanValue('include_citations', $this->getIncludeCitations());
        $writer->writeObjectValue('language', $this->getLanguage());
        $writer->writeObjectValue('profile', $this->getProfile());
        $writer->writeObjectValue('proxy', $this->getProxy());
        $writer->writeEnumValue('routing_mode', $this->getRoutingMode());
        $writer->writeBooleanValue('screenshot', $this->getScreenshot());
        $writer->writeObjectValue('screenshot_selector', $this->getScreenshotSelector());
        $writer->writeObjectValue('session', $this->getSession());
        $writer->writeBooleanValue('stream', $this->getStream());
        $writer->writeObjectValue('timeout_ms', $this->getTimeoutMs());
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
     * Sets the batch_identity_mode property value. "persist" (default): same identity for all URLs in a batch. "randomize": fresh identity per URL (each counts against quota).
     * @param ScrapeRequest_batch_identity_mode|null $value Value to set for the batch_identity_mode property.
    */
    public function setBatchIdentityMode(?ScrapeRequest_batch_identity_mode $value): void {
        $this->batch_identity_mode = $value;
    }

    /**
     * Sets the behavior_actions property value. BYO behavior: a list of trusted-input actions replayed on the loaded page instead of the built-in human session. Each item is {"kind":"move","x":int,"y":int} | {"kind":"wheel","x":int,"y":int,"dy":int} | {"kind":"dwell","ms":int}. Sanitized + bounded server-side (max 256 actions). Available on every tier.
     * @param ScrapeRequest_behavior_actions|null $value Value to set for the behavior_actions property.
    */
    public function setBehaviorActions(?ScrapeRequest_behavior_actions $value): void {
        $this->behavior_actions = $value;
    }

    /**
     * Sets the chunk_tokens property value. Maximum tokens per markdown chunk. Clamped server-side to [256, 32768] regardless of caller input.
     * @param int|null $value Value to set for the chunk_tokens property.
    */
    public function setChunkTokens(?int $value): void {
        $this->chunk_tokens = $value;
    }

    /**
     * Sets the engine property value. Engine override. 'auto' (default): the identity's fingerprint decides the engine. 'chrome'|'firefox'|'webkit': force that engine, enforced only if coherent with the identity (e.g. iOS identities are always webkit); incoherent picks are rejected, never coerced to a hybrid.
     * @param ScrapeRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?ScrapeRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the format property value. Response format. 'html' (default): the fully rendered DOM. 'markdown': returns a {markdown, chunks, citations, token_estimate} envelope with prompt-injection-neutralized, token-budgeted output. 'pdf': returns application/pdf bytes (Chrome identities only; Firefox and WebKit return 400 pdf_engine_unsupported).
     * @param ScrapeRequest_format|null $value Value to set for the format property.
    */
    public function setFormat(?ScrapeRequest_format $value): void {
        $this->format = $value;
    }

    /**
     * Sets the full_page property value. When screenshot=true, capture the FULL document height instead of just the visible viewport. Ignored when screenshot_selector is set.
     * @param bool|null $value Value to set for the full_page property.
    */
    public function setFullPage(?bool $value): void {
        $this->full_page = $value;
    }

    /**
     * Sets the identity property value. Previously-persisted identity_id from POST /v1/identity (persist=true).
     * @param ScrapeRequest_identity|null $value Value to set for the identity property.
    */
    public function setIdentity(?ScrapeRequest_identity $value): void {
        $this->identity = $value;
    }

    /**
     * Sets the identity_country property value. Optional two-letter country code (e.g. 'US','DE'). When set, the exit is geo-filtered to that country and the identity's timezone is derived from it. When omitted, the timezone follows the rotating exit country. Language is independent, see the `language` field.
     * @param ScrapeRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?ScrapeRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the include_citations property value. When format=markdown, include deduplicated citation list {url, anchor_text} from the scraped page.
     * @param bool|null $value Value to set for the include_citations property.
    */
    public function setIncludeCitations(?bool $value): void {
        $this->include_citations = $value;
    }

    /**
     * Sets the language property value. Optional browser language tag (e.g. 'en-US','es-ES','de-DE'). Sets the identity's locale and language headers coherently, independent of the exit country. When omitted, the identity's default locale is used. Available on every tier.
     * @param ScrapeRequest_language|null $value Value to set for the language property.
    */
    public function setLanguage(?ScrapeRequest_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the profile property value. Named persistent profile (multi-accounting). Resolves to a durable identity_id (→ same deterministic fingerprint) + optional saved storage_state (→ cookies/localStorage) for the calling org. Reuses the exact identity+cookies on every request, with no 30-minute sticky-session expiry. 404 if the named profile does not exist for the org.
     * @param ScrapeRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?ScrapeRequest_profile $value): void {
        $this->profile = $value;
    }

    /**
     * Sets the proxy property value. Bring-your-own proxy URL. Schemes: socks5, socks5h, http, https. Any credentials in the URL are redacted from logs. Example: socks5://user:pass@host:1080.
     * @param ScrapeRequest_proxy|null $value Value to set for the proxy property.
    */
    public function setProxy(?ScrapeRequest_proxy $value): void {
        $this->proxy = $value;
    }

    /**
     * Sets the routing_mode property value. Routing mode. auto (default) = we pick the cheapest network that succeeds and automatically escalate on a block. standard = normal targets only. premium = always use our premium network. Most callers should leave this at auto.
     * @param ScrapeRequest_routing_mode|null $value Value to set for the routing_mode property.
    */
    public function setRoutingMode(?ScrapeRequest_routing_mode $value): void {
        $this->routing_mode = $value;
    }

    /**
     * Sets the screenshot property value. When true, a screenshot is captured during the fetch and returned as a base64-encoded PNG in result['screenshot']. Off by default.
     * @param bool|null $value Value to set for the screenshot property.
    */
    public function setScreenshot(?bool $value): void {
        $this->screenshot = $value;
    }

    /**
     * Sets the screenshot_selector property value. When screenshot=true, clip the capture to the first DOM element matching this CSS selector (element screenshot). Takes precedence over full_page.
     * @param ScrapeRequest_screenshot_selector|null $value Value to set for the screenshot_selector property.
    */
    public function setScreenshotSelector(?ScrapeRequest_screenshot_selector $value): void {
        $this->screenshot_selector = $value;
    }

    /**
     * Sets the session property value. Sticky-session token (paid tiers). Requests sharing a token reuse the same identity → same exit + cookies (returning-visitor coherence). Bounded TTL; opaque [A-Za-z0-9._-], max 128 chars.
     * @param ScrapeRequest_session|null $value Value to set for the session property.
    */
    public function setSession(?ScrapeRequest_session $value): void {
        $this->session = $value;
    }

    /**
     * Sets the stream property value. When true, returns text/event-stream with one SSE event per chunk. Per-tenant concurrency is capped (default 5). Final 'done' event carries estimated_llm_input_tokens.
     * @param bool|null $value Value to set for the stream property.
    */
    public function setStream(?bool $value): void {
        $this->stream = $value;
    }

    /**
     * Sets the timeout_ms property value. Optional per-request timeout in milliseconds. Clamped server-side to ≤120000 ms (120s); values outside [0, 120000] are rejected (422).
     * @param ScrapeRequest_timeout_ms|null $value Value to set for the timeout_ms property.
    */
    public function setTimeoutMs(?ScrapeRequest_timeout_ms $value): void {
        $this->timeout_ms = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param ScrapeRequest_url|null $value Value to set for the url property.
    */
    public function setUrl(?ScrapeRequest_url $value): void {
        $this->url = $value;
    }

    /**
     * Sets the urls property value. The urls property
     * @param ScrapeRequest_urls|null $value Value to set for the urls property.
    */
    public function setUrls(?ScrapeRequest_urls $value): void {
        $this->urls = $value;
    }

}
