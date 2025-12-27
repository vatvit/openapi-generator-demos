<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Game DTO
 *
 * Auto-generated from OpenAPI schema: Game
 * Represents a TicTacToe game state
 */
class Game
{
    /**
     * @param string $id Unique game identifier
     * @param string $status Game status: "waiting", "in-progress", "completed"
     * @param string $mode Game mode: "single-player", "two-player"
     * @param string $playerXId Player X identifier
     * @param string|null $playerOId Player O identifier
     * @param string $currentTurn Current turn: "X" | "O"
     * @param string|null $winner Winner: "X" | "O" | "draw" | null
     * @param \DateTime $createdAt Game creation timestamp
     * @param \DateTime $updatedAt Last update timestamp
     */
    public function __construct(
        public string $id,
        public string $status,
        public string $mode,
        public string $playerXId,
        public ?string $playerOId,
        public string $currentTurn,
        public ?string $winner,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
    ) {}

    /**
     * Create DTO from array data
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: $data['status'],
            mode: $data['mode'],
            playerXId: $data['playerXId'],
            playerOId: $data['playerOId'] ?? null,
            currentTurn: $data['currentTurn'],
            winner: $data['winner'] ?? null,
            createdAt: new \DateTime($data['createdAt']),
            updatedAt: new \DateTime($data['updatedAt']),
        );
    }

    /**
     * Convert DTO to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'mode' => $this->mode,
            'playerXId' => $this->playerXId,
            'playerOId' => $this->playerOId,
            'currentTurn' => $this->currentTurn,
            'winner' => $this->winner,
            'createdAt' => $this->createdAt->format(\DateTime::ISO8601),
            'updatedAt' => $this->updatedAt->format(\DateTime::ISO8601),
        ];
    }
}
