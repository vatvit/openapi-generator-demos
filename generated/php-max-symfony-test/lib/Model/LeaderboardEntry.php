<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * LeaderboardEntry
 *
 * 
 *
 * @generated
 */
class LeaderboardEntry
{
    /**
     * Leaderboard rank
     */
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(1)]
    public int $rank;

    /**
     */
    #[Assert\NotNull]
    public \TictactoeApi\Model\Player $player;

    /**
     * Total score
     */
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(0)]
    public int $score;

    /**
     */
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(0)]
    public int $wins;

    /**
     */
    #[Assert\GreaterThanOrEqual(0)]
    public ?int $games_played = null;

    /**
     * Constructor
     */
    public function __construct(
        int $rank,
        \TictactoeApi\Model\Player $player,
        int $score,
        int $wins,
        ?int $games_played = null,
    ) {
        $this->rank = $rank;
        $this->player = $player;
        $this->score = $score;
        $this->wins = $wins;
        $this->games_played = $games_played;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            rank: $data['rank'] ?? null,
            player: $data['player'] ?? null,
            score: $data['score'] ?? null,
            wins: $data['wins'] ?? null,
            games_played: $data['gamesPlayed'] ?? null,
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
            'rank' => $this->rank,
            'player' => $this->player,
            'score' => $this->score,
            'wins' => $this->wins,
            'gamesPlayed' => $this->games_played,
        ];
    }
}

