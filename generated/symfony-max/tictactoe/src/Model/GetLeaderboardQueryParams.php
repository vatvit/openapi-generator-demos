<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * GetLeaderboardQueryParams
 *
 * Query parameters DTO for getLeaderboard operation.
 * GET /leaderboard
 *
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
final class GetLeaderboardQueryParams
{
    public function __construct(
        /** Timeframe for leaderboard statistics */
        public ?string $timeframe = 'all-time',
        /** Number of top players to return */
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
}
