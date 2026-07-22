<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes SessionCreateRequest_profileMember1, string
*/
class SessionCreateRequest_profile implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var SessionCreateRequest_profileMember1|null $sessionCreateRequest_profileMember1 Composed type representation for type SessionCreateRequest_profileMember1
    */
    private ?SessionCreateRequest_profileMember1 $sessionCreateRequest_profileMember1 = null;
    
    /**
     * @var string|null $string Composed type representation for type string
    */
    private ?string $string = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SessionCreateRequest_profile
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SessionCreateRequest_profile {
        $result = new SessionCreateRequest_profile();
        if ($parseNode->getStringValue() !== null) {
            $result->setString($parseNode->getStringValue());
        } else {
            $result->setSessionCreateRequestProfileMember1(new SessionCreateRequest_profileMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getSessionCreateRequestProfileMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getSessionCreateRequestProfileMember1());
        }
        return [];
    }

    /**
     * Gets the SessionCreateRequest_profileMember1 property value. Composed type representation for type SessionCreateRequest_profileMember1
     * @return SessionCreateRequest_profileMember1|null
    */
    public function getSessionCreateRequestProfileMember1(): ?SessionCreateRequest_profileMember1 {
        return $this->sessionCreateRequest_profileMember1;
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
            $writer->writeObjectValue(null, $this->getSessionCreateRequestProfileMember1());
        }
    }

    /**
     * Sets the SessionCreateRequest_profileMember1 property value. Composed type representation for type SessionCreateRequest_profileMember1
     * @param SessionCreateRequest_profileMember1|null $value Value to set for the SessionCreateRequest_profileMember1 property.
    */
    public function setSessionCreateRequestProfileMember1(?SessionCreateRequest_profileMember1 $value): void {
        $this->sessionCreateRequest_profileMember1 = $value;
    }

    /**
     * Sets the string property value. Composed type representation for type string
     * @param string|null $value Value to set for the string property.
    */
    public function setString(?string $value): void {
        $this->string = $value;
    }

}
