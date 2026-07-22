<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNodeHelper;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes array, ExtractRequest_behavior_actionsMember2
*/
class ExtractRequest_behavior_actions implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var array<ExtractRequest_behavior_actionsMember1>|null $extractRequest_behavior_actionsMember1 Composed type representation for type array
    */
    private ?array $extractRequest_behavior_actionsMember1 = null;
    
    /**
     * @var ExtractRequest_behavior_actionsMember2|null $extractRequest_behavior_actionsMember2 Composed type representation for type ExtractRequest_behavior_actionsMember2
    */
    private ?ExtractRequest_behavior_actionsMember2 $extractRequest_behavior_actionsMember2 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ExtractRequest_behavior_actions
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ExtractRequest_behavior_actions {
        $result = new ExtractRequest_behavior_actions();
        if ($parseNode->getCollectionOfObjectValues([ExtractRequest_behavior_actionsMember1::class, 'createFromDiscriminatorValue']) !== null) {
            $result->setExtractRequestBehaviorActionsMember1($parseNode->getCollectionOfObjectValues([ExtractRequest_behavior_actionsMember1::class, 'createFromDiscriminatorValue']));
        } else {
            $result->setExtractRequestBehaviorActionsMember2(new ExtractRequest_behavior_actionsMember2());
        }
        return $result;
    }

    /**
     * Gets the ExtractRequest_behavior_actionsMember1 property value. Composed type representation for type array
     * @return array<ExtractRequest_behavior_actionsMember1>|null
    */
    public function getExtractRequestBehaviorActionsMember1(): ?array {
        return $this->extractRequest_behavior_actionsMember1;
    }

    /**
     * Gets the ExtractRequest_behavior_actionsMember2 property value. Composed type representation for type ExtractRequest_behavior_actionsMember2
     * @return ExtractRequest_behavior_actionsMember2|null
    */
    public function getExtractRequestBehaviorActionsMember2(): ?ExtractRequest_behavior_actionsMember2 {
        return $this->extractRequest_behavior_actionsMember2;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getExtractRequestBehaviorActionsMember2() !== null) {
            return ParseNodeHelper::mergeDeserializersForIntersectionWrapper($this->getExtractRequestBehaviorActionsMember2());
        }
        return [];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getExtractRequestBehaviorActionsMember1() !== null) {
            $writer->writeCollectionOfObjectValues(null, $this->getExtractRequestBehaviorActionsMember1());
        } else {
            $writer->writeObjectValue(null, $this->getExtractRequestBehaviorActionsMember2());
        }
    }

    /**
     * Sets the ExtractRequest_behavior_actionsMember1 property value. Composed type representation for type array
     * @param array<ExtractRequest_behavior_actionsMember1>|null $value Value to set for the ExtractRequest_behavior_actionsMember1 property.
    */
    public function setExtractRequestBehaviorActionsMember1(?array $value): void {
        $this->extractRequest_behavior_actionsMember1 = $value;
    }

    /**
     * Sets the ExtractRequest_behavior_actionsMember2 property value. Composed type representation for type ExtractRequest_behavior_actionsMember2
     * @param ExtractRequest_behavior_actionsMember2|null $value Value to set for the ExtractRequest_behavior_actionsMember2 property.
    */
    public function setExtractRequestBehaviorActionsMember2(?ExtractRequest_behavior_actionsMember2 $value): void {
        $this->extractRequest_behavior_actionsMember2 = $value;
    }

}
