<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MoveHistory
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    #[Assert\Uuid]
    public string $gameId;
    /** @var array<mixed> */
    #[Assert\NotBlank]
    #[Assert\Type('array')]
    public array $moves;

    /**
     * @param array<mixed> $moves
     */
    public function __construct(
        string $gameId,
        array $moves,
    ) {
        $this->gameId = $gameId;
        $this->moves = $moves;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            gameId: $data['gameId'],
            moves: $data['moves'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'gameId' => $this->gameId,
            'moves' => $this->moves,
        ];
    }
}
