<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Request body for POST /v1/identity. extension (single-endpoint-with-source): source="user" → BYO local path; carries the full local identity payload. source="gc_identity" → managed cloud identity (paid plan). source=None → Legacy path (operating system and browser required). For legacy path with mobile operating system values (ios, android): device_model is required. For legacy path with desktop operating system values (macos, windows, linux): viewport is required.
*/
class IdentityRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var IdentityRequest_claim_browser|null $browser The browser property
    */
    private ?IdentityRequest_claim_browser $claim_browser = null;
    
    /**
     * @var IdentityRequest_claim_os|null $operating system The operating system property
    */
    private ?IdentityRequest_claim_os $claim_os = null;
    
    /**
     * @var IdentityRequest_device_model|null $device_model The device_model property
    */
    private ?IdentityRequest_device_model $device_model = null;
    
    /**
     * @var IdentityRequest_locale|null $locale The locale property
    */
    private ?IdentityRequest_locale $locale = null;
    
    /**
     * @var bool|null $persist The persist property
    */
    private ?bool $persist = null;
    
    /**
     * @var IdentityRequest_proxy|null $proxy The proxy property
    */
    private ?IdentityRequest_proxy $proxy = null;
    
    /**
     * @var IdentityRequest_source|null $source The source property
    */
    private ?IdentityRequest_source $source = null;
    
    /**
     * @var IdentityRequest_timezone|null $timezone The timezone property
    */
    private ?IdentityRequest_timezone $timezone = null;
    
    /**
     * @var IdentityRequest_viewport|null $viewport The viewport property
    */
    private ?IdentityRequest_viewport $viewport = null;
    
    /**
     * Instantiates a new IdentityRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setPersist(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return IdentityRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): IdentityRequest {
        return new IdentityRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the browser property value. The browser property
     * @return IdentityRequest_claim_browser|null
    */
    public function getClaimBrowser(): ?IdentityRequest_claim_browser {
        return $this->claim_browser;
    }

    /**
     * Gets the operating system property value. The operating system property
     * @return IdentityRequest_claim_os|null
    */
    public function getClaimOs(): ?IdentityRequest_claim_os {
        return $this->claim_os;
    }

    /**
     * Gets the device_model property value. The device_model property
     * @return IdentityRequest_device_model|null
    */
    public function getDeviceModel(): ?IdentityRequest_device_model {
        return $this->device_model;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'claim_browser' => fn(ParseNode $n) => $o->setClaimBrowser($n->getObjectValue([IdentityRequest_claim_browser::class, 'createFromDiscriminatorValue'])),
            'claim_os' => fn(ParseNode $n) => $o->setClaimOs($n->getObjectValue([IdentityRequest_claim_os::class, 'createFromDiscriminatorValue'])),
            'device_model' => fn(ParseNode $n) => $o->setDeviceModel($n->getObjectValue([IdentityRequest_device_model::class, 'createFromDiscriminatorValue'])),
            'locale' => fn(ParseNode $n) => $o->setLocale($n->getObjectValue([IdentityRequest_locale::class, 'createFromDiscriminatorValue'])),
            'persist' => fn(ParseNode $n) => $o->setPersist($n->getBooleanValue()),
            'proxy' => fn(ParseNode $n) => $o->setProxy($n->getObjectValue([IdentityRequest_proxy::class, 'createFromDiscriminatorValue'])),
            'source' => fn(ParseNode $n) => $o->setSource($n->getObjectValue([IdentityRequest_source::class, 'createFromDiscriminatorValue'])),
            'timezone' => fn(ParseNode $n) => $o->setTimezone($n->getObjectValue([IdentityRequest_timezone::class, 'createFromDiscriminatorValue'])),
            'viewport' => fn(ParseNode $n) => $o->setViewport($n->getObjectValue([IdentityRequest_viewport::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the locale property value. The locale property
     * @return IdentityRequest_locale|null
    */
    public function getLocale(): ?IdentityRequest_locale {
        return $this->locale;
    }

    /**
     * Gets the persist property value. The persist property
     * @return bool|null
    */
    public function getPersist(): ?bool {
        return $this->persist;
    }

    /**
     * Gets the proxy property value. The proxy property
     * @return IdentityRequest_proxy|null
    */
    public function getProxy(): ?IdentityRequest_proxy {
        return $this->proxy;
    }

    /**
     * Gets the source property value. The source property
     * @return IdentityRequest_source|null
    */
    public function getSource(): ?IdentityRequest_source {
        return $this->source;
    }

    /**
     * Gets the timezone property value. The timezone property
     * @return IdentityRequest_timezone|null
    */
    public function getTimezone(): ?IdentityRequest_timezone {
        return $this->timezone;
    }

    /**
     * Gets the viewport property value. The viewport property
     * @return IdentityRequest_viewport|null
    */
    public function getViewport(): ?IdentityRequest_viewport {
        return $this->viewport;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('claim_browser', $this->getClaimBrowser());
        $writer->writeObjectValue('claim_os', $this->getClaimOs());
        $writer->writeObjectValue('device_model', $this->getDeviceModel());
        $writer->writeObjectValue('locale', $this->getLocale());
        $writer->writeBooleanValue('persist', $this->getPersist());
        $writer->writeObjectValue('proxy', $this->getProxy());
        $writer->writeObjectValue('source', $this->getSource());
        $writer->writeObjectValue('timezone', $this->getTimezone());
        $writer->writeObjectValue('viewport', $this->getViewport());
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
     * Sets the browser property value. The browser property
     * @param IdentityRequest_claim_browser|null $value Value to set for the browser property.
    */
    public function setClaimBrowser(?IdentityRequest_claim_browser $value): void {
        $this->claim_browser = $value;
    }

    /**
     * Sets the operating system property value. The operating system property
     * @param IdentityRequest_claim_os|null $value Value to set for the operating system property.
    */
    public function setClaimOs(?IdentityRequest_claim_os $value): void {
        $this->claim_os = $value;
    }

    /**
     * Sets the device_model property value. The device_model property
     * @param IdentityRequest_device_model|null $value Value to set for the device_model property.
    */
    public function setDeviceModel(?IdentityRequest_device_model $value): void {
        $this->device_model = $value;
    }

    /**
     * Sets the locale property value. The locale property
     * @param IdentityRequest_locale|null $value Value to set for the locale property.
    */
    public function setLocale(?IdentityRequest_locale $value): void {
        $this->locale = $value;
    }

    /**
     * Sets the persist property value. The persist property
     * @param bool|null $value Value to set for the persist property.
    */
    public function setPersist(?bool $value): void {
        $this->persist = $value;
    }

    /**
     * Sets the proxy property value. The proxy property
     * @param IdentityRequest_proxy|null $value Value to set for the proxy property.
    */
    public function setProxy(?IdentityRequest_proxy $value): void {
        $this->proxy = $value;
    }

    /**
     * Sets the source property value. The source property
     * @param IdentityRequest_source|null $value Value to set for the source property.
    */
    public function setSource(?IdentityRequest_source $value): void {
        $this->source = $value;
    }

    /**
     * Sets the timezone property value. The timezone property
     * @param IdentityRequest_timezone|null $value Value to set for the timezone property.
    */
    public function setTimezone(?IdentityRequest_timezone $value): void {
        $this->timezone = $value;
    }

    /**
     * Sets the viewport property value. The viewport property
     * @param IdentityRequest_viewport|null $value Value to set for the viewport property.
    */
    public function setViewport(?IdentityRequest_viewport $value): void {
        $this->viewport = $value;
    }

}
