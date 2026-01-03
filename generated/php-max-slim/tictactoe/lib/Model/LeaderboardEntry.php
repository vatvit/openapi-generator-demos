<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
    public int $rank;

    /**
     */
    public \TicTacToe\Model\Player $player;

    /**
     * Total score
     */
    public int $score;

    /**
     */
    public int $wins;

    /**
     */
    public ?int $games_played = null;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->rank = $data['rank'] ?? throw new \InvalidArgumentException('Missing required parameter: rank');
        $this->player = $data['player'] ?? throw new \InvalidArgumentException('Missing required parameter: player');
        $this->score = $data['score'] ?? throw new \InvalidArgumentException('Missing required parameter: score');
        $this->wins = $data['wins'] ?? throw new \InvalidArgumentException('Missing required parameter: wins');
        $this->games_played = $data['games_played'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'rank' => $data['rank'] ?? null,
            'player' => $data['player'] ?? null,
            'score' => $data['score'] ?? null,
            'wins' => $data['wins'] ?? null,
            'games_played' => $data['gamesPlayed'] ?? null,
        ]);
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
