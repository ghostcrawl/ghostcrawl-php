<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Returned on a non-2xx response when the request could not be completed on our side (authentication, rate limiting, capacity, render timeout, …). Sent with the `application/problem+json` media type (RFC 9457).
*/
class ProblemDetails extends ApiException implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $detail A human-readable explanation specific to this occurrence.
    */
    private ?string $detail = null;
    
    /**
     * @var ErrorCode|null $escapedCode The stable, machine-readable error code.
    */
    private ?ErrorCode $escapedCode = null;
    
    /**
     * @var string|null $instance The request identifier for this occurrence (the same value as the `X-Request-Id` response header). Quote it when contacting support.
    */
    private ?string $instance = null;
    
    /**
     * @var int|null $retry_after Suggested number of seconds to wait before retrying. Present only on retryable codes; mirrors the `Retry-After` response header when set.
    */
    private ?int $retry_after = null;
    
    /**
     * @var bool|null $retryable Whether retrying the same call (after a short backoff) can succeed. `false` means the request will keep failing until you change something.
    */
    private ?bool $retryable = null;
    
    /**
     * @var int|null $status The HTTP status code for this response.
    */
    private ?int $status = null;
    
    /**
     * @var string|null $title A short, human-readable summary of the error type.
    */
    private ?string $title = null;
    
    /**
     * @var string|null $type A stable URI that identifies the error type. Dereferences to the matching entry on the public error reference.
    */
    private ?string $type = null;
    
    /**
     * Instantiates a new ProblemDetails and sets the default values.
    */
    public function __construct() {
        parent::__construct();
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ProblemDetails
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ProblemDetails {
        return new ProblemDetails();
    }

    /**
     * Gets the code property value. The stable, machine-readable error code.
     * @return ErrorCode|null
    */
    public function escapedGetCode(): ?ErrorCode {
        return $this->escapedCode;
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the detail property value. A human-readable explanation specific to this occurrence.
     * @return string|null
    */
    public function getDetail(): ?string {
        return $this->detail;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'detail' => fn(ParseNode $n) => $o->setDetail($n->getStringValue()),
            'code' => fn(ParseNode $n) => $o->setCode($n->getEnumValue(ErrorCode::class)),
            'instance' => fn(ParseNode $n) => $o->setInstance($n->getStringValue()),
            'retry_after' => fn(ParseNode $n) => $o->setRetryAfter($n->getIntegerValue()),
            'retryable' => fn(ParseNode $n) => $o->setRetryable($n->getBooleanValue()),
            'status' => fn(ParseNode $n) => $o->setStatus($n->getIntegerValue()),
            'title' => fn(ParseNode $n) => $o->setTitle($n->getStringValue()),
            'type' => fn(ParseNode $n) => $o->setType($n->getStringValue()),
        ];
    }

    /**
     * Gets the instance property value. The request identifier for this occurrence (the same value as the `X-Request-Id` response header). Quote it when contacting support.
     * @return string|null
    */
    public function getInstance(): ?string {
        return $this->instance;
    }

    /**
     * The primary error message.
     * @return string
    */
    public function getPrimaryErrorMessage(): string {
        return parent::getMessage();
    }

    /**
     * Gets the retryable property value. Whether retrying the same call (after a short backoff) can succeed. `false` means the request will keep failing until you change something.
     * @return bool|null
    */
    public function getRetryable(): ?bool {
        return $this->retryable;
    }

    /**
     * Gets the retry_after property value. Suggested number of seconds to wait before retrying. Present only on retryable codes; mirrors the `Retry-After` response header when set.
     * @return int|null
    */
    public function getRetryAfter(): ?int {
        return $this->retry_after;
    }

    /**
     * Gets the status property value. The HTTP status code for this response.
     * @return int|null
    */
    public function getStatus(): ?int {
        return $this->status;
    }

    /**
     * Gets the title property value. A short, human-readable summary of the error type.
     * @return string|null
    */
    public function getTitle(): ?string {
        return $this->title;
    }

    /**
     * Gets the type property value. A stable URI that identifies the error type. Dereferences to the matching entry on the public error reference.
     * @return string|null
    */
    public function getType(): ?string {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('detail', $this->getDetail());
        $writer->writeEnumValue('code', $this->escapedGetCode());
        $writer->writeStringValue('instance', $this->getInstance());
        $writer->writeBooleanValue('retryable', $this->getRetryable());
        $writer->writeIntegerValue('retry_after', $this->getRetryAfter());
        $writer->writeIntegerValue('status', $this->getStatus());
        $writer->writeStringValue('title', $this->getTitle());
        $writer->writeStringValue('type', $this->getType());
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
     * Sets the code property value. The stable, machine-readable error code.
     * @param ErrorCode|null $value Value to set for the code property.
    */
    public function setCode(?ErrorCode $value): void {
        $this->escapedCode = $value;
    }

    /**
     * Sets the detail property value. A human-readable explanation specific to this occurrence.
     * @param string|null $value Value to set for the detail property.
    */
    public function setDetail(?string $value): void {
        $this->detail = $value;
    }

    /**
     * Sets the instance property value. The request identifier for this occurrence (the same value as the `X-Request-Id` response header). Quote it when contacting support.
     * @param string|null $value Value to set for the instance property.
    */
    public function setInstance(?string $value): void {
        $this->instance = $value;
    }

    /**
     * Sets the retryable property value. Whether retrying the same call (after a short backoff) can succeed. `false` means the request will keep failing until you change something.
     * @param bool|null $value Value to set for the retryable property.
    */
    public function setRetryable(?bool $value): void {
        $this->retryable = $value;
    }

    /**
     * Sets the retry_after property value. Suggested number of seconds to wait before retrying. Present only on retryable codes; mirrors the `Retry-After` response header when set.
     * @param int|null $value Value to set for the retry_after property.
    */
    public function setRetryAfter(?int $value): void {
        $this->retry_after = $value;
    }

    /**
     * Sets the status property value. The HTTP status code for this response.
     * @param int|null $value Value to set for the status property.
    */
    public function setStatus(?int $value): void {
        $this->status = $value;
    }

    /**
     * Sets the title property value. A short, human-readable summary of the error type.
     * @param string|null $value Value to set for the title property.
    */
    public function setTitle(?string $value): void {
        $this->title = $value;
    }

    /**
     * Sets the type property value. A stable URI that identifies the error type. Dereferences to the matching entry on the public error reference.
     * @param string|null $value Value to set for the type property.
    */
    public function setType(?string $value): void {
        $this->type = $value;
    }

}
