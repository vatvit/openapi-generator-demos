<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Validator;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * GetBoardValidator
 *
 * Validates input for getBoard operation using Respect/Validation.
 * Get the game board
 *
 * @generated
 */
final class GetBoardValidator
{
    /**
     * Validate the input data
     *
     * @param array<string, mixed> $data
     * @return ValidationResult
     */
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        return new ValidationResult(empty($errors), $errors);
    }
}

/**
 * Validation result container
 */
final class ValidationResult
{
    /**
     * @param array<string, array<string>> $errors
     */
    public function __construct(
        private readonly bool $valid,
        private readonly array $errors = []
    ) {}

    public function isValid(): bool
    {
        return $this->valid;
    }

    /** @return array<string, array<string>> */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
