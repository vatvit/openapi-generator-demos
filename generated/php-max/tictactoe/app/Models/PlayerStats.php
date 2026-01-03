<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class PlayerStats
{
    public string $playerId;
    /**
     * Total games played
     */
    public int $gamesPlayed;
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
    public ?\TictactoeApi\Model\Player $player = null;
    /**
     * Win rate (0.0 to 1.0)
     */
    public ?float $winRate = null;
    /**
     * Current win/loss streak (positive for wins, negative for losses)
     */
    public ?int $currentStreak = null;
    /**
     * Longest win streak
     */
    public ?int $longestWinStreak = null;

    /**
     */
    public function __construct(
        string $playerId,
        int $gamesPlayed,
        int $wins,
        int $losses,
        int $draws,
        ?\TictactoeApi\Model\Player $player = null,
        ?float $winRate = null,
        ?int $currentStreak = null,
        ?int $longestWinStreak = null,
    ) {
        $this->playerId = $playerId;
        $this->gamesPlayed = $gamesPlayed;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->draws = $draws;
        $this->player = $player;
        $this->winRate = $winRate;
        $this->currentStreak = $currentStreak;
        $this->longestWinStreak = $longestWinStreak;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            playerId: $data['playerId'],
            gamesPlayed: $data['gamesPlayed'],
            wins: $data['wins'],
            losses: $data['losses'],
            draws: $data['draws'],
            player: $data['player'] ?? null,
            winRate: $data['winRate'] ?? null,
            currentStreak: $data['currentStreak'] ?? null,
            longestWinStreak: $data['longestWinStreak'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'playerId' => $this->playerId,
            'gamesPlayed' => $this->gamesPlayed,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'player' => $this->player,
            'winRate' => $this->winRate,
            'currentStreak' => $this->currentStreak,
            'longestWinStreak' => $this->longestWinStreak,
        ];
    }
}
