<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * PlayerStats model.
 */
class PlayerStats
{
    public string $player_id;

    public ?\TicTacToeApi\Model\Player $player = null;

    /**
     * Total games played
     */
    public int $games_played;

    /**
     * Total wins
     */
    public int $wins;

    /**
     * Total losses
     */
    public int $losses;

    /**
     * Total draws
     */
    public int $draws;

    /**
     * Win rate (0.0 to 1.0)
     */
    public ?float $win_rate = null;

    /**
     * Current win/loss streak (positive for wins, negative for losses)
     */
    public ?int $current_streak = null;

    /**
     * Longest win streak
     */
    public ?int $longest_win_streak = null;

    /**
     * Create a new PlayerStats instance.
     */
    public function __construct(
        string $player_id,
        int $games_played,
        int $wins,
        int $losses,
        int $draws,
        ?\TicTacToeApi\Model\Player $player = null,
        ?float $win_rate = null,
        ?int $current_streak = null,
        ?int $longest_win_streak = null
    ) {
        $this->player_id = $player_id;
        $this->player = $player;
        $this->games_played = $games_played;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->draws = $draws;
        $this->win_rate = $win_rate;
        $this->current_streak = $current_streak;
        $this->longest_win_streak = $longest_win_streak;
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
            player_id: $data['playerId'] ?? throw new \InvalidArgumentException('playerId is required'),
            player: $data['player'] ?? null,
            games_played: $data['gamesPlayed'] ?? throw new \InvalidArgumentException('gamesPlayed is required'),
            wins: $data['wins'] ?? throw new \InvalidArgumentException('wins is required'),
            losses: $data['losses'] ?? throw new \InvalidArgumentException('losses is required'),
            draws: $data['draws'] ?? throw new \InvalidArgumentException('draws is required'),
            win_rate: $data['winRate'] ?? null,
            current_streak: $data['currentStreak'] ?? null,
            longest_win_streak: $data['longestWinStreak'] ?? null
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
            'playerId' => $this->player_id,
            'player' => $this->player,
            'gamesPlayed' => $this->games_played,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'winRate' => $this->win_rate,
            'currentStreak' => $this->current_streak,
            'longestWinStreak' => $this->longest_win_streak
        ];
    }
}
