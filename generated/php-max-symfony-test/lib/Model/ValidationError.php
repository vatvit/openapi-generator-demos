<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotNull]
    public string $code;

    /**
     * Human-readable error message
     */
    #[Assert\NotNull]
    public string $message;

    /**
     * Additional error details
     */
    public ?array $details = null;

    /**
     * @var array<mixed>
     */
    #[Assert\NotNull]
    public array $errors;

    /**
     * Constructor
     */
    public function __construct(
        string $code,
        string $message,
        ?array $details = null,
        array $errors,
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
        $this->errors = $errors;
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
            details: $data['details'] ?? null,
            errors: $data['errors'] ?? null,
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
            'details' => $this->details,
            'errors' => $this->errors,
        ];
    }
}

