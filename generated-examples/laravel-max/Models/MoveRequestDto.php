<?php

declare(strict_types=1);

namespace LaravelMaxApi\Models;

/**
 * MoveRequestDto
 *
 * Auto-generated from OpenAPI schema: MoveRequest
 * Request data for making a move on the board
 */
class MoveRequestDto
{
    /**
     * @param string $mark Mark to place ("X" or "O")
     */
    public function __construct(
        public string $mark,
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
            mark: $data['mark'],
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
            'mark' => $this->mark,
        ];
    }
}
