<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class MoveHistory
{
    public string $gameId;
    /** @var array<mixed> */
    public array $moves;

    /**
     * @param array<mixed> $moves
     */
    public function __construct(
        string $gameId,
        array $moves,
    ) {
        $this->gameId = $gameId;
        $this->moves = $moves;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            gameId: $data['gameId'],
            moves: $data['moves'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'gameId' => $this->gameId,
            'moves' => $this->moves,
        ];
    }
}
