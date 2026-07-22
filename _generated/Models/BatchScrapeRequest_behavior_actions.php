<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes array, BatchScrapeRequest_behavior_actionsMember2
*/
class BatchScrapeRequest_behavior_actions implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var array<BatchScrapeRequest_behavior_actionsMember1>|null $batchScrapeRequest_behavior_actionsMember1 Composed type representation for type array
    */
    private ?array $batchScrapeRequest_behavior_actionsMember1 = null;
    
    /**
     * @var BatchScrapeRequest_behavior_actionsMember2|null $batchScrapeRequest_behavior_actionsMember2 Composed type representation for type BatchScrapeRequest_behavior_actionsMember2
    */
    private ?BatchScrapeRequest_behavior_actionsMember2 $batchScrapeRequest_behavior_actionsMember2 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return BatchScrapeRequest_behavior_actions
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): BatchScrapeRequest_behavior_actions {
        $result = new BatchScrapeRequest_behavior_actions();
        if ($parseNode->getCollectionOfObjectValues([BatchScrapeRequest_behavior_actionsMember1::class, 'createFromDiscriminatorValue']) !== null) {
            $result->setBatchScrapeRequestBehaviorActionsMember1($parseNode->getCollectionOfObjectValues([BatchScrapeRequest_behavior_actionsMember1::class, 'createFromDiscriminatorValue']));
        } else {
            $result->setBatchScrapeRequestBehaviorActionsMember2(new BatchScrapeRequest_behavior_actionsMember2());
        }
        return $result;
    }

    /**
     * Gets the BatchScrapeRequest_behavior_actionsMember1 property value. Composed type representation for type array
     * @return array<BatchScrapeRequest_behavior_actionsMember1>|null
    */
    public function getBatchScrapeRequestBehaviorActionsMember1(): ?array {
        return $this->batchScrapeRequest_behavior_actionsMember1;
    }

    /**
     * Gets the BatchScrapeRequest_behavior_actionsMember2 property value. Composed type representation for type BatchScrapeRequest_behavior_actionsMember2
     * @return BatchScrapeRequest_behavior_actionsMember2|null
    */
    public function getBatchScrapeRequestBehaviorActionsMember2(): ?BatchScrapeRequest_behavior_actionsMember2 {
        return $this->batchScrapeRequest_behavior_actionsMember2;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getBatchScrapeRequestBehaviorActionsMember2() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getBatchScrapeRequestBehaviorActionsMember2());
        }
        return [];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getBatchScrapeRequestBehaviorActionsMember1() !== null) {
            $writer->writeCollectionOfObjectValues(null, $this->getBatchScrapeRequestBehaviorActionsMember1());
        } else {
            $writer->writeObjectValue(null, $this->getBatchScrapeRequestBehaviorActionsMember2());
        }
    }

    /**
     * Sets the BatchScrapeRequest_behavior_actionsMember1 property value. Composed type representation for type array
     * @param array<BatchScrapeRequest_behavior_actionsMember1>|null $value Value to set for the BatchScrapeRequest_behavior_actionsMember1 property.
    */
    public function setBatchScrapeRequestBehaviorActionsMember1(?array $value): void {
        $this->batchScrapeRequest_behavior_actionsMember1 = $value;
    }

    /**
     * Sets the BatchScrapeRequest_behavior_actionsMember2 property value. Composed type representation for type BatchScrapeRequest_behavior_actionsMember2
     * @param BatchScrapeRequest_behavior_actionsMember2|null $value Value to set for the BatchScrapeRequest_behavior_actionsMember2 property.
    */
    public function setBatchScrapeRequestBehaviorActionsMember2(?BatchScrapeRequest_behavior_actionsMember2 $value): void {
        $this->batchScrapeRequest_behavior_actionsMember2 = $value;
    }

}
