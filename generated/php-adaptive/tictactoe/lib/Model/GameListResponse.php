<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * GameListResponse model.
 */
class GameListResponse
{
    /** @var array<mixed> */
    public array $games;

    public \TicTacToeApi\Model\Pagination $pagination;

    /**
     * Create a new GameListResponse instance.
     * @param array<mixed> $games
     */
    public function __construct(
        array $games,
        \TicTacToeApi\Model\Pagination $pagination,
    ) {
        $this->games = $games;
        $this->pagination = $pagination;
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
            games: $data['games'] ?? throw new \InvalidArgumentException('games is required'),
            pagination: $data['pagination'] ?? throw new \InvalidArgumentException('pagination is required')
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
            'games' => $this->games,
            'pagination' => $this->pagination
        ];
    }
}
