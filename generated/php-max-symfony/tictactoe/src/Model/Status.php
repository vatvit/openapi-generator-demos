<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Current game status including board state and winner
 */
final class Status
{
    #[Assert\NotBlank]
    public \TictactoeApi\Model\Winner $winner;
    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    #[Assert\NotBlank]
    #[Assert\Type('array')]
    #[Assert\Count(min: 3)]
    #[Assert\Count(max: 3)]
    public array $board;

    /**
     * @param array<mixed> $board
     */
    public function __construct(
        \TictactoeApi\Model\Winner $winner,
        array $board,
    ) {
        $this->winner = $winner;
        $this->board = $board;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            winner: \TictactoeApi\Model\Winner::from($data['winner']),
            board: $data['board'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'winner' => $this->winner,
            'board' => $this->board,
        ];
    }
}
