<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes array, ScrapeRequest_behavior_actionsMember2
*/
class ScrapeRequest_behavior_actions implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var array<ScrapeRequest_behavior_actionsMember1>|null $scrapeRequest_behavior_actionsMember1 Composed type representation for type array
    */
    private ?array $scrapeRequest_behavior_actionsMember1 = null;
    
    /**
     * @var ScrapeRequest_behavior_actionsMember2|null $scrapeRequest_behavior_actionsMember2 Composed type representation for type ScrapeRequest_behavior_actionsMember2
    */
    private ?ScrapeRequest_behavior_actionsMember2 $scrapeRequest_behavior_actionsMember2 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeRequest_behavior_actions
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeRequest_behavior_actions {
        $result = new ScrapeRequest_behavior_actions();
        if ($parseNode->getCollectionOfObjectValues([ScrapeRequest_behavior_actionsMember1::class, 'createFromDiscriminatorValue']) !== null) {
            $result->setScrapeRequestBehaviorActionsMember1($parseNode->getCollectionOfObjectValues([ScrapeRequest_behavior_actionsMember1::class, 'createFromDiscriminatorValue']));
        } else {
            $result->setScrapeRequestBehaviorActionsMember2(new ScrapeRequest_behavior_actionsMember2());
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getScrapeRequestBehaviorActionsMember2() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getScrapeRequestBehaviorActionsMember2());
        }
        return [];
    }

    /**
     * Gets the ScrapeRequest_behavior_actionsMember1 property value. Composed type representation for type array
     * @return array<ScrapeRequest_behavior_actionsMember1>|null
    */
    public function getScrapeRequestBehaviorActionsMember1(): ?array {
        return $this->scrapeRequest_behavior_actionsMember1;
    }

    /**
     * Gets the ScrapeRequest_behavior_actionsMember2 property value. Composed type representation for type ScrapeRequest_behavior_actionsMember2
     * @return ScrapeRequest_behavior_actionsMember2|null
    */
    public function getScrapeRequestBehaviorActionsMember2(): ?ScrapeRequest_behavior_actionsMember2 {
        return $this->scrapeRequest_behavior_actionsMember2;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getScrapeRequestBehaviorActionsMember1() !== null) {
            $writer->writeCollectionOfObjectValues(null, $this->getScrapeRequestBehaviorActionsMember1());
        } else {
            $writer->writeObjectValue(null, $this->getScrapeRequestBehaviorActionsMember2());
        }
    }

    /**
     * Sets the ScrapeRequest_behavior_actionsMember1 property value. Composed type representation for type array
     * @param array<ScrapeRequest_behavior_actionsMember1>|null $value Value to set for the ScrapeRequest_behavior_actionsMember1 property.
    */
    public function setScrapeRequestBehaviorActionsMember1(?array $value): void {
        $this->scrapeRequest_behavior_actionsMember1 = $value;
    }

    /**
     * Sets the ScrapeRequest_behavior_actionsMember2 property value. Composed type representation for type ScrapeRequest_behavior_actionsMember2
     * @param ScrapeRequest_behavior_actionsMember2|null $value Value to set for the ScrapeRequest_behavior_actionsMember2 property.
    */
    public function setScrapeRequestBehaviorActionsMember2(?ScrapeRequest_behavior_actionsMember2 $value): void {
        $this->scrapeRequest_behavior_actionsMember2 = $value;
    }

}
