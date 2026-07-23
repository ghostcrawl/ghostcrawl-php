<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ScreenshotRequest_identityMember1, string
*/
class ScreenshotRequest_identity implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ScreenshotRequest_identityMember1|null $screenshotRequest_identityMember1 Composed type representation for type ScreenshotRequest_identityMember1
    */
    private ?ScreenshotRequest_identityMember1 $screenshotRequest_identityMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScreenshotRequest_identity
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScreenshotRequest_identity {
        $result = new ScreenshotRequest_identity();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setScreenshotRequestIdentityMember1(new ScreenshotRequest_identityMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScreenshotRequestIdentityMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScreenshotRequestIdentityMember1());
        }
        return [];
    }

    /**
     * Gets the ScreenshotRequest_identityMember1 property value. Composed type representation for type ScreenshotRequest_identityMember1
     * @return ScreenshotRequest_identityMember1|null
    */
    public function getScreenshotRequestIdentityMember1(): ?ScreenshotRequest_identityMember1 {
        return $this->screenshotRequest_identityMember1;
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
            $writer->writeObjectValue(null, $this->getScreenshotRequestIdentityMember1());
        }
    }

    /**
     * Sets the ScreenshotRequest_identityMember1 property value. Composed type representation for type ScreenshotRequest_identityMember1
     * @param ScreenshotRequest_identityMember1|null $value Value to set for the ScreenshotRequest_identityMember1 property.
    */
    public function setScreenshotRequestIdentityMember1(?ScreenshotRequest_identityMember1 $value): void {
        $this->screenshotRequest_identityMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
