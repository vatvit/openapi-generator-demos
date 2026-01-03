<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * GameListResponse
 *
 * 
 *
 * @generated
 */
class GameListResponse
{
    /**
     * @var array<mixed>
     */
    public array $games;

    /**
     */
    public \TicTacToe\Model\Pagination $pagination;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->games = $data['games'] ?? throw new \InvalidArgumentException('Missing required parameter: games');
        $this->pagination = $data['pagination'] ?? throw new \InvalidArgumentException('Missing required parameter: pagination');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'games' => $data['games'] ?? null,
            'pagination' => $data['pagination'] ?? null,
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
            'games' => $this->games,
            'pagination' => $this->pagination,
        ];
    }
}
