<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotNull]
    #[Assert\Uuid]
    public string $id;

    /**
     */
    #[Assert\NotNull]
    public \TictactoeApi\Model\GameStatus $status;

    /**
     */
    #[Assert\NotNull]
    public \TictactoeApi\Model\GameMode $mode;

    /**
     * Player assigned to X marks
     */
    public ?\TictactoeApi\Model\Player $player_x = null;

    /**
     * Player assigned to O marks
     */
    public ?\TictactoeApi\Model\Player $player_o = null;

    /**
     */
    public ?\TictactoeApi\Model\Mark $current_turn = null;

    /**
     */
    public ?\TictactoeApi\Model\Winner $winner = null;

    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    #[Assert\NotNull]
    #[Assert\Count(min: 3, max: 3)]
    public array $board;

    /**
     * Game creation timestamp
     */
    #[Assert\NotNull]
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
     */
    public function __construct(
        string $id,
        \TictactoeApi\Model\GameStatus $status,
        \TictactoeApi\Model\GameMode $mode,
        ?\TictactoeApi\Model\Player $player_x = null,
        ?\TictactoeApi\Model\Player $player_o = null,
        ?\TictactoeApi\Model\Mark $current_turn = null,
        ?\TictactoeApi\Model\Winner $winner = null,
        array $board,
        \DateTime $created_at,
        ?\DateTime $updated_at = null,
        ?\DateTime $completed_at = null,
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
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            status: $data['status'] ?? null,
            mode: $data['mode'] ?? null,
            player_x: $data['playerX'] ?? null,
            player_o: $data['playerO'] ?? null,
            current_turn: $data['currentTurn'] ?? null,
            winner: $data['winner'] ?? null,
            board: $data['board'] ?? null,
            created_at: $data['createdAt'] ?? null,
            updated_at: $data['updatedAt'] ?? null,
            completed_at: $data['completedAt'] ?? null,
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

