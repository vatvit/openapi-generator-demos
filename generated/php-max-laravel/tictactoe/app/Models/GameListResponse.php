<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class GameListResponse
{
    /** @var array<mixed> */
    public array $games;
    public \TictactoeApi\Model\Pagination $pagination;

    /**
     * @param array<mixed> $games
     */
    public function __construct(
        array $games,
        \TictactoeApi\Model\Pagination $pagination,
    ) {
        $this->games = $games;
        $this->pagination = $pagination;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            games: $data['games'],
            pagination: $data['pagination'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'games' => $this->games,
            'pagination' => $this->pagination,
        ];
    }
}
