<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class Leaderboard
{
    public string $timeframe;
    /** @var array<mixed> */
    public array $entries;
    /**
     * When this leaderboard was generated
     */
    public \DateTime $generatedAt;

    /**
     * @param array<mixed> $entries
     */
    public function __construct(
        string $timeframe,
        array $entries,
        \DateTime $generatedAt,
    ) {
        $this->timeframe = $timeframe;
        $this->entries = $entries;
        $this->generatedAt = $generatedAt;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            timeframe: $data['timeframe'],
            entries: $data['entries'],
            generatedAt: isset($data['generatedAt']) ? new \DateTime($data['generatedAt']) : throw new \InvalidArgumentException('generatedAt is required'),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'timeframe' => $this->timeframe,
            'entries' => $this->entries,
            'generatedAt' => $this->generatedAt->format(\DateTime::ATOM),
        ];
    }
}
