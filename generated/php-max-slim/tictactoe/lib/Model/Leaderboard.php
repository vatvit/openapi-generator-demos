<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->timeframe = $data['timeframe'] ?? throw new \InvalidArgumentException('Missing required parameter: timeframe');
        $this->entries = $data['entries'] ?? throw new \InvalidArgumentException('Missing required parameter: entries');
        $this->generated_at = $data['generated_at'] ?? throw new \InvalidArgumentException('Missing required parameter: generated_at');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'timeframe' => $data['timeframe'] ?? null,
            'entries' => $data['entries'] ?? null,
            'generated_at' => $data['generatedAt'] ?? null,
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
            'timeframe' => $this->timeframe,
            'entries' => $this->entries,
            'generatedAt' => $this->generated_at,
        ];
    }
}
