<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * CreateGameRequest
 *
 * 
 *
 * @generated
 */
class CreateGameRequest
{
    /**
     */
    public \TicTacToe\Model\GameMode $mode;

    /**
     * Opponent player ID (required for PvP mode)
     */
    public ?string $opponent_id = null;

    /**
     * Whether the game is private
     */
    public ?bool $is_private = false;

    /**
     * Additional game metadata
     * @var mixed
     */
    public ?arraymixed $metadata = null;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->mode = $data['mode'] ?? throw new \InvalidArgumentException('Missing required parameter: mode');
        $this->opponent_id = $data['opponent_id'] ?? null;
        $this->is_private = $data['is_private'] ?? false;
        $this->metadata = $data['metadata'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'mode' => $data['mode'] ?? null,
            'opponent_id' => $data['opponentId'] ?? null,
            'is_private' => $data['isPrivate'] ?? false,
            'metadata' => $data['metadata'] ?? null,
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
            'mode' => $this->mode,
            'opponentId' => $this->opponent_id,
            'isPrivate' => $this->is_private,
            'metadata' => $this->metadata,
        ];
    }
}
