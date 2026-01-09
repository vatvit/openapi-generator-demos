<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

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
     */
    public ?\TictactoeApi\Model\Player $player = null;

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
     */
    public function __construct(
        string $player_id,
        int $games_played,
        int $wins,
        int $losses,
        int $draws,
        ?\TictactoeApi\Model\Player $player = null,
        ?float $win_rate = null,
        ?int $current_streak = null,
        ?int $longest_win_streak = null,
    ) {
        $this->player_id = $player_id;
        $this->games_played = $games_played;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->draws = $draws;
        $this->player = $player;
        $this->win_rate = $win_rate;
        $this->current_streak = $current_streak;
        $this->longest_win_streak = $longest_win_streak;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            player_id: $data['playerId'] ?? null,
            games_played: $data['gamesPlayed'] ?? null,
            wins: $data['wins'] ?? null,
            losses: $data['losses'] ?? null,
            draws: $data['draws'] ?? null,
            player: $data['player'] ?? null,
            win_rate: $data['winRate'] ?? null,
            current_streak: $data['currentStreak'] ?? null,
            longest_win_streak: $data['longestWinStreak'] ?? null,
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
            'playerId' => $this->player_id,
            'gamesPlayed' => $this->games_played,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'player' => $this->player,
            'winRate' => $this->win_rate,
            'currentStreak' => $this->current_streak,
            'longestWinStreak' => $this->longest_win_streak,
        ];
    }
}
