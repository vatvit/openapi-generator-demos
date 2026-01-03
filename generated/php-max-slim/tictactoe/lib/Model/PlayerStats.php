<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * PlayerStats
 *
 * 
 *
 * @generated
 */
class PlayerStats
{
    /**
     */
    public string $player_id;

    /**
     */
    public ?\TicTacToe\Model\Player $player = null;

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
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->player_id = $data['player_id'] ?? throw new \InvalidArgumentException('Missing required parameter: player_id');
        $this->player = $data['player'] ?? null;
        $this->games_played = $data['games_played'] ?? throw new \InvalidArgumentException('Missing required parameter: games_played');
        $this->wins = $data['wins'] ?? throw new \InvalidArgumentException('Missing required parameter: wins');
        $this->losses = $data['losses'] ?? throw new \InvalidArgumentException('Missing required parameter: losses');
        $this->draws = $data['draws'] ?? throw new \InvalidArgumentException('Missing required parameter: draws');
        $this->win_rate = $data['win_rate'] ?? null;
        $this->current_streak = $data['current_streak'] ?? null;
        $this->longest_win_streak = $data['longest_win_streak'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'player_id' => $data['playerId'] ?? null,
            'player' => $data['player'] ?? null,
            'games_played' => $data['gamesPlayed'] ?? null,
            'wins' => $data['wins'] ?? null,
            'losses' => $data['losses'] ?? null,
            'draws' => $data['draws'] ?? null,
            'win_rate' => $data['winRate'] ?? null,
            'current_streak' => $data['currentStreak'] ?? null,
            'longest_win_streak' => $data['longestWinStreak'] ?? null,
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
            'playerId' => $this->player_id,
            'player' => $this->player,
            'gamesPlayed' => $this->games_played,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'winRate' => $this->win_rate,
            'currentStreak' => $this->current_streak,
            'longestWinStreak' => $this->longest_win_streak,
        ];
    }
}
