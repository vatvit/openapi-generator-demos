<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class ValidationErrorAllOfErrors
{
    /**
     * Field that failed validation
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    public string $field;
    /**
     * Validation error message
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    public string $message;
    #[Assert\NotBlank]
    public mixed $value;

    /**
     */
    public function __construct(
        string $field,
        string $message,
        mixed $value,
    ) {
        $this->field = $field;
        $this->message = $message;
        $this->value = $value;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            field: $data['field'],
            message: $data['message'],
            value: $data['value'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'field' => $this->field,
            'message' => $this->message,
            'value' => $this->value,
        ];
    }
}
