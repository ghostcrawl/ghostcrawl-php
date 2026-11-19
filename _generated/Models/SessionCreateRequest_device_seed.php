<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes int, SessionCreateRequest_device_seedMember1
*/
class SessionCreateRequest_device_seed implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var int|null $integer Composed type representation for type int
    */
    private ?int $integer = null;
    
    /**
     * @var SessionCreateRequest_device_seedMember1|null $sessionCreateRequest_device_seedMember1 Composed type representation for type SessionCreateRequest_device_seedMember1
    */
    private ?SessionCreateRequest_device_seedMember1 $sessionCreateRequest_device_seedMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SessionCreateRequest_device_seed
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SessionCreateRequest_device_seed {
        $result = new SessionCreateRequest_device_seed();
        if ($parseNode->getIntegerValue() !== null) {
            $result->setInteger($parseNode->getIntegerValue());
        } else {
            $result->setSessionCreateRequestDeviceSeedMember1(new SessionCreateRequest_device_seedMember1());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getSessionCreateRequestDeviceSeedMember1() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getSessionCreateRequestDeviceSeedMember1());
        }
        return [];
    }

    /**
     * Gets the integer property value. Composed type representation for type int
     * @return int|null
    */
    public function getInteger(): ?int {
        return $this->integer;
    }

    /**
     * Gets the SessionCreateRequest_device_seedMember1 property value. Composed type representation for type SessionCreateRequest_device_seedMember1
     * @return SessionCreateRequest_device_seedMember1|null
    */
    public function getSessionCreateRequestDeviceSeedMember1(): ?SessionCreateRequest_device_seedMember1 {
        return $this->sessionCreateRequest_device_seedMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getInteger() !== null) {
            $writer->writeIntegerValue(null, $this->getInteger());
        } else {
            $writer->writeObjectValue(null, $this->getSessionCreateRequestDeviceSeedMember1());
        }
    }

    /**
     * Sets the integer property value. Composed type representation for type int
     * @param int|null $value Value to set for the integer property.
    */
    public function setInteger(?int $value): void {
        $this->integer = $value;
    }

    /**
     * Sets the SessionCreateRequest_device_seedMember1 property value. Composed type representation for type SessionCreateRequest_device_seedMember1
     * @param SessionCreateRequest_device_seedMember1|null $value Value to set for the SessionCreateRequest_device_seedMember1 property.
    */
    public function setSessionCreateRequestDeviceSeedMember1(?SessionCreateRequest_device_seedMember1 $value): void {
        $this->sessionCreateRequest_device_seedMember1 = $value;
    }

}
