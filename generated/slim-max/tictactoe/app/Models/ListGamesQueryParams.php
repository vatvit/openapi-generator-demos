<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * ListGamesQueryParams
 *
 * Query parameters DTO for listGames operation.
 *
 * @generated
 */
final class ListGamesQueryParams
{
    /**
     * Page number for pagination
     */
    public ?int $page = 1;
    /**
     * Number of items per page
     */
    public ?int $limit = 20;
    /**
     * Filter by game status
     */
    public ?\TictactoeApi\Model\GameStatus $status = null;
    /**
     * Filter games by player ID
     */
    public ?string $player_id = null;

    /**
     */
    public function __construct(
        ?int $page = 1,
        ?int $limit = 20,
        ?\TictactoeApi\Model\GameStatus $status = null,
        ?string $player_id = null,
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->status = $status;
        $this->player_id = $player_id;
    }

    /**
     * Create from query parameters array
     *
     * @param array<string, mixed> $queryParams
     */
    public static function fromQueryParams(array $queryParams): self
    {
        return new self(
            page: isset($queryParams['page']) ? (int) $queryParams['page'] : 1,
            limit: isset($queryParams['limit']) ? (int) $queryParams['limit'] : 20,
            status: $queryParams['status'] ?? null,
            player_id: $queryParams['playerId'] ?? null,
        );
    }

    /**
     * Convert to array for validation
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
