<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Leaderboard model.
 */
class Leaderboard
{
    public string $timeframe;

    /** @var array<mixed> */
    public array $entries;

    /**
     * When this leaderboard was generated
     */
    public \DateTime $generated_at;

    /**
     * Create a new Leaderboard instance.
     * @param array<mixed> $entries
     */
    public function __construct(
        string $timeframe,
        array $entries,
        \DateTime $generated_at,
    ) {
        $this->timeframe = $timeframe;
        $this->entries = $entries;
        $this->generated_at = $generated_at;
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
            timeframe: $data['timeframe'] ?? throw new \InvalidArgumentException('timeframe is required'),
            entries: $data['entries'] ?? throw new \InvalidArgumentException('entries is required'),
            generated_at: isset($data['generatedAt']) ? new \DateTime($data['generatedAt']) : throw new \InvalidArgumentException('generatedAt is required')
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
            'timeframe' => $this->timeframe,
            'entries' => $this->entries,
            'generatedAt' => $this->generated_at->format(\DateTimeInterface::ATOM)
        ];
    }
}
