<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Game model.
 */
class Game
{
    /**
     * Unique game identifier
     */
    public string $id;

    public \TicTacToeApi\Model\GameStatus $status;

    public \TicTacToeApi\Model\GameMode $mode;

    /**
     * Player assigned to X marks
     */
    public ?\TicTacToeApi\Model\Player $player_x = null;

    /**
     * Player assigned to O marks
     */
    public ?\TicTacToeApi\Model\Player $player_o = null;

    public ?\TicTacToeApi\Model\Mark $current_turn = null;

    public ?\TicTacToeApi\Model\Winner $winner = null;

    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    public array $board;

    /**
     * Game creation timestamp
     */
    public \DateTime $created_at;

    /**
     * Last update timestamp
     */
    public ?\DateTime $updated_at = null;

    /**
     * Game completion timestamp
     */
    public ?\DateTime $completed_at = null;

    /**
     * Create a new Game instance.
     * @param array<mixed> $board
     */
    public function __construct(
        string $id,
        \TicTacToeApi\Model\GameStatus $status,
        \TicTacToeApi\Model\GameMode $mode,
        array $board,
        \DateTime $created_at,
        ?\TicTacToeApi\Model\Player $player_x = null,
        ?\TicTacToeApi\Model\Player $player_o = null,
        ?\TicTacToeApi\Model\Mark $current_turn = null,
        ?\TicTacToeApi\Model\Winner $winner = null,
        ?\DateTime $updated_at = null,
        ?\DateTime $completed_at = null
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->mode = $mode;
        $this->player_x = $player_x;
        $this->player_o = $player_o;
        $this->current_turn = $current_turn;
        $this->winner = $winner;
        $this->board = $board;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->completed_at = $completed_at;
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
            id: $data['id'] ?? throw new \InvalidArgumentException('id is required'),
            status: $data['status'] ?? throw new \InvalidArgumentException('status is required'),
            mode: $data['mode'] ?? throw new \InvalidArgumentException('mode is required'),
            player_x: $data['playerX'] ?? null,
            player_o: $data['playerO'] ?? null,
            current_turn: $data['currentTurn'] ?? null,
            winner: $data['winner'] ?? null,
            board: $data['board'] ?? throw new \InvalidArgumentException('board is required'),
            created_at: isset($data['createdAt']) ? new \DateTime($data['createdAt']) : throw new \InvalidArgumentException('createdAt is required'),
            updated_at: isset($data['updatedAt']) ? new \DateTime($data['updatedAt']) : null,
            completed_at: isset($data['completedAt']) ? new \DateTime($data['completedAt']) : null
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
            'id' => $this->id,
            'status' => $this->status,
            'mode' => $this->mode,
            'playerX' => $this->player_x,
            'playerO' => $this->player_o,
            'currentTurn' => $this->current_turn,
            'winner' => $this->winner,
            'board' => $this->board,
            'createdAt' => $this->created_at->format(\DateTimeInterface::ATOM),
            'updatedAt' => $this->updated_at?->format(\DateTimeInterface::ATOM),
            'completedAt' => $this->completed_at?->format(\DateTimeInterface::ATOM)
        ];
    }
}
