<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class CheckoutRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $tier The tier property
    */
    private ?string $tier = null;
    
    /**
     * @var bool|null $with_captcha The with_captcha property
    */
    private ?bool $with_captcha = null;
    
    /**
     * @var bool|null $with_proxy The with_proxy property
    */
    private ?bool $with_proxy = null;
    
    /**
     * Instantiates a new CheckoutRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setWithCaptcha(false);
        $this->setWithProxy(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CheckoutRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CheckoutRequest {
        return new CheckoutRequest();
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
            'tier' => fn(ParseNode $n) => $o->setTier($n->getStringValue()),
            'with_captcha' => fn(ParseNode $n) => $o->setWithCaptcha($n->getBooleanValue()),
            'with_proxy' => fn(ParseNode $n) => $o->setWithProxy($n->getBooleanValue()),
        ];
    }

    /**
     * Gets the tier property value. The tier property
     * @return string|null
    */
    public function getTier(): ?string {
        return $this->tier;
    }

    /**
     * Gets the with_captcha property value. The with_captcha property
     * @return bool|null
    */
    public function getWithCaptcha(): ?bool {
        return $this->with_captcha;
    }

    /**
     * Gets the with_proxy property value. The with_proxy property
     * @return bool|null
    */
    public function getWithProxy(): ?bool {
        return $this->with_proxy;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('tier', $this->getTier());
        $writer->writeBooleanValue('with_captcha', $this->getWithCaptcha());
        $writer->writeBooleanValue('with_proxy', $this->getWithProxy());
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
     * Sets the tier property value. The tier property
     * @param string|null $value Value to set for the tier property.
    */
    public function setTier(?string $value): void {
        $this->tier = $value;
    }

    /**
     * Sets the with_captcha property value. The with_captcha property
     * @param bool|null $value Value to set for the with_captcha property.
    */
    public function setWithCaptcha(?bool $value): void {
        $this->with_captcha = $value;
    }

    /**
     * Sets the with_proxy property value. The with_proxy property
     * @param bool|null $value Value to set for the with_proxy property.
    */
    public function setWithProxy(?bool $value): void {
        $this->with_proxy = $value;
    }

}
