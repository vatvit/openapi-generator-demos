<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * PutSquareRequest
 *
 * Request DTO for putSquare operation.
 * Auto-generated from OpenAPI specification.
 * Symfony Validator attributes enforce API contract.
 *
 * @generated
 */
final class PutSquareRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Choice(['X', 'O'])]
    public string $mark;

}
