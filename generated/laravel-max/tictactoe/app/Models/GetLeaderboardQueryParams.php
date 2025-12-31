<?php declare(strict_types=1);

namespace TictactoeApi\Model;

final class GetLeaderboardQueryParams
{
    public function __construct(
        public ?string $timeframe = 'all-time',
        public ?int $limit = 10,
    ) {}

    /** @param array<string, mixed> $query */
    public static function fromQuery(array $query): self
    {
        return new self(
            timeframe: $query['timeframe'] ?? 'all-time',
            limit: isset($query['limit']) ? (int) $query['limit'] : 10,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'timeframe' => $this->timeframe,
            'limit' => $this->limit,
        ];
    }
}
