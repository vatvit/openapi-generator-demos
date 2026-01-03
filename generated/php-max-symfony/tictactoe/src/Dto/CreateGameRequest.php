<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * CreateGameRequest
 *
 * Request DTO for createGame operation.
 * Auto-generated from OpenAPI specification.
 * Symfony Validator attributes enforce API contract.
 *
 * @generated
 */
final class CreateGameRequest
{
    #[Assert\NotBlank]
    #[Assert\Choice(['pvp', 'ai_easy', 'ai_medium', 'ai_hard'])]
    public string $mode;

    #[Assert\Type('string')]
    #[Assert\Uuid]
    public ?string $opponentId = null;

    #[Assert\Type('bool')]
    public ?bool $isPrivate = null;

    public ?string $metadata = null;

}
