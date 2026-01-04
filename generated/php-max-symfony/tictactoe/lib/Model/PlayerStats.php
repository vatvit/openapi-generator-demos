<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PlayerStats
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    #[Assert\Uuid]
    public string $playerId;
    #[Assert\Valid]
    public ?\TictactoeApi\Model\Player $player = null;
    /**
     * Total games played
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $gamesPlayed;
    /**
     * Total wins
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $wins;
    /**
     * Total losses
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $losses;
    /**
     * Total draws
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $draws;
    /**
     * Win rate (0.0 to 1.0)
     */
    public ?float $winRate = null;
    /**
     * Current win/loss streak (positive for wins, negative for losses)
     */
    #[Assert\Type('int')]
    public ?int $currentStreak = null;
    /**
     * Longest win streak
     */
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public ?int $longestWinStreak = null;

    /**
     */
    public function __construct(
        string $playerId,
        ?\TictactoeApi\Model\Player $player = null,
        int $gamesPlayed,
        int $wins,
        int $losses,
        int $draws,
        ?float $winRate = null,
        ?int $currentStreak = null,
        ?int $longestWinStreak = null,
    ) {
        $this->playerId = $playerId;
        $this->player = $player;
        $this->gamesPlayed = $gamesPlayed;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->draws = $draws;
        $this->winRate = $winRate;
        $this->currentStreak = $currentStreak;
        $this->longestWinStreak = $longestWinStreak;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            playerId: $data['playerId'],
            player: $data['player'] ?? null,
            gamesPlayed: $data['gamesPlayed'],
            wins: $data['wins'],
            losses: $data['losses'],
            draws: $data['draws'],
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
            'player' => $this->player,
            'gamesPlayed' => $this->gamesPlayed,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'winRate' => $this->winRate,
            'currentStreak' => $this->currentStreak,
            'longestWinStreak' => $this->longestWinStreak,
        ];
    }
}
