<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class LeaderboardEntry
{
    /**
     * Leaderboard rank
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(1)]
    public int $rank;
    #[Assert\NotBlank]
    #[Assert\Valid]
    public \TictactoeApi\Model\Player $player;
    /**
     * Total score
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $score;
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $wins;
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public ?int $gamesPlayed = null;

    /**
     */
    public function __construct(
        int $rank,
        \TictactoeApi\Model\Player $player,
        int $score,
        int $wins,
        ?int $gamesPlayed = null,
    ) {
        $this->rank = $rank;
        $this->player = $player;
        $this->score = $score;
        $this->wins = $wins;
        $this->gamesPlayed = $gamesPlayed;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            rank: $data['rank'],
            player: $data['player'],
            score: $data['score'],
            wins: $data['wins'],
            gamesPlayed: $data['gamesPlayed'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'rank' => $this->rank,
            'player' => $this->player,
            'score' => $this->score,
            'wins' => $this->wins,
            'gamesPlayed' => $this->gamesPlayed,
        ];
    }
}
