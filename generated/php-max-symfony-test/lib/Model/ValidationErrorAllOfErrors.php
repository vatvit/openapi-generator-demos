<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotNull]
    public string $field;

    /**
     * Validation error message
     */
    #[Assert\NotNull]
    public string $message;

    /**
     */
    public ?mixed $value = null;

    /**
     * Constructor
     */
    public function __construct(
        string $field,
        string $message,
        ?mixed $value = null,
    ) {
        $this->field = $field;
        $this->message = $message;
        $this->value = $value;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            field: $data['field'] ?? null,
            message: $data['message'] ?? null,
            value: $data['value'] ?? null,
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
            'field' => $this->field,
            'message' => $this->message,
            'value' => $this->value,
        ];
    }
}

