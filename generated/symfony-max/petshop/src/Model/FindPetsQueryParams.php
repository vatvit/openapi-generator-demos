<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * FindPetsQueryParams
 *
 * Query parameters DTO for findPets operation.
 * GET /pets
 *
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class FindPetsQueryParams
{
    public function __construct(
        /** tags to filter by */
        /** @var array<mixed>|null */
        public ?array $tags = null,
        /** maximum number of results to return */
        public ?int $limit = null,
    ) {}

    /** @param array<string, mixed> $query */
    public static function fromQuery(array $query): self
    {
        return new self(
            tags: $query['tags'] ?? null,
            limit: isset($query['limit']) ? (int) $query['limit'] : null,
        );
    }
}
