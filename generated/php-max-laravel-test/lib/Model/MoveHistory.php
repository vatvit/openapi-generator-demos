<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * MoveHistory
 *
 * 
 *
 * @generated
 */
class MoveHistory
{
    /**
     */
    public string $game_id;

    /**
     * @var array<mixed>
     */
    public array $moves;

    /**
     * Constructor
     */
    public function __construct(
        string $game_id,
        array $moves,
    ) {
        $this->game_id = $game_id;
        $this->moves = $moves;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            game_id: $data['gameId'] ?? null,
            moves: $data['moves'] ?? null,
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
            'gameId' => $this->game_id,
            'moves' => $this->moves,
        ];
    }
}
