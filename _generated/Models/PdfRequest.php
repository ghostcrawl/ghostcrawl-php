<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/pdf request body, render a URL to PDF. Renders the target URL to a PDF document. Supported on Chrome identities; requests that resolve to a Firefox or WebKit identity return 400 pdf_engine_unsupported. Security: - The URL is validated against private/loopback/metadata targets. - All traffic egresses through your configured proxy. - Subject to your daily request quota.
*/
class PdfRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var PdfRequest_engine|null $engine Engine override. PDF is chrome-only; 'firefox' or 'webkit' returns 400 pdf_engine_unsupported immediately (before dispatch).
    */
    private ?PdfRequest_engine $engine = null;
    
    /**
     * @var PdfRequest_identity|null $identity Re-use a persisted identity.
    */
    private ?PdfRequest_identity $identity = null;
    
    /**
     * @var PdfRequest_identity_country|null $identity_country Two-letter country code to pin the exit country.
    */
    private ?PdfRequest_identity_country $identity_country = null;
    
    /**
     * @var PdfRequest_language|null $language Browser language tag override (e.g. 'en-US').
    */
    private ?PdfRequest_language $language = null;
    
    /**
     * @var PdfRequest_profile|null $profile Named persistent profile.
    */
    private ?PdfRequest_profile $profile = null;
    
    /**
     * @var PdfRequest_proxy|null $proxy Override proxy URL for this request.
    */
    private ?PdfRequest_proxy $proxy = null;
    
    /**
     * @var string|null $url URL to render as PDF.
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new PdfRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setEngine(new PdfRequest_engine('auto'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PdfRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PdfRequest {
        return new PdfRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the engine property value. Engine override. PDF is chrome-only; 'firefox' or 'webkit' returns 400 pdf_engine_unsupported immediately (before dispatch).
     * @return PdfRequest_engine|null
    */
    public function getEngine(): ?PdfRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(PdfRequest_engine::class)),
            'identity' => fn(ParseNode $n) => $o->setIdentity($n->getObjectValue([PdfRequest_identity::class, 'createFromDiscriminatorValue'])),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([PdfRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getObjectValue([PdfRequest_language::class, 'createFromDiscriminatorValue'])),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([PdfRequest_profile::class, 'createFromDiscriminatorValue'])),
            'proxy' => fn(ParseNode $n) => $o->setProxy($n->getObjectValue([PdfRequest_proxy::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the identity property value. Re-use a persisted identity.
     * @return PdfRequest_identity|null
    */
    public function getIdentity(): ?PdfRequest_identity {
        return $this->identity;
    }

    /**
     * Gets the identity_country property value. Two-letter country code to pin the exit country.
     * @return PdfRequest_identity_country|null
    */
    public function getIdentityCountry(): ?PdfRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the language property value. Browser language tag override (e.g. 'en-US').
     * @return PdfRequest_language|null
    */
    public function getLanguage(): ?PdfRequest_language {
        return $this->language;
    }

    /**
     * Gets the profile property value. Named persistent profile.
     * @return PdfRequest_profile|null
    */
    public function getProfile(): ?PdfRequest_profile {
        return $this->profile;
    }

    /**
     * Gets the proxy property value. Override proxy URL for this request.
     * @return PdfRequest_proxy|null
    */
    public function getProxy(): ?PdfRequest_proxy {
        return $this->proxy;
    }

    /**
     * Gets the url property value. URL to render as PDF.
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
     * Sets the engine property value. Engine override. PDF is chrome-only; 'firefox' or 'webkit' returns 400 pdf_engine_unsupported immediately (before dispatch).
     * @param PdfRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?PdfRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the identity property value. Re-use a persisted identity.
     * @param PdfRequest_identity|null $value Value to set for the identity property.
    */
    public function setIdentity(?PdfRequest_identity $value): void {
        $this->identity = $value;
    }

    /**
     * Sets the identity_country property value. Two-letter country code to pin the exit country.
     * @param PdfRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?PdfRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the language property value. Browser language tag override (e.g. 'en-US').
     * @param PdfRequest_language|null $value Value to set for the language property.
    */
    public function setLanguage(?PdfRequest_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the profile property value. Named persistent profile.
     * @param PdfRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?PdfRequest_profile $value): void {
        $this->profile = $value;
    }

    /**
     * Sets the proxy property value. Override proxy URL for this request.
     * @param PdfRequest_proxy|null $value Value to set for the proxy property.
    */
    public function setProxy(?PdfRequest_proxy $value): void {
        $this->proxy = $value;
    }

    /**
     * Sets the url property value. URL to render as PDF.
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
