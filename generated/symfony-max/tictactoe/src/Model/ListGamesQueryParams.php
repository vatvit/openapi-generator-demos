<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListGamesQueryParams
 *
 * Query parameters DTO for listGames operation.
 * GET /games
 *
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class ListGamesQueryParams
{
    public function __construct(
        /** Page number for pagination */
        public ?int $page = 1,
        /** Number of items per page */
        public ?int $limit = 20,
        /** Filter by game status */
        /** Filter games by player ID */
        public ?string $player_id = null,
    ) {}

    /** @param array<string, mixed> $query */
    public static function fromQuery(array $query): self
    {
        return new self(
            page: isset($query['page']) ? (int) $query['page'] : 1,
            limit: isset($query['limit']) ? (int) $query['limit'] : 20,
            player_id: $query['playerId'] ?? null,
        );
    }
}
