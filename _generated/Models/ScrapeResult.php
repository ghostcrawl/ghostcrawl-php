<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * POST /v1/scrape 200 response body. Documents the customer-facing shape so the OpenAPI 200 schema is no longer an empty ``{}`` (Kiota/typed SDKs need a named schema). ``extra="allow"`` keeps it forward-compatible with the markdown envelope (``format``/``markdown``/ ``chunks``/``citations``/``token_estimate``/``estimated_llm_input_tokens``) and the html envelope (``results``/``identity_id``/``identity_ids``/ ``identities_used``) without over-constraining the route (which returns a JSONResponse, so this model documents but does not coerce the body).
*/
class ScrapeResult implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var ScrapeResult_format|null $format Output format when a non-default format was requested.
    */
    private ?ScrapeResult_format $format = null;
    
    /**
     * @var ScrapeResult_identity_id|null $identity_id Generated identity id (single-identity path).
    */
    private ?ScrapeResult_identity_id $identity_id = null;
    
    /**
     * @var ScrapeResult_markdown|null $markdown Concatenated Markdown (format=markdown path).
    */
    private ?ScrapeResult_markdown $markdown = null;
    
    /**
     * @var array<ScrapePageResult>|null $results Per-URL results (html/default path).
    */
    private ?array $results = null;
    
    /**
     * @var ScrapeResult_status|null $status Aggregate run status (e.g. completed / partial / failed).
    */
    private ?ScrapeResult_status $status = null;
    
    /**
     * @var ScrapeResult_token_estimate|null $token_estimate Estimated token count of the markdown output.
    */
    private ?ScrapeResult_token_estimate $token_estimate = null;
    
    /**
     * @var ScrapeResult_warnings|null $warnings Non-fatal warnings (e.g. host-identity fallback).
    */
    private ?ScrapeResult_warnings $warnings = null;
    
    /**
     * Instantiates a new ScrapeResult and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScrapeResult
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScrapeResult {
        return new ScrapeResult();
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
            'format' => fn(ParseNode $n) => $o->setFormat($n->getObjectValue([ScrapeResult_format::class, 'createFromDiscriminatorValue'])),
            'identity_id' => fn(ParseNode $n) => $o->setIdentityId($n->getObjectValue([ScrapeResult_identity_id::class, 'createFromDiscriminatorValue'])),
            'markdown' => fn(ParseNode $n) => $o->setMarkdown($n->getObjectValue([ScrapeResult_markdown::class, 'createFromDiscriminatorValue'])),
            'results' => fn(ParseNode $n) => $o->setResults($n->getCollectionOfObjectValues([ScrapePageResult::class, 'createFromDiscriminatorValue'])),
            'status' => fn(ParseNode $n) => $o->setStatus($n->getObjectValue([ScrapeResult_status::class, 'createFromDiscriminatorValue'])),
            'token_estimate' => fn(ParseNode $n) => $o->setTokenEstimate($n->getObjectValue([ScrapeResult_token_estimate::class, 'createFromDiscriminatorValue'])),
            'warnings' => fn(ParseNode $n) => $o->setWarnings($n->getObjectValue([ScrapeResult_warnings::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the format property value. Output format when a non-default format was requested.
     * @return ScrapeResult_format|null
    */
    public function getFormat(): ?ScrapeResult_format {
        return $this->format;
    }

    /**
     * Gets the identity_id property value. Generated identity id (single-identity path).
     * @return ScrapeResult_identity_id|null
    */
    public function getIdentityId(): ?ScrapeResult_identity_id {
        return $this->identity_id;
    }

    /**
     * Gets the markdown property value. Concatenated Markdown (format=markdown path).
     * @return ScrapeResult_markdown|null
    */
    public function getMarkdown(): ?ScrapeResult_markdown {
        return $this->markdown;
    }

    /**
     * Gets the results property value. Per-URL results (html/default path).
     * @return array<ScrapePageResult>|null
    */
    public function getResults(): ?array {
        return $this->results;
    }

    /**
     * Gets the status property value. Aggregate run status (e.g. completed / partial / failed).
     * @return ScrapeResult_status|null
    */
    public function getStatus(): ?ScrapeResult_status {
        return $this->status;
    }

    /**
     * Gets the token_estimate property value. Estimated token count of the markdown output.
     * @return ScrapeResult_token_estimate|null
    */
    public function getTokenEstimate(): ?ScrapeResult_token_estimate {
        return $this->token_estimate;
    }

    /**
     * Gets the warnings property value. Non-fatal warnings (e.g. host-identity fallback).
     * @return ScrapeResult_warnings|null
    */
    public function getWarnings(): ?ScrapeResult_warnings {
        return $this->warnings;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeObjectValue('format', $this->getFormat());
        $writer->writeObjectValue('identity_id', $this->getIdentityId());
        $writer->writeObjectValue('markdown', $this->getMarkdown());
        $writer->writeCollectionOfObjectValues('results', $this->getResults());
        $writer->writeObjectValue('status', $this->getStatus());
        $writer->writeObjectValue('token_estimate', $this->getTokenEstimate());
        $writer->writeObjectValue('warnings', $this->getWarnings());
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
     * Sets the format property value. Output format when a non-default format was requested.
     * @param ScrapeResult_format|null $value Value to set for the format property.
    */
    public function setFormat(?ScrapeResult_format $value): void {
        $this->format = $value;
    }

    /**
     * Sets the identity_id property value. Generated identity id (single-identity path).
     * @param ScrapeResult_identity_id|null $value Value to set for the identity_id property.
    */
    public function setIdentityId(?ScrapeResult_identity_id $value): void {
        $this->identity_id = $value;
    }

    /**
     * Sets the markdown property value. Concatenated Markdown (format=markdown path).
     * @param ScrapeResult_markdown|null $value Value to set for the markdown property.
    */
    public function setMarkdown(?ScrapeResult_markdown $value): void {
        $this->markdown = $value;
    }

    /**
     * Sets the results property value. Per-URL results (html/default path).
     * @param array<ScrapePageResult>|null $value Value to set for the results property.
    */
    public function setResults(?array $value): void {
        $this->results = $value;
    }

    /**
     * Sets the status property value. Aggregate run status (e.g. completed / partial / failed).
     * @param ScrapeResult_status|null $value Value to set for the status property.
    */
    public function setStatus(?ScrapeResult_status $value): void {
        $this->status = $value;
    }

    /**
     * Sets the token_estimate property value. Estimated token count of the markdown output.
     * @param ScrapeResult_token_estimate|null $value Value to set for the token_estimate property.
    */
    public function setTokenEstimate(?ScrapeResult_token_estimate $value): void {
        $this->token_estimate = $value;
    }

    /**
     * Sets the warnings property value. Non-fatal warnings (e.g. host-identity fallback).
     * @param ScrapeResult_warnings|null $value Value to set for the warnings property.
    */
    public function setWarnings(?ScrapeResult_warnings $value): void {
        $this->warnings = $value;
    }

}
