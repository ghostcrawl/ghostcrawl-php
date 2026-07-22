<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class CookiesDeleteBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var CookiesDeleteBody_domain|null $domain The domain property
    */
    private ?CookiesDeleteBody_domain $domain = null;
    
    /**
     * @var CookiesDeleteBody_name|null $name The name property
    */
    private ?CookiesDeleteBody_name $name = null;
    
    /**
     * @var CookiesDeleteBody_path|null $path The path property
    */
    private ?CookiesDeleteBody_path $path = null;
    
    /**
     * @var string|null $profile_id The profile_id property
    */
    private ?string $profile_id = null;
    
    /**
     * Instantiates a new CookiesDeleteBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CookiesDeleteBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CookiesDeleteBody {
        return new CookiesDeleteBody();
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
     * @return CookiesDeleteBody_domain|null
    */
    public function getDomain(): ?CookiesDeleteBody_domain {
        return $this->domain;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'domain' => fn(ParseNode $n) => $o->setDomain($n->getObjectValue([CookiesDeleteBody_domain::class, 'createFromDiscriminatorValue'])),
            'name' => fn(ParseNode $n) => $o->setName($n->getObjectValue([CookiesDeleteBody_name::class, 'createFromDiscriminatorValue'])),
            'path' => fn(ParseNode $n) => $o->setPath($n->getObjectValue([CookiesDeleteBody_path::class, 'createFromDiscriminatorValue'])),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getStringValue()),
        ];
    }

    /**
     * Gets the name property value. The name property
     * @return CookiesDeleteBody_name|null
    */
    public function getName(): ?CookiesDeleteBody_name {
        return $this->name;
    }

    /**
     * Gets the path property value. The path property
     * @return CookiesDeleteBody_path|null
    */
    public function getPath(): ?CookiesDeleteBody_path {
        return $this->path;
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return string|null
    */
    public function getProfileId(): ?string {
        return $this->profile_id;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('domain', $this->getDomain());
        $writer->writeObjectValue('name', $this->getName());
        $writer->writeObjectValue('path', $this->getPath());
        $writer->writeStringValue('profile_id', $this->getProfileId());
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
     * @param CookiesDeleteBody_domain|null $value Value to set for the domain property.
    */
    public function setDomain(?CookiesDeleteBody_domain $value): void {
        $this->domain = $value;
    }

    /**
     * Sets the name property value. The name property
     * @param CookiesDeleteBody_name|null $value Value to set for the name property.
    */
    public function setName(?CookiesDeleteBody_name $value): void {
        $this->name = $value;
    }

    /**
     * Sets the path property value. The path property
     * @param CookiesDeleteBody_path|null $value Value to set for the path property.
    */
    public function setPath(?CookiesDeleteBody_path $value): void {
        $this->path = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param string|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?string $value): void {
        $this->profile_id = $value;
    }

}
