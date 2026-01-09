<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Leaderboard
 *
 * 
 *
 * @generated
 */
class Leaderboard
{
    /**
     */
    public string $timeframe;

    /**
     * @var array<mixed>
     */
    public array $entries;

    /**
     * When this leaderboard was generated
     */
    public \DateTime $generated_at;

    /**
     * Constructor
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
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            timeframe: $data['timeframe'] ?? null,
            entries: $data['entries'] ?? null,
            generated_at: $data['generatedAt'] ?? null,
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
            'timeframe' => $this->timeframe,
            'entries' => $this->entries,
            'generatedAt' => $this->generated_at,
        ];
    }
}
