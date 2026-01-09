<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * ValidationError
 *
 * 
 *
 * @generated
 */
class ValidationError
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
     * @var array<mixed>
     */
    public array $errors;

    /**
     * Additional error details
     */
    public ?array $details = null;

    /**
     * Constructor
     */
    public function __construct(
        string $code,
        string $message,
        array $errors,
        ?array $details = null,
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
        $this->details = $details;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            message: $data['message'] ?? null,
            errors: $data['errors'] ?? null,
            details: $data['details'] ?? null,
        );
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'errors' => $this->errors,
            'details' => $this->details,
        ];
    }
}
