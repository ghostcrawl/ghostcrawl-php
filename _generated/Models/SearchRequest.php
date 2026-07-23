<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/search request body.
*/
class SearchRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var SearchRequest_country|null $country Optional 2-letter ISO country code for geo-filter. Tavily v1 ignores this silently.
    */
    private ?SearchRequest_country $country = null;
    
    /**
     * @var SearchRequest_engine|null $engine Search engine to use: 'brave', 'tavily', 'google', 'bing', or 'yandex'. May also be passed via X-GhostCrawl-Search-Engine header.
    */
    private ?SearchRequest_engine $engine = null;
    
    /**
     * @var SearchRequest_freshness|null $freshness Optional freshness filter (adapter-specific; Brave: 'pd'/'pw'/'pm'/'py' for day/week/month/year).
    */
    private ?SearchRequest_freshness $freshness = null;
    
    /**
     * @var int|null $limit Maximum results (1-20).
    */
    private ?int $limit = null;
    
    /**
     * @var string|null $query Search query string.
    */
    private ?string $query = null;
    
    /**
     * @var SearchRequest_vertical|null $vertical Engine-specific vertical (google only): 'search' (default) | 'jobs' | 'scholar' | 'play' | 'reviews'. Ignored by brave/tavily.
    */
    private ?SearchRequest_vertical $vertical = null;
    
    /**
     * Instantiates a new SearchRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setLimit(10);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SearchRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SearchRequest {
        return new SearchRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the country property value. Optional 2-letter ISO country code for geo-filter. Tavily v1 ignores this silently.
     * @return SearchRequest_country|null
    */
    public function getCountry(): ?SearchRequest_country {
        return $this->country;
    }

    /**
     * Gets the engine property value. Search engine to use: 'brave', 'tavily', 'google', 'bing', or 'yandex'. May also be passed via X-GhostCrawl-Search-Engine header.
     * @return SearchRequest_engine|null
    */
    public function getEngine(): ?SearchRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'country' => fn(ParseNode $n) => $o->setCountry($n->getObjectValue([SearchRequest_country::class, 'createFromDiscriminatorValue'])),
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getObjectValue([SearchRequest_engine::class, 'createFromDiscriminatorValue'])),
            'freshness' => fn(ParseNode $n) => $o->setFreshness($n->getObjectValue([SearchRequest_freshness::class, 'createFromDiscriminatorValue'])),
            'limit' => fn(ParseNode $n) => $o->setLimit($n->getIntegerValue()),
            'query' => fn(ParseNode $n) => $o->setQuery($n->getStringValue()),
            'vertical' => fn(ParseNode $n) => $o->setVertical($n->getObjectValue([SearchRequest_vertical::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the freshness property value. Optional freshness filter (adapter-specific; Brave: 'pd'/'pw'/'pm'/'py' for day/week/month/year).
     * @return SearchRequest_freshness|null
    */
    public function getFreshness(): ?SearchRequest_freshness {
        return $this->freshness;
    }

    /**
     * Gets the limit property value. Maximum results (1-20).
     * @return int|null
    */
    public function getLimit(): ?int {
        return $this->limit;
    }

    /**
     * Gets the query property value. Search query string.
     * @return string|null
    */
    public function getQuery(): ?string {
        return $this->query;
    }

    /**
     * Gets the vertical property value. Engine-specific vertical (google only): 'search' (default) | 'jobs' | 'scholar' | 'play' | 'reviews'. Ignored by brave/tavily.
     * @return SearchRequest_vertical|null
    */
    public function getVertical(): ?SearchRequest_vertical {
        return $this->vertical;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('country', $this->getCountry());
        $writer->writeObjectValue('engine', $this->getEngine());
        $writer->writeObjectValue('freshness', $this->getFreshness());
        $writer->writeIntegerValue('limit', $this->getLimit());
        $writer->writeStringValue('query', $this->getQuery());
        $writer->writeObjectValue('vertical', $this->getVertical());
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
     * Sets the country property value. Optional 2-letter ISO country code for geo-filter. Tavily v1 ignores this silently.
     * @param SearchRequest_country|null $value Value to set for the country property.
    */
    public function setCountry(?SearchRequest_country $value): void {
        $this->country = $value;
    }

    /**
     * Sets the engine property value. Search engine to use: 'brave', 'tavily', 'google', 'bing', or 'yandex'. May also be passed via X-GhostCrawl-Search-Engine header.
     * @param SearchRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?SearchRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the freshness property value. Optional freshness filter (adapter-specific; Brave: 'pd'/'pw'/'pm'/'py' for day/week/month/year).
     * @param SearchRequest_freshness|null $value Value to set for the freshness property.
    */
    public function setFreshness(?SearchRequest_freshness $value): void {
        $this->freshness = $value;
    }

    /**
     * Sets the limit property value. Maximum results (1-20).
     * @param int|null $value Value to set for the limit property.
    */
    public function setLimit(?int $value): void {
        $this->limit = $value;
    }

    /**
     * Sets the query property value. Search query string.
     * @param string|null $value Value to set for the query property.
    */
    public function setQuery(?string $value): void {
        $this->query = $value;
    }

    /**
     * Sets the vertical property value. Engine-specific vertical (google only): 'search' (default) | 'jobs' | 'scholar' | 'play' | 'reviews'. Ignored by brave/tavily.
     * @param SearchRequest_vertical|null $value Value to set for the vertical property.
    */
    public function setVertical(?SearchRequest_vertical $value): void {
        $this->vertical = $value;
    }

}
