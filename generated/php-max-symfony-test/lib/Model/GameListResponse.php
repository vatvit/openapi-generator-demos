<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * GameListResponse
 *
 * 
 *
 * @generated
 */
class GameListResponse
{
    /**
     * @var array<mixed>
     */
    #[Assert\NotNull]
    public array $games;

    /**
     */
    #[Assert\NotNull]
    public \TictactoeApi\Model\Pagination $pagination;

    /**
     * Constructor
     */
    public function __construct(
        array $games,
        \TictactoeApi\Model\Pagination $pagination,
    ) {
        $this->games = $games;
        $this->pagination = $pagination;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            games: $data['games'] ?? null,
            pagination: $data['pagination'] ?? null,
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
            'games' => $this->games,
            'pagination' => $this->pagination,
        ];
    }
}

