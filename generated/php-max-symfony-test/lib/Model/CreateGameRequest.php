<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotNull]
    public \TictactoeApi\Model\GameMode $mode;

    /**
     * Opponent player ID (required for PvP mode)
     */
    #[Assert\Uuid]
    public ?string $opponent_id = null;

    /**
     * Whether the game is private
     */
    public ?bool $is_private = false;

    /**
     * Additional game metadata
     */
    public ?array $metadata = null;

    /**
     * Constructor
     */
    public function __construct(
        \TictactoeApi\Model\GameMode $mode,
        ?string $opponent_id = null,
        ?bool $is_private = false,
        ?array $metadata = null,
    ) {
        $this->mode = $mode;
        $this->opponent_id = $opponent_id;
        $this->is_private = $is_private;
        $this->metadata = $metadata;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            mode: $data['mode'] ?? null,
            opponent_id: $data['opponentId'] ?? null,
            is_private: $data['isPrivate'] ?? false,
            metadata: $data['metadata'] ?? null,
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
            'mode' => $this->mode,
            'opponentId' => $this->opponent_id,
            'isPrivate' => $this->is_private,
            'metadata' => $this->metadata,
        ];
    }
}

