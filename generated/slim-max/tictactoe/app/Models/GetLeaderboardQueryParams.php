<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * GetLeaderboardQueryParams
 *
 * Query parameters DTO for getLeaderboard operation.
 *
 * @generated
 */
final class GetLeaderboardQueryParams
{
    /**
     * Timeframe for leaderboard statistics
     */
    public ?string $timeframe = 'all-time';
    /**
     * Number of top players to return
     */
    public ?int $limit = 10;

    /**
     */
    public function __construct(
        ?string $timeframe = 'all-time',
        ?int $limit = 10,
    ) {
        $this->timeframe = $timeframe;
        $this->limit = $limit;
    }

    /**
     * Create from query parameters array
     *
     * @param array<string, mixed> $queryParams
     */
    public static function fromQueryParams(array $queryParams): self
    {
        return new self(
            timeframe: $queryParams['timeframe'] ?? 'all-time',
            limit: isset($queryParams['limit']) ? (int) $queryParams['limit'] : 10,
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
            'timeframe' => $this->timeframe,
            'limit' => $this->limit,
        ];
    }
}
