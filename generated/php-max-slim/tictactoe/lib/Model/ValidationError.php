<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

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
     * Additional error details
     * @var array<string, mixed>|null
     */
    public mixed $details = null;
    /** @var array<mixed> */
    public array $errors;

    /**
     * @param array<string, mixed>|null $details
     * @param array<mixed> $errors
     */
    public function __construct(
        string $code,
        string $message,
        mixed $details = null,
        array $errors,
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
        $this->errors = $errors;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            message: $data['message'],
            details: $data['details'] ?? null,
            errors: $data['errors'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details,
            'errors' => $this->errors,
        ];
    }
}
