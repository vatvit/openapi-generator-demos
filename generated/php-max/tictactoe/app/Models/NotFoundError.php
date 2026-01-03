<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Not found error - resource does not exist
 */
final class NotFoundError
{
    /**
     * Error code
     */
    public string $code;
    /**
     * Human-readable error message
     */
    public string $message;
    /**
     * Additional error details
     * @var array<string, mixed>|null
     */
    public ?array $details = null;
    /**
     * Error type identifier
     */
    public ?string $errorType = null;

    /**
     * @param array<string, mixed>|null $details
     */
    public function __construct(
        string $code,
        string $message,
        ?array $details = null,
        ?string $errorType = null,
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
        $this->errorType = $errorType;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            message: $data['message'],
            details: $data['details'] ?? null,
            errorType: $data['errorType'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details,
            'errorType' => $this->errorType,
        ];
    }
}
