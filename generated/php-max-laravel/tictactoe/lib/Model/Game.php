<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

class Game
{
    /**
     * Unique game identifier
     */
    public string $id;
    public \TictactoeApi\Model\GameStatus $status;
    public \TictactoeApi\Model\GameMode $mode;
    /**
     * Player assigned to X marks
     */
    public ?\TictactoeApi\Model\Player $playerX = null;
    /**
     * Player assigned to O marks
     */
    public ?\TictactoeApi\Model\Player $playerO = null;
    public ?\TictactoeApi\Model\Mark $currentTurn = null;
    public ?\TictactoeApi\Model\Winner $winner = null;
    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    public \TictactoeApi\Model\Mark[][] $board;
    /**
     * Game creation timestamp
     */
    public \DateTime $createdAt;
    /**
     * Last update timestamp
     */
    public ?\DateTime $updatedAt = null;
    /**
     * Game completion timestamp
     */
    public ?\DateTime $completedAt = null;

    /**
     * @param array<mixed> $board
     */
    public function __construct(
        string $id,
        \TictactoeApi\Model\GameStatus $status,
        \TictactoeApi\Model\GameMode $mode,
        ?\TictactoeApi\Model\Player $playerX = null,
        ?\TictactoeApi\Model\Player $playerO = null,
        ?\TictactoeApi\Model\Mark $currentTurn = null,
        ?\TictactoeApi\Model\Winner $winner = null,
        \TictactoeApi\Model\Mark[][] $board,
        \DateTime $createdAt,
        ?\DateTime $updatedAt = null,
        ?\DateTime $completedAt = null,
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->mode = $mode;
        $this->playerX = $playerX;
        $this->playerO = $playerO;
        $this->currentTurn = $currentTurn;
        $this->winner = $winner;
        $this->board = $board;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->completedAt = $completedAt;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: \TictactoeApi\Model\GameStatus::from($data['status']),
            mode: \TictactoeApi\Model\GameMode::from($data['mode']),
            playerX: $data['playerX'] ?? null,
            playerO: $data['playerO'] ?? null,
            currentTurn: isset($data['currentTurn']) ? \TictactoeApi\Model\Mark::from($data['currentTurn']) : null,
            winner: isset($data['winner']) ? \TictactoeApi\Model\Winner::from($data['winner']) : null,
            board: $data['board'],
            createdAt: isset($data['createdAt']) ? new \DateTime($data['createdAt']) : throw new \InvalidArgumentException('createdAt is required'),
            updatedAt: isset($data['updatedAt']) ? new \DateTime($data['updatedAt']) : null,
            completedAt: isset($data['completedAt']) ? new \DateTime($data['completedAt']) : null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'mode' => $this->mode,
            'playerX' => $this->playerX,
            'playerO' => $this->playerO,
            'currentTurn' => $this->currentTurn,
            'winner' => $this->winner,
            'board' => $this->board,
            'createdAt' => $this->createdAt->format(\DateTime::ATOM),
            'updatedAt' => $this->updatedAt?->format(\DateTime::ATOM),
            'completedAt' => $this->completedAt?->format(\DateTime::ATOM),
        ];
    }
}
