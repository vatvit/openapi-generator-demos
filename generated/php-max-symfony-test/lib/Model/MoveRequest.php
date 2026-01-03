<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * MoveRequest
 *
 * 
 *
 * @generated
 */
class MoveRequest
{
    /**
     * Mark to place on the board
     */
    #[Assert\NotNull]
    public string $mark;

    /**
     * Constructor
     */
    public function __construct(
        string $mark,
    ) {
        $this->mark = $mark;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            mark: $data['mark'] ?? null,
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
            'mark' => $this->mark,
        ];
    }
}

