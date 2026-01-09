<?php

declare(strict_types=1);

namespace PetshopApi\Model;

/**
 * Error model.
 */
class Error
{
    public int $code;

    public string $message;

    /**
     * Create a new Error instance.
     */
    public function __construct(
        int $code,
        string $message,
    ) {
        $this->code = $code;
        $this->message = $message;
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
            message: $data['message'] ?? throw new \InvalidArgumentException('message is required')
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
            'message' => $this->message
        ];
    }
}
