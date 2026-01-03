<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class LeaderboardEntry
{
    /**
     * Leaderboard rank
     */
    public int $rank;
    public \TictactoeApi\Model\Player $player;
    /**
     * Total score
     */
    public int $score;
    public int $wins;
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
