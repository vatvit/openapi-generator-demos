<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * ValidationErrorAllOfErrors
 *
 * 
 *
 * @generated
 */
class ValidationErrorAllOfErrors
{
    /**
     * Field that failed validation
     */
    public string $field;

    /**
     * Validation error message
     */
    public string $message;

    /**
     * @var mixed
     */
    public mixed $value = null;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->field = $data['field'] ?? throw new \InvalidArgumentException('Missing required parameter: field');
        $this->message = $data['message'] ?? throw new \InvalidArgumentException('Missing required parameter: message');
        $this->value = $data['value'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'field' => $data['field'] ?? null,
            'message' => $data['message'] ?? null,
            'value' => $data['value'] ?? null,
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
            'field' => $this->field,
            'message' => $this->message,
            'value' => $this->value,
        ];
    }
}
