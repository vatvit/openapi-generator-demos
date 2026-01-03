<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * Game
 *
 * 
 *
 * @generated
 */
class Game
{
    /**
     * Unique game identifier
     */
    public string $id;

    /**
     */
    public \TicTacToe\Model\GameStatus $status;

    /**
     */
    public \TicTacToe\Model\GameMode $mode;

    /**
     * Player assigned to X marks
     */
    public ?\TicTacToe\Model\Player $player_x = null;

    /**
     * Player assigned to O marks
     */
    public ?\TicTacToe\Model\Player $player_o = null;

    /**
     */
    public ?\TicTacToe\Model\Mark $current_turn = null;

    /**
     */
    public ?\TicTacToe\Model\Winner $winner = null;

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
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? throw new \InvalidArgumentException('Missing required parameter: id');
        $this->status = $data['status'] ?? throw new \InvalidArgumentException('Missing required parameter: status');
        $this->mode = $data['mode'] ?? throw new \InvalidArgumentException('Missing required parameter: mode');
        $this->player_x = $data['player_x'] ?? null;
        $this->player_o = $data['player_o'] ?? null;
        $this->current_turn = $data['current_turn'] ?? null;
        $this->winner = $data['winner'] ?? null;
        $this->board = $data['board'] ?? throw new \InvalidArgumentException('Missing required parameter: board');
        $this->created_at = $data['created_at'] ?? throw new \InvalidArgumentException('Missing required parameter: created_at');
        $this->updated_at = $data['updated_at'] ?? null;
        $this->completed_at = $data['completed_at'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'id' => $data['id'] ?? null,
            'status' => $data['status'] ?? null,
            'mode' => $data['mode'] ?? null,
            'player_x' => $data['playerX'] ?? null,
            'player_o' => $data['playerO'] ?? null,
            'current_turn' => $data['currentTurn'] ?? null,
            'winner' => $data['winner'] ?? null,
            'board' => $data['board'] ?? null,
            'created_at' => $data['createdAt'] ?? null,
            'updated_at' => $data['updatedAt'] ?? null,
            'completed_at' => $data['completedAt'] ?? null,
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
            'id' => $this->id,
            'status' => $this->status,
            'mode' => $this->mode,
            'playerX' => $this->player_x,
            'playerO' => $this->player_o,
            'currentTurn' => $this->current_turn,
            'winner' => $this->winner,
            'board' => $this->board,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'completedAt' => $this->completed_at,
        ];
    }
}
