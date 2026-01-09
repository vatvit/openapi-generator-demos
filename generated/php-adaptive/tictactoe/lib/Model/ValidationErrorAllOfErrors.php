<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * ValidationErrorAllOfErrors model.
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

    public mixed $value = null;

    /**
     * Create a new ValidationErrorAllOfErrors instance.
     */
    public function __construct(
        string $field,
        string $message,
        mixed $value = null
    ) {
        $this->field = $field;
        $this->message = $message;
        $this->value = $value;
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
            field: $data['field'] ?? throw new \InvalidArgumentException('field is required'),
            message: $data['message'] ?? throw new \InvalidArgumentException('message is required'),
            value: $data['value'] ?? null
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
            'field' => $this->field,
            'message' => $this->message,
            'value' => $this->value
        ];
    }
}
