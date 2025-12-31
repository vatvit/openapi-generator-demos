<?php declare(strict_types=1);

namespace TictactoeApi\Model;

final class ListGamesQueryParams
{
    public function __construct(
        public ?int $page = 1,
        public ?int $limit = 20,
        public ?string $status = null,
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

    /** @return array<string, mixed> */
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
