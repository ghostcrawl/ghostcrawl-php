<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Response for GET /v1/webhooks/{id}/deliveries (cursor-paginated list).
*/
class WebhookDeliveryListResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var array<WebhookDeliveryPublic>|null $items The items property
    */
    private ?array $items = null;
    
    /**
     * @var WebhookDeliveryListResponse_next_cursor|null $next_cursor The next_cursor property
    */
    private ?WebhookDeliveryListResponse_next_cursor $next_cursor = null;
    
    /**
     * @var int|null $total The total property
    */
    private ?int $total = null;
    
    /**
     * Instantiates a new WebhookDeliveryListResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WebhookDeliveryListResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebhookDeliveryListResponse {
        return new WebhookDeliveryListResponse();
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
            'items' => fn(ParseNode $n) => $o->setItems($n->getCollectionOfObjectValues([WebhookDeliveryPublic::class, 'createFromDiscriminatorValue'])),
            'next_cursor' => fn(ParseNode $n) => $o->setNextCursor($n->getObjectValue([WebhookDeliveryListResponse_next_cursor::class, 'createFromDiscriminatorValue'])),
            'total' => fn(ParseNode $n) => $o->setTotal($n->getIntegerValue()),
        ];
    }

    /**
     * Gets the items property value. The items property
     * @return array<WebhookDeliveryPublic>|null
    */
    public function getItems(): ?array {
        return $this->items;
    }

    /**
     * Gets the next_cursor property value. The next_cursor property
     * @return WebhookDeliveryListResponse_next_cursor|null
    */
    public function getNextCursor(): ?WebhookDeliveryListResponse_next_cursor {
        return $this->next_cursor;
    }

    /**
     * Gets the total property value. The total property
     * @return int|null
    */
    public function getTotal(): ?int {
        return $this->total;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfObjectValues('items', $this->getItems());
        $writer->writeObjectValue('next_cursor', $this->getNextCursor());
        $writer->writeIntegerValue('total', $this->getTotal());
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
     * Sets the items property value. The items property
     * @param array<WebhookDeliveryPublic>|null $value Value to set for the items property.
    */
    public function setItems(?array $value): void {
        $this->items = $value;
    }

    /**
     * Sets the next_cursor property value. The next_cursor property
     * @param WebhookDeliveryListResponse_next_cursor|null $value Value to set for the next_cursor property.
    */
    public function setNextCursor(?WebhookDeliveryListResponse_next_cursor $value): void {
        $this->next_cursor = $value;
    }

    /**
     * Sets the total property value. The total property
     * @param int|null $value Value to set for the total property.
    */
    public function setTotal(?int $value): void {
        $this->total = $value;
    }

}
