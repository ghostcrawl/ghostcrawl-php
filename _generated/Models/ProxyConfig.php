<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class ProxyConfig implements Parsable 
{
    /**
     * @var string|null $bypass The bypass property
    */
    private ?string $bypass = null;
    
    /**
     * @var string|null $password The password property
    */
    private ?string $password = null;
    
    /**
     * @var string|null $server Proxy URL with scheme and host:port.
    */
    private ?string $server = null;
    
    /**
     * @var string|null $username The username property
    */
    private ?string $username = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ProxyConfig
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ProxyConfig {
        return new ProxyConfig();
    }

    /**
     * Gets the bypass property value. The bypass property
     * @return string|null
    */
    public function getBypass(): ?string {
        return $this->bypass;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'bypass' => fn(ParseNode $n) => $o->setBypass($n->getStringValue()),
            'password' => fn(ParseNode $n) => $o->setPassword($n->getStringValue()),
            'server' => fn(ParseNode $n) => $o->setServer($n->getStringValue()),
            'username' => fn(ParseNode $n) => $o->setUsername($n->getStringValue()),
        ];
    }

    /**
     * Gets the password property value. The password property
     * @return string|null
    */
    public function getPassword(): ?string {
        return $this->password;
    }

    /**
     * Gets the server property value. Proxy URL with scheme and host:port.
     * @return string|null
    */
    public function getServer(): ?string {
        return $this->server;
    }

    /**
     * Gets the username property value. The username property
     * @return string|null
    */
    public function getUsername(): ?string {
        return $this->username;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('bypass', $this->getBypass());
        $writer->writeStringValue('password', $this->getPassword());
        $writer->writeStringValue('server', $this->getServer());
        $writer->writeStringValue('username', $this->getUsername());
    }

    /**
     * Sets the bypass property value. The bypass property
     * @param string|null $value Value to set for the bypass property.
    */
    public function setBypass(?string $value): void {
        $this->bypass = $value;
    }

    /**
     * Sets the password property value. The password property
     * @param string|null $value Value to set for the password property.
    */
    public function setPassword(?string $value): void {
        $this->password = $value;
    }

    /**
     * Sets the server property value. Proxy URL with scheme and host:port.
     * @param string|null $value Value to set for the server property.
    */
    public function setServer(?string $value): void {
        $this->server = $value;
    }

    /**
     * Sets the username property value. The username property
     * @param string|null $value Value to set for the username property.
    */
    public function setUsername(?string $value): void {
        $this->username = $value;
    }

}
