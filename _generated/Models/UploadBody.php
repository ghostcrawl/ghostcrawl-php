<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class UploadBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $content_base64 The content_base64 property
    */
    private ?string $content_base64 = null;
    
    /**
     * @var string|null $filename The filename property
    */
    private ?string $filename = null;
    
    /**
     * @var string|null $mime The mime property
    */
    private ?string $mime = null;
    
    /**
     * @var string|null $profile_id The profile_id property
    */
    private ?string $profile_id = null;
    
    /**
     * @var string|null $selector The selector property
    */
    private ?string $selector = null;
    
    /**
     * Instantiates a new UploadBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return UploadBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): UploadBody {
        return new UploadBody();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the content_base64 property value. The content_base64 property
     * @return string|null
    */
    public function getContentBase64(): ?string {
        return $this->content_base64;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'content_base64' => fn(ParseNode $n) => $o->setContentBase64($n->getStringValue()),
            'filename' => fn(ParseNode $n) => $o->setFilename($n->getStringValue()),
            'mime' => fn(ParseNode $n) => $o->setMime($n->getStringValue()),
            'profile_id' => fn(ParseNode $n) => $o->setProfileId($n->getStringValue()),
            'selector' => fn(ParseNode $n) => $o->setSelector($n->getStringValue()),
        ];
    }

    /**
     * Gets the filename property value. The filename property
     * @return string|null
    */
    public function getFilename(): ?string {
        return $this->filename;
    }

    /**
     * Gets the mime property value. The mime property
     * @return string|null
    */
    public function getMime(): ?string {
        return $this->mime;
    }

    /**
     * Gets the profile_id property value. The profile_id property
     * @return string|null
    */
    public function getProfileId(): ?string {
        return $this->profile_id;
    }

    /**
     * Gets the selector property value. The selector property
     * @return string|null
    */
    public function getSelector(): ?string {
        return $this->selector;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('content_base64', $this->getContentBase64());
        $writer->writeStringValue('filename', $this->getFilename());
        $writer->writeStringValue('mime', $this->getMime());
        $writer->writeStringValue('profile_id', $this->getProfileId());
        $writer->writeStringValue('selector', $this->getSelector());
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
     * Sets the content_base64 property value. The content_base64 property
     * @param string|null $value Value to set for the content_base64 property.
    */
    public function setContentBase64(?string $value): void {
        $this->content_base64 = $value;
    }

    /**
     * Sets the filename property value. The filename property
     * @param string|null $value Value to set for the filename property.
    */
    public function setFilename(?string $value): void {
        $this->filename = $value;
    }

    /**
     * Sets the mime property value. The mime property
     * @param string|null $value Value to set for the mime property.
    */
    public function setMime(?string $value): void {
        $this->mime = $value;
    }

    /**
     * Sets the profile_id property value. The profile_id property
     * @param string|null $value Value to set for the profile_id property.
    */
    public function setProfileId(?string $value): void {
        $this->profile_id = $value;
    }

    /**
     * Sets the selector property value. The selector property
     * @param string|null $value Value to set for the selector property.
    */
    public function setSelector(?string $value): void {
        $this->selector = $value;
    }

}
