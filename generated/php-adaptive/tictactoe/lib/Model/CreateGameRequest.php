<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * CreateGameRequest model.
 */
class CreateGameRequest
{
    public \TicTacToeApi\Model\GameMode $mode;

    /**
     * Opponent player ID (required for PvP mode)
     */
    public ?string $opponent_id = null;

    /**
     * Whether the game is private
     */
    public ?bool $is_private = null;

    /**
     * Additional game metadata
     * @var array<string, mixed>|null
     */
    public ?array $metadata = null;

    /**
     * Create a new CreateGameRequest instance.
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        \TicTacToeApi\Model\GameMode $mode,
        ?string $opponent_id = null,
        ?bool $is_private = null,
        ?array $metadata = null
    ) {
        $this->mode = $mode;
        $this->opponent_id = $opponent_id;
        $this->is_private = $is_private;
        $this->metadata = $metadata;
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
            mode: $data['mode'] ?? throw new \InvalidArgumentException('mode is required'),
            opponent_id: $data['opponentId'] ?? null,
            is_private: $data['isPrivate'] ?? null,
            metadata: $data['metadata'] ?? null
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
            'mode' => $this->mode,
            'opponentId' => $this->opponent_id,
            'isPrivate' => $this->is_private,
            'metadata' => $this->metadata
        ];
    }
}
