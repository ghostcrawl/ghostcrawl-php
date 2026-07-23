<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScreenshotRequest_languageMember1, string
*/
class ScreenshotRequest_language implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScreenshotRequest_languageMember1|null $screenshotRequest_languageMember1 Composed type representation for type ScreenshotRequest_languageMember1
    */
    private ?ScreenshotRequest_languageMember1 $screenshotRequest_languageMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScreenshotRequest_language
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScreenshotRequest_language {
        $result = new ScreenshotRequest_language();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScreenshotRequestLanguageMember1(new ScreenshotRequest_languageMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScreenshotRequestLanguageMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScreenshotRequestLanguageMember1());
        }
        return [];
    }

    /**
     * Gets the ScreenshotRequest_languageMember1 property value. Composed type representation for type ScreenshotRequest_languageMember1
     * @return ScreenshotRequest_languageMember1|null
    */
    public function getScreenshotRequestLanguageMember1(): ?ScreenshotRequest_languageMember1 {
        return $this->screenshotRequest_languageMember1;
    }

    /**
     * Gets the string property value. Composed type representation for type string
     * @return string|null
    */
    public function getString(): ?string {
        return $this->string;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getString() !== null) {
            $writer->writeStringValue(null, $this->getString());
        } else {
            $writer->writeObjectValue(null, $this->getScreenshotRequestLanguageMember1());
        }
    }

    /**
     * Sets the ScreenshotRequest_languageMember1 property value. Composed type representation for type ScreenshotRequest_languageMember1
     * @param ScreenshotRequest_languageMember1|null $value Value to set for the ScreenshotRequest_languageMember1 property.
    */
    public function setScreenshotRequestLanguageMember1(?ScreenshotRequest_languageMember1 $value): void {
        $this->screenshotRequest_languageMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
