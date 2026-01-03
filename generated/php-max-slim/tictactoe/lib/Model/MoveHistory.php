<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->game_id = $data['game_id'] ?? throw new \InvalidArgumentException('Missing required parameter: game_id');
        $this->moves = $data['moves'] ?? throw new \InvalidArgumentException('Missing required parameter: moves');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'game_id' => $data['gameId'] ?? null,
            'moves' => $data['moves'] ?? null,
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
            'gameId' => $this->game_id,
            'moves' => $this->moves,
        ];
    }
}
