<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

class CreateGameRequest
{
    public \TictactoeApi\Model\GameMode $mode;
    /**
     * Opponent player ID (required for PvP mode)
     */
    public ?string $opponentId = null;
    /**
     * Whether the game is private
     */
    public bool $isPrivate = false;
    /**
     * Additional game metadata
     * @var array<string, mixed>|null
     */
    public mixed $metadata = null;

    /**
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        \TictactoeApi\Model\GameMode $mode,
        ?string $opponentId = null,
        bool $isPrivate = false,
        mixed $metadata = null,
    ) {
        $this->mode = $mode;
        $this->opponentId = $opponentId;
        $this->isPrivate = $isPrivate;
        $this->metadata = $metadata;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            mode: \TictactoeApi\Model\GameMode::from($data['mode']),
            opponentId: $data['opponentId'] ?? null,
            isPrivate: $data['isPrivate'] ?? false,
            metadata: $data['metadata'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'mode' => $this->mode,
            'opponentId' => $this->opponentId,
            'isPrivate' => $this->isPrivate,
            'metadata' => $this->metadata,
        ];
    }
}
