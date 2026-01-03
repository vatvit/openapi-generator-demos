<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Error
 *
 * 
 *
 * @generated
 */
class Error
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
     */
    public ?array&lt;string,mixed&gt; $details = null;

    /**
     * Constructor
     */
    public function __construct(
        string $code,
        string $message,
        ?array&lt;string,mixed&gt; $details = null,
    ) {
        $this->code = $code;
        $this->message = $message;
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
            'details' => $this->details,
        ];
    }
}
