<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/content request body, render a URL and return its content.
*/
class ContentRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ContentRequest_engine|null $engine Engine override (content works on every engine).
    */
    private ?ContentRequest_engine $engine = null;
    
    /**
     * @var ContentRequest_format|null $format Content format: rendered post-JS 'html' (default) or 'markdown'.
    */
    private ?ContentRequest_format $format = null;
    
    /**
     * @var ContentRequest_identity|null $identity Re-use a persisted identity.
    */
    private ?ContentRequest_identity $identity = null;
    
    /**
     * @var ContentRequest_identity_country|null $identity_country Two-letter country code to pin the exit country.
    */
    private ?ContentRequest_identity_country $identity_country = null;
    
    /**
     * @var ContentRequest_language|null $language Browser language tag override (e.g. 'en-US').
    */
    private ?ContentRequest_language $language = null;
    
    /**
     * @var ContentRequest_profile|null $profile Named persistent profile.
    */
    private ?ContentRequest_profile $profile = null;
    
    /**
     * @var ContentRequest_proxy|null $proxy Override proxy URL for this request.
    */
    private ?ContentRequest_proxy $proxy = null;
    
    /**
     * @var string|null $url URL to render and return content for.
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new ContentRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setEngine(new ContentRequest_engine('auto'));
        $this->setFormat(new ContentRequest_format('html'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ContentRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ContentRequest {
        return new ContentRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the engine property value. Engine override (content works on every engine).
     * @return ContentRequest_engine|null
    */
    public function getEngine(): ?ContentRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(ContentRequest_engine::class)),
            'format' => fn(ParseNode $n) => $o->setFormat($n->getEnumValue(ContentRequest_format::class)),
            'identity' => fn(ParseNode $n) => $o->setIdentity($n->getObjectValue([ContentRequest_identity::class, 'createFromDiscriminatorValue'])),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([ContentRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getObjectValue([ContentRequest_language::class, 'createFromDiscriminatorValue'])),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([ContentRequest_profile::class, 'createFromDiscriminatorValue'])),
            'proxy' => fn(ParseNode $n) => $o->setProxy($n->getObjectValue([ContentRequest_proxy::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the format property value. Content format: rendered post-JS 'html' (default) or 'markdown'.
     * @return ContentRequest_format|null
    */
    public function getFormat(): ?ContentRequest_format {
        return $this->format;
    }

    /**
     * Gets the identity property value. Re-use a persisted identity.
     * @return ContentRequest_identity|null
    */
    public function getIdentity(): ?ContentRequest_identity {
        return $this->identity;
    }

    /**
     * Gets the identity_country property value. Two-letter country code to pin the exit country.
     * @return ContentRequest_identity_country|null
    */
    public function getIdentityCountry(): ?ContentRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the language property value. Browser language tag override (e.g. 'en-US').
     * @return ContentRequest_language|null
    */
    public function getLanguage(): ?ContentRequest_language {
        return $this->language;
    }

    /**
     * Gets the profile property value. Named persistent profile.
     * @return ContentRequest_profile|null
    */
    public function getProfile(): ?ContentRequest_profile {
        return $this->profile;
    }

    /**
     * Gets the proxy property value. Override proxy URL for this request.
     * @return ContentRequest_proxy|null
    */
    public function getProxy(): ?ContentRequest_proxy {
        return $this->proxy;
    }

    /**
     * Gets the url property value. URL to render and return content for.
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
        $writer->writeEnumValue('format', $this->getFormat());
        $writer->writeObjectValue('identity', $this->getIdentity());
        $writer->writeObjectValue('identity_country', $this->getIdentityCountry());
        $writer->writeObjectValue('language', $this->getLanguage());
        $writer->writeObjectValue('profile', $this->getProfile());
        $writer->writeObjectValue('proxy', $this->getProxy());
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
     * Sets the engine property value. Engine override (content works on every engine).
     * @param ContentRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?ContentRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the format property value. Content format: rendered post-JS 'html' (default) or 'markdown'.
     * @param ContentRequest_format|null $value Value to set for the format property.
    */
    public function setFormat(?ContentRequest_format $value): void {
        $this->format = $value;
    }

    /**
     * Sets the identity property value. Re-use a persisted identity.
     * @param ContentRequest_identity|null $value Value to set for the identity property.
    */
    public function setIdentity(?ContentRequest_identity $value): void {
        $this->identity = $value;
    }

    /**
     * Sets the identity_country property value. Two-letter country code to pin the exit country.
     * @param ContentRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?ContentRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the language property value. Browser language tag override (e.g. 'en-US').
     * @param ContentRequest_language|null $value Value to set for the language property.
    */
    public function setLanguage(?ContentRequest_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the profile property value. Named persistent profile.
     * @param ContentRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?ContentRequest_profile $value): void {
        $this->profile = $value;
    }

    /**
     * Sets the proxy property value. Override proxy URL for this request.
     * @param ContentRequest_proxy|null $value Value to set for the proxy property.
    */
    public function setProxy(?ContentRequest_proxy $value): void {
        $this->proxy = $value;
    }

    /**
     * Sets the url property value. URL to render and return content for.
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
