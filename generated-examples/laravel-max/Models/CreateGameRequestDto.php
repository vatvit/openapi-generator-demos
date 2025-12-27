<?php

declare(strict_types=1);

namespace App\Models;

/**
 * CreateGameRequest DTO
 *
 * Auto-generated from OpenAPI schema: CreateGameRequest
 * Typed data transfer object for type-safe handler method signatures
 */
class CreateGameRequestDto
{
    /**
     * @param string $mode Game mode: "single-player" | "two-player"
     * @param string $playerXId Player X identifier
     * @param string|null $playerOId Player O identifier (required for two-player)
     */
    public function __construct(
        public string $mode,
        public string $playerXId,
        public ?string $playerOId = null,
    ) {}

    /**
     * Create DTO from validated array data
     *
     * @param array<string, mixed> $data Validated request data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            mode: $data['mode'],
            playerXId: $data['playerXId'],
            playerOId: $data['playerOId'] ?? null,
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
            'mode' => $this->mode,
            'playerXId' => $this->playerXId,
            'playerOId' => $this->playerOId,
        ];
    }
}
