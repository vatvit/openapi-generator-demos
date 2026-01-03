<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Validator;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * PutSquareValidator
 *
 * Validates input for putSquare operation using Respect/Validation.
 * Set a single board square
 *
 * @generated
 */
final class PutSquareValidator
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
