<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
     * Additional error details
     * @var mixed
     */
    public ?arraymixed $details = null;

    /**
     * @var array<mixed>
     */
    public array $errors;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->code = $data['code'] ?? throw new \InvalidArgumentException('Missing required parameter: code');
        $this->message = $data['message'] ?? throw new \InvalidArgumentException('Missing required parameter: message');
        $this->details = $data['details'] ?? null;
        $this->errors = $data['errors'] ?? throw new \InvalidArgumentException('Missing required parameter: errors');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'code' => $data['code'] ?? null,
            'message' => $data['message'] ?? null,
            'details' => $data['details'] ?? null,
            'errors' => $data['errors'] ?? null,
        ]);
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
