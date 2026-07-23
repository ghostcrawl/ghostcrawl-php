<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/screenshot request body, capture a URL to a PNG screenshot.
*/
class ScreenshotRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ScreenshotRequest_engine|null $engine Engine override (screenshot works on every engine).
    */
    private ?ScreenshotRequest_engine $engine = null;
    
    /**
     * @var bool|null $full_page Capture the FULL document height instead of just the viewport.
    */
    private ?bool $full_page = null;
    
    /**
     * @var ScreenshotRequest_identity|null $identity Re-use a persisted identity.
    */
    private ?ScreenshotRequest_identity $identity = null;
    
    /**
     * @var ScreenshotRequest_identity_country|null $identity_country Two-letter country code to pin the exit country.
    */
    private ?ScreenshotRequest_identity_country $identity_country = null;
    
    /**
     * @var ScreenshotRequest_language|null $language Browser language tag override (e.g. 'en-US').
    */
    private ?ScreenshotRequest_language $language = null;
    
    /**
     * @var ScreenshotRequest_profile|null $profile Named persistent profile.
    */
    private ?ScreenshotRequest_profile $profile = null;
    
    /**
     * @var ScreenshotRequest_proxy|null $proxy Override proxy URL for this request.
    */
    private ?ScreenshotRequest_proxy $proxy = null;
    
    /**
     * @var ScreenshotRequest_screenshot_selector|null $screenshot_selector Clip to the first DOM element matching this CSS selector (element screenshot).
    */
    private ?ScreenshotRequest_screenshot_selector $screenshot_selector = null;
    
    /**
     * @var string|null $url URL to capture.
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new ScreenshotRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setEngine(new ScreenshotRequest_engine('auto'));
        $this->setFullPage(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScreenshotRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScreenshotRequest {
        return new ScreenshotRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the engine property value. Engine override (screenshot works on every engine).
     * @return ScreenshotRequest_engine|null
    */
    public function getEngine(): ?ScreenshotRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(ScreenshotRequest_engine::class)),
            'full_page' => fn(ParseNode $n) => $o->setFullPage($n->getBooleanValue()),
            'identity' => fn(ParseNode $n) => $o->setIdentity($n->getObjectValue([ScreenshotRequest_identity::class, 'createFromDiscriminatorValue'])),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([ScreenshotRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getObjectValue([ScreenshotRequest_language::class, 'createFromDiscriminatorValue'])),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([ScreenshotRequest_profile::class, 'createFromDiscriminatorValue'])),
            'proxy' => fn(ParseNode $n) => $o->setProxy($n->getObjectValue([ScreenshotRequest_proxy::class, 'createFromDiscriminatorValue'])),
            'screenshot_selector' => fn(ParseNode $n) => $o->setScreenshotSelector($n->getObjectValue([ScreenshotRequest_screenshot_selector::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the full_page property value. Capture the FULL document height instead of just the viewport.
     * @return bool|null
    */
    public function getFullPage(): ?bool {
        return $this->full_page;
    }

    /**
     * Gets the identity property value. Re-use a persisted identity.
     * @return ScreenshotRequest_identity|null
    */
    public function getIdentity(): ?ScreenshotRequest_identity {
        return $this->identity;
    }

    /**
     * Gets the identity_country property value. Two-letter country code to pin the exit country.
     * @return ScreenshotRequest_identity_country|null
    */
    public function getIdentityCountry(): ?ScreenshotRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the language property value. Browser language tag override (e.g. 'en-US').
     * @return ScreenshotRequest_language|null
    */
    public function getLanguage(): ?ScreenshotRequest_language {
        return $this->language;
    }

    /**
     * Gets the profile property value. Named persistent profile.
     * @return ScreenshotRequest_profile|null
    */
    public function getProfile(): ?ScreenshotRequest_profile {
        return $this->profile;
    }

    /**
     * Gets the proxy property value. Override proxy URL for this request.
     * @return ScreenshotRequest_proxy|null
    */
    public function getProxy(): ?ScreenshotRequest_proxy {
        return $this->proxy;
    }

    /**
     * Gets the screenshot_selector property value. Clip to the first DOM element matching this CSS selector (element screenshot).
     * @return ScreenshotRequest_screenshot_selector|null
    */
    public function getScreenshotSelector(): ?ScreenshotRequest_screenshot_selector {
        return $this->screenshot_selector;
    }

    /**
     * Gets the url property value. URL to capture.
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
        $writer->writeEnumValue('engine', $this->getEngine());
        $writer->writeBooleanValue('full_page', $this->getFullPage());
        $writer->writeObjectValue('identity', $this->getIdentity());
        $writer->writeObjectValue('identity_country', $this->getIdentityCountry());
        $writer->writeObjectValue('language', $this->getLanguage());
        $writer->writeObjectValue('profile', $this->getProfile());
        $writer->writeObjectValue('proxy', $this->getProxy());
        $writer->writeObjectValue('screenshot_selector', $this->getScreenshotSelector());
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
     * Sets the engine property value. Engine override (screenshot works on every engine).
     * @param ScreenshotRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?ScreenshotRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the full_page property value. Capture the FULL document height instead of just the viewport.
     * @param bool|null $value Value to set for the full_page property.
    */
    public function setFullPage(?bool $value): void {
        $this->full_page = $value;
    }

    /**
     * Sets the identity property value. Re-use a persisted identity.
     * @param ScreenshotRequest_identity|null $value Value to set for the identity property.
    */
    public function setIdentity(?ScreenshotRequest_identity $value): void {
        $this->identity = $value;
    }

    /**
     * Sets the identity_country property value. Two-letter country code to pin the exit country.
     * @param ScreenshotRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?ScreenshotRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the language property value. Browser language tag override (e.g. 'en-US').
     * @param ScreenshotRequest_language|null $value Value to set for the language property.
    */
    public function setLanguage(?ScreenshotRequest_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the profile property value. Named persistent profile.
     * @param ScreenshotRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?ScreenshotRequest_profile $value): void {
        $this->profile = $value;
    }

    /**
     * Sets the proxy property value. Override proxy URL for this request.
     * @param ScreenshotRequest_proxy|null $value Value to set for the proxy property.
    */
    public function setProxy(?ScreenshotRequest_proxy $value): void {
        $this->proxy = $value;
    }

    /**
     * Sets the screenshot_selector property value. Clip to the first DOM element matching this CSS selector (element screenshot).
     * @param ScreenshotRequest_screenshot_selector|null $value Value to set for the screenshot_selector property.
    */
    public function setScreenshotSelector(?ScreenshotRequest_screenshot_selector $value): void {
        $this->screenshot_selector = $value;
    }

    /**
     * Sets the url property value. URL to capture.
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
