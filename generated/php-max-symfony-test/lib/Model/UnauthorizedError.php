<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * UnauthorizedError
 *
 * Unauthorized error - authentication required
 *
 * @generated
 */
class UnauthorizedError
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
     * Error type identifier
     */
    public ?string $error_type = null;

    /**
     * Constructor
     */
    public function __construct(
        string $code,
        string $message,
        ?array $details = null,
        ?string $error_type = null,
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
        $this->error_type = $error_type;
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
            error_type: $data['errorType'] ?? null,
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
            'errorType' => $this->error_type,
        ];
    }
}

