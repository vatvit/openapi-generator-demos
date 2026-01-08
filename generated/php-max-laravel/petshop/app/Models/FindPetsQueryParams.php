<?php

declare(strict_types=1);

namespace PetshopApi\Model;

final class FindPetsQueryParams
{
    /**
     * @param array<string>|null $tags
     */
    public function __construct(
        public ?array $tags = null,
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

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'tags' => $this->tags,
            'limit' => $this->limit,
        ];
    }
}
