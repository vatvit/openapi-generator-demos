<?php declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * FindPetsQueryParams
 *
 * Auto-generated Query Parameters DTO for findPets operation
 * Typed query parameters with defaults
 *
 * OpenAPI Operation: findPets
 * HTTP Method: GET /pets
 */
class FindPetsQueryParams
{
    /**
     * @param ?array $tags tags to filter by
     * @param ?int $limit maximum number of results to return
     */
    public function __construct(
        public ?array $tags = null,
        public ?int $limit = null,
    ) {}

    /**
     * Create from query parameters array
     *
     * @param array<string, mixed> $query Validated query parameters
     * @return self
     */
    public static function fromQuery(array $query): self
    {
        return new self(
            tags: $query['tags'] ?? null,
            limit: isset($query['limit']) ? (int) $query['limit'] : null,
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
            'tags' => $this->tags,
            'limit' => $this->limit,
        ];
    }
}
