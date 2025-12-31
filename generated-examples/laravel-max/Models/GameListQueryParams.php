<?php

declare(strict_types=1);

namespace LaravelMaxApi\Models;

/**
 * GameListQueryParams DTO
 *
 * Auto-generated from OpenAPI query parameters for list-games operation
 * Typed query parameters with validation
 */
class GameListQueryParams
{
    /**
     * @param int $page Page number for pagination (min: 1, default: 1)
     * @param int $limit Items per page (min: 1, max: 100, default: 20)
     * @param string|null $status Filter by game status
     * @param string|null $playerXId Filter games by playerX ID
     */
    public function __construct(
        public int $page = 1,
        public int $limit = 20,
        public ?string $status = null,
        public ?string $playerXId = null,
    ) {}

    /**
     * Create from query parameters array
     *
     * @param array<string, mixed> $query
     * @return self
     */
    public static function fromQuery(array $query): self
    {
        return new self(
            page: isset($query['page']) ? (int) $query['page'] : 1,
            limit: isset($query['limit']) ? (int) $query['limit'] : 20,
            status: $query['status'] ?? null,
            playerXId: $query['playerXId'] ?? null,
        );
    }
}
