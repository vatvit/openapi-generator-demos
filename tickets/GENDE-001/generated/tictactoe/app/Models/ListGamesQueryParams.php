<?php declare(strict_types=1);

namespace TictactoeApi\Models;

/**
 * ListGamesQueryParams
 *
 * Auto-generated Query Parameters DTO for listGames operation
 * Typed query parameters with defaults
 *
 * OpenAPI Operation: listGames
 * HTTP Method: GET /games
 */
class ListGamesQueryParams
{
    /**
     * @param ?int $page Page number for pagination
     * @param ?int $limit Number of items per page
     * @param ?string $status Filter by game status
     * @param ?string $player_id Filter games by player ID
     */
    public function __construct(
        public ?int $page = 1,
        public ?int $limit = 20,
        public ?string $status = null,
        public ?string $player_id = null,
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
            page: isset($query['page']) ? (int) $query['page'] : 1,
            limit: isset($query['limit']) ? (int) $query['limit'] : 20,
            player_id: $query['playerId'] ?? null,
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
            'page' => $this->page,
            'limit' => $this->limit,
            'status' => $this->status,
            'playerId' => $this->player_id,
        ];
    }
}
