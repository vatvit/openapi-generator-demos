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
    public ?array<string,mixed> $details = null;
    /** @var array<mixed> */
    public \TictactoeApi\Model\ValidationErrorAllOfErrors[] $errors;

    /**
     * @param array<string, mixed>|null $details
     * @param array<mixed> $errors
     */
    public function __construct(
        string $code,
        string $message,
        ?array<string,mixed> $details = null,
        \TictactoeApi\Model\ValidationErrorAllOfErrors[] $errors,
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
