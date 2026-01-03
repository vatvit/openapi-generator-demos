<?php

declare(strict_types=1);

namespace PetshopApi\Api\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * AddPetRequest
 *
 * Request DTO for addPet operation.
 * Auto-generated from OpenAPI specification.
 * Symfony Validator attributes enforce API contract.
 *
 * @generated
 */
final class AddPetRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $name;

    #[Assert\Type('string')]
    public ?string $tag = null;

}
