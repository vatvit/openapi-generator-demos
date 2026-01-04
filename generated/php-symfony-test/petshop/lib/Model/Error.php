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
     */
    public int $code;

    /**
     */
    public string $message;

    /**
     * Constructor
     */
    public function __construct(
        int $code,
        string $message,
    ) {
        $this->code = $code;
        $this->message = $message;
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
        ];
    }
}
