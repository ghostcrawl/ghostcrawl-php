<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class AuditEventsResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var array<AuditEventOut>|null $events The events property
    */
    private ?array $events = null;
    
    /**
     * @var AuditEventsResponse_next_cursor|null $next_cursor The next_cursor property
    */
    private ?AuditEventsResponse_next_cursor $next_cursor = null;
    
    /**
     * Instantiates a new AuditEventsResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return AuditEventsResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): AuditEventsResponse {
        return new AuditEventsResponse();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the events property value. The events property
     * @return array<AuditEventOut>|null
    */
    public function getEvents(): ?array {
        return $this->events;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'events' => fn(ParseNode $n) => $o->setEvents($n->getCollectionOfObjectValues([AuditEventOut::class, 'createFromDiscriminatorValue'])),
            'next_cursor' => fn(ParseNode $n) => $o->setNextCursor($n->getObjectValue([AuditEventsResponse_next_cursor::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the next_cursor property value. The next_cursor property
     * @return AuditEventsResponse_next_cursor|null
    */
    public function getNextCursor(): ?AuditEventsResponse_next_cursor {
        return $this->next_cursor;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfObjectValues('events', $this->getEvents());
        $writer->writeObjectValue('next_cursor', $this->getNextCursor());
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
     * Sets the events property value. The events property
     * @param array<AuditEventOut>|null $value Value to set for the events property.
    */
    public function setEvents(?array $value): void {
        $this->events = $value;
    }

    /**
     * Sets the next_cursor property value. The next_cursor property
     * @param AuditEventsResponse_next_cursor|null $value Value to set for the next_cursor property.
    */
    public function setNextCursor(?AuditEventsResponse_next_cursor $value): void {
        $this->next_cursor = $value;
    }

}
