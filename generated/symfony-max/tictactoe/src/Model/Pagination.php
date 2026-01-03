<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class Pagination
{
    /**
     * Current page number
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(1)]
    public int $page;
    /**
     * Items per page
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(1)]
    public int $limit;
    /**
     * Total number of items
     */
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $total;
    /**
     * Whether there is a next page
     */
    #[Assert\Type('bool')]
    public ?bool $hasNext = null;
    /**
     * Whether there is a previous page
     */
    #[Assert\Type('bool')]
    public ?bool $hasPrevious = null;

    /**
     */
    public function __construct(
        int $page,
        int $limit,
        int $total,
        ?bool $hasNext = null,
        ?bool $hasPrevious = null,
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->total = $total;
        $this->hasNext = $hasNext;
        $this->hasPrevious = $hasPrevious;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            page: $data['page'],
            limit: $data['limit'],
            total: $data['total'],
            hasNext: $data['hasNext'] ?? null,
            hasPrevious: $data['hasPrevious'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
            'total' => $this->total,
            'hasNext' => $this->hasNext,
            'hasPrevious' => $this->hasPrevious,
        ];
    }
}
