<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateGameRequest
{
    #[Assert\NotBlank]
    public \TictactoeApi\Model\GameMode $mode;
    /**
     * Opponent player ID (required for PvP mode)
     */
    #[Assert\Type('string')]



    #[Assert\Uuid]
    public ?string $opponentId = null;
    /**
     * Whether the game is private
     */
    #[Assert\Type('bool')]
    public bool $isPrivate = false;
    /**
     * Additional game metadata
     * @var array<string, mixed>|null
     */
    public ?array $metadata = null;

    /**
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        \TictactoeApi\Model\GameMode $mode,
        ?string $opponentId = null,
        bool $isPrivate = false,
        ?array $metadata = null,
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
