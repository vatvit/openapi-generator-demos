<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Error model.
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
     * @var array<string, mixed>|null
     */
    public ?array $details = null;

    /**
     * Create a new Error instance.
     * @param array<string, mixed>|null $details
     */
    public function __construct(
        string $code,
        string $message,
        ?array $details = null
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
    }

    /**
     * Create instance from array data.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? throw new \InvalidArgumentException('code is required'),
            message: $data['message'] ?? throw new \InvalidArgumentException('message is required'),
            details: $data['details'] ?? null
        );
    }

    /**
     * Convert instance to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details
        ];
    }
}
