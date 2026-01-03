<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class ValidationError
{
    /**
     * Error code
     */
    public string $code;
    /**
     * Human-readable error message
     */
    public string $message;
    /** @var array<mixed> */
    public array $errors;
    /**
     * Additional error details
     * @var array<string, mixed>|null
     */
    public ?array $details = null;

    /**
     * @param array<mixed> $errors
     * @param array<string, mixed>|null $details
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

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            message: $data['message'],
            errors: $data['errors'],
            details: $data['details'] ?? null,
        );
    }

    /** @return array<string, mixed> */
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
