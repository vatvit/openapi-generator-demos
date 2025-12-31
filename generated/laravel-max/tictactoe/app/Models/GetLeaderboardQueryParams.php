<?php declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * GetLeaderboardQueryParams
 *
 * Auto-generated Query Parameters DTO for getLeaderboard operation
 * Typed query parameters with defaults
 *
 * OpenAPI Operation: getLeaderboard
 * HTTP Method: GET /leaderboard
 */
class GetLeaderboardQueryParams
{
    /**
     * @param ?string $timeframe Timeframe for leaderboard statistics
     * @param ?int $limit Number of top players to return
     */
    public function __construct(
        public ?string $timeframe = 'all-time',
        public ?int $limit = 10,
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
            timeframe: $query['timeframe'] ?? 'all-time',
            limit: isset($query['limit']) ? (int) $query['limit'] : 10,
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
            'timeframe' => $this->timeframe,
            'limit' => $this->limit,
        ];
    }
}
