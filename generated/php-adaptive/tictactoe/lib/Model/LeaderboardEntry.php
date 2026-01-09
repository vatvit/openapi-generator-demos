<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * LeaderboardEntry model.
 */
class LeaderboardEntry
{
    /**
     * Leaderboard rank
     */
    public int $rank;

    public \TicTacToeApi\Model\Player $player;

    /**
     * Total score
     */
    public int $score;

    public int $wins;

    public ?int $games_played = null;

    /**
     * Create a new LeaderboardEntry instance.
     */
    public function __construct(
        int $rank,
        \TicTacToeApi\Model\Player $player,
        int $score,
        int $wins,
        ?int $games_played = null
    ) {
        $this->rank = $rank;
        $this->player = $player;
        $this->score = $score;
        $this->wins = $wins;
        $this->games_played = $games_played;
    }

    /**
     * Create instance from array data.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            rank: $data['rank'] ?? throw new \InvalidArgumentException('rank is required'),
            player: $data['player'] ?? throw new \InvalidArgumentException('player is required'),
            score: $data['score'] ?? throw new \InvalidArgumentException('score is required'),
            wins: $data['wins'] ?? throw new \InvalidArgumentException('wins is required'),
            games_played: $data['gamesPlayed'] ?? null
        );
    }

    /**
     * Convert instance to array.
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
            'gamesPlayed' => $this->games_played
        ];
    }
}
