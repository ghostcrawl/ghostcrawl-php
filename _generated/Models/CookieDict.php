<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class CookieDict implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var CookieDict_domain|null $domain The domain property
    */
    private ?CookieDict_domain $domain = null;
    
    /**
     * @var CookieDict_expires|null $expires The expires property
    */
    private ?CookieDict_expires $expires = null;
    
    /**
     * @var CookieDict_httpOnly|null $httpOnly The httpOnly property
    */
    private ?CookieDict_httpOnly $httpOnly = null;
    
    /**
     * @var string|null $name The name property
    */
    private ?string $name = null;
    
    /**
     * @var CookieDict_path|null $path The path property
    */
    private ?CookieDict_path $path = null;
    
    /**
     * @var CookieDict_sameSite|null $sameSite The sameSite property
    */
    private ?CookieDict_sameSite $sameSite = null;
    
    /**
     * @var CookieDict_secure|null $secure The secure property
    */
    private ?CookieDict_secure $secure = null;
    
    /**
     * @var CookieDict_url|null $url The url property
    */
    private ?CookieDict_url $url = null;
    
    /**
     * @var string|null $value The value property
    */
    private ?string $value = null;
    
    /**
     * Instantiates a new CookieDict and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookieDict
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookieDict {
        return new CookieDict();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the domain property value. The domain property
     * @return CookieDict_domain|null
    */
    public function getDomain(): ?CookieDict_domain {
        return $this->domain;
    }

    /**
     * Gets the expires property value. The expires property
     * @return CookieDict_expires|null
    */
    public function getExpires(): ?CookieDict_expires {
        return $this->expires;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'domain' => fn(ParseNode $n) => $o->setDomain($n->getObjectValue([CookieDict_domain::class, 'createFromDiscriminatorValue'])),
            'expires' => fn(ParseNode $n) => $o->setExpires($n->getObjectValue([CookieDict_expires::class, 'createFromDiscriminatorValue'])),
            'httpOnly' => fn(ParseNode $n) => $o->setHttpOnly($n->getObjectValue([CookieDict_httpOnly::class, 'createFromDiscriminatorValue'])),
            'name' => fn(ParseNode $n) => $o->setName($n->getStringValue()),
            'path' => fn(ParseNode $n) => $o->setPath($n->getObjectValue([CookieDict_path::class, 'createFromDiscriminatorValue'])),
            'sameSite' => fn(ParseNode $n) => $o->setSameSite($n->getObjectValue([CookieDict_sameSite::class, 'createFromDiscriminatorValue'])),
            'secure' => fn(ParseNode $n) => $o->setSecure($n->getObjectValue([CookieDict_secure::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getObjectValue([CookieDict_url::class, 'createFromDiscriminatorValue'])),
            'value' => fn(ParseNode $n) => $o->setValue($n->getStringValue()),
        ];
    }

    /**
     * Gets the httpOnly property value. The httpOnly property
     * @return CookieDict_httpOnly|null
    */
    public function getHttpOnly(): ?CookieDict_httpOnly {
        return $this->httpOnly;
    }

    /**
     * Gets the name property value. The name property
     * @return string|null
    */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Gets the path property value. The path property
     * @return CookieDict_path|null
    */
    public function getPath(): ?CookieDict_path {
        return $this->path;
    }

    /**
     * Gets the sameSite property value. The sameSite property
     * @return CookieDict_sameSite|null
    */
    public function getSameSite(): ?CookieDict_sameSite {
        return $this->sameSite;
    }

    /**
     * Gets the secure property value. The secure property
     * @return CookieDict_secure|null
    */
    public function getSecure(): ?CookieDict_secure {
        return $this->secure;
    }

    /**
     * Gets the url property value. The url property
     * @return CookieDict_url|null
    */
    public function getUrl(): ?CookieDict_url {
        return $this->url;
    }

    /**
     * Gets the value property value. The value property
     * @return string|null
    */
    public function getValue(): ?string {
        return $this->value;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('domain', $this->getDomain());
        $writer->writeObjectValue('expires', $this->getExpires());
        $writer->writeObjectValue('httpOnly', $this->getHttpOnly());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeObjectValue('path', $this->getPath());
        $writer->writeObjectValue('sameSite', $this->getSameSite());
        $writer->writeObjectValue('secure', $this->getSecure());
        $writer->writeObjectValue('url', $this->getUrl());
        $writer->writeStringValue('value', $this->getValue());
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
     * Sets the domain property value. The domain property
     * @param CookieDict_domain|null $value Value to set for the domain property.
    */
    public function setDomain(?CookieDict_domain $value): void {
        $this->domain = $value;
    }

    /**
     * Sets the expires property value. The expires property
     * @param CookieDict_expires|null $value Value to set for the expires property.
    */
    public function setExpires(?CookieDict_expires $value): void {
        $this->expires = $value;
    }

    /**
     * Sets the httpOnly property value. The httpOnly property
     * @param CookieDict_httpOnly|null $value Value to set for the httpOnly property.
    */
    public function setHttpOnly(?CookieDict_httpOnly $value): void {
        $this->httpOnly = $value;
    }

    /**
     * Sets the name property value. The name property
     * @param string|null $value Value to set for the name property.
    */
    public function setName(?string $value): void {
        $this->name = $value;
    }

    /**
     * Sets the path property value. The path property
     * @param CookieDict_path|null $value Value to set for the path property.
    */
    public function setPath(?CookieDict_path $value): void {
        $this->path = $value;
    }

    /**
     * Sets the sameSite property value. The sameSite property
     * @param CookieDict_sameSite|null $value Value to set for the sameSite property.
    */
    public function setSameSite(?CookieDict_sameSite $value): void {
        $this->sameSite = $value;
    }

    /**
     * Sets the secure property value. The secure property
     * @param CookieDict_secure|null $value Value to set for the secure property.
    */
    public function setSecure(?CookieDict_secure $value): void {
        $this->secure = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param CookieDict_url|null $value Value to set for the url property.
    */
    public function setUrl(?CookieDict_url $value): void {
        $this->url = $value;
    }

    /**
     * Sets the value property value. The value property
     * @param string|null $value Value to set for the value property.
    */
    public function setValue(?string $value): void {
        $this->value = $value;
    }

}
