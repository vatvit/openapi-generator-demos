<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * MoveHistory model.
 */
class MoveHistory
{
    public string $game_id;

    /** @var array<mixed> */
    public array $moves;

    /**
     * Create a new MoveHistory instance.
     * @param array<mixed> $moves
     */
    public function __construct(
        string $game_id,
        array $moves,
    ) {
        $this->game_id = $game_id;
        $this->moves = $moves;
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
            game_id: $data['gameId'] ?? throw new \InvalidArgumentException('gameId is required'),
            moves: $data['moves'] ?? throw new \InvalidArgumentException('moves is required')
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
            'gameId' => $this->game_id,
            'moves' => $this->moves
        ];
    }
}
