<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Firecrawl-compatible /v1/map request body. naming convention warnings for intentional camelCase).
*/
class MapBody implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var bool|null $ignoreSitemap The ignoreSitemap property
    */
    private ?bool $ignoreSitemap = null;
    
    /**
     * @var bool|null $includeSubdomains The includeSubdomains property
    */
    private ?bool $includeSubdomains = null;
    
    /**
     * @var int|null $limit The limit property
    */
    private ?int $limit = null;
    
    /**
     * @var MapBody_search|null $search The search property
    */
    private ?MapBody_search $search = null;
    
    /**
     * @var string|null $url The url property
    */
    private ?string $url = null;
    
    /**
     * Instantiates a new MapBody and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setIgnoreSitemap(false);
        $this->setIncludeSubdomains(false);
        $this->setLimit(5000);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return MapBody
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): MapBody {
        return new MapBody();
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
            'ignoreSitemap' => fn(ParseNode $n) => $o->setIgnoreSitemap($n->getBooleanValue()),
            'includeSubdomains' => fn(ParseNode $n) => $o->setIncludeSubdomains($n->getBooleanValue()),
            'limit' => fn(ParseNode $n) => $o->setLimit($n->getIntegerValue()),
            'search' => fn(ParseNode $n) => $o->setSearch($n->getObjectValue([MapBody_search::class, 'createFromDiscriminatorValue'])),
            'url' => fn(ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the ignoreSitemap property value. The ignoreSitemap property
     * @return bool|null
    */
    public function getIgnoreSitemap(): ?bool {
        return $this->ignoreSitemap;
    }

    /**
     * Gets the includeSubdomains property value. The includeSubdomains property
     * @return bool|null
    */
    public function getIncludeSubdomains(): ?bool {
        return $this->includeSubdomains;
    }

    /**
     * Gets the limit property value. The limit property
     * @return int|null
    */
    public function getLimit(): ?int {
        return $this->limit;
    }

    /**
     * Gets the search property value. The search property
     * @return MapBody_search|null
    */
    public function getSearch(): ?MapBody_search {
        return $this->search;
    }

    /**
     * Gets the url property value. The url property
     * @return string|null
    */
    public function getUrl(): ?string {
        return $this->url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeBooleanValue('ignoreSitemap', $this->getIgnoreSitemap());
        $writer->writeBooleanValue('includeSubdomains', $this->getIncludeSubdomains());
        $writer->writeIntegerValue('limit', $this->getLimit());
        $writer->writeObjectValue('search', $this->getSearch());
        $writer->writeStringValue('url', $this->getUrl());
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
     * Sets the ignoreSitemap property value. The ignoreSitemap property
     * @param bool|null $value Value to set for the ignoreSitemap property.
    */
    public function setIgnoreSitemap(?bool $value): void {
        $this->ignoreSitemap = $value;
    }

    /**
     * Sets the includeSubdomains property value. The includeSubdomains property
     * @param bool|null $value Value to set for the includeSubdomains property.
    */
    public function setIncludeSubdomains(?bool $value): void {
        $this->includeSubdomains = $value;
    }

    /**
     * Sets the limit property value. The limit property
     * @param int|null $value Value to set for the limit property.
    */
    public function setLimit(?int $value): void {
        $this->limit = $value;
    }

    /**
     * Sets the search property value. The search property
     * @param MapBody_search|null $value Value to set for the search property.
    */
    public function setSearch(?MapBody_search $value): void {
        $this->search = $value;
    }

    /**
     * Sets the url property value. The url property
     * @param string|null $value Value to set for the url property.
    */
    public function setUrl(?string $value): void {
        $this->url = $value;
    }

}
