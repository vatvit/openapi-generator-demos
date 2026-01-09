<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Pagination model.
 */
class Pagination
{
    /**
     * Current page number
     */
    public int $page;

    /**
     * Items per page
     */
    public int $limit;

    /**
     * Total number of items
     */
    public int $total;

    /**
     * Whether there is a next page
     */
    public ?bool $has_next = null;

    /**
     * Whether there is a previous page
     */
    public ?bool $has_previous = null;

    /**
     * Create a new Pagination instance.
     */
    public function __construct(
        int $page,
        int $limit,
        int $total,
        ?bool $has_next = null,
        ?bool $has_previous = null
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->total = $total;
        $this->has_next = $has_next;
        $this->has_previous = $has_previous;
    }

    /**
     * Create instance from array data.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            page: $data['page'] ?? throw new \InvalidArgumentException('page is required'),
            limit: $data['limit'] ?? throw new \InvalidArgumentException('limit is required'),
            total: $data['total'] ?? throw new \InvalidArgumentException('total is required'),
            has_next: $data['hasNext'] ?? null,
            has_previous: $data['hasPrevious'] ?? null
        );
    }

    /**
     * Convert instance to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'limit' => $this->limit,
            'total' => $this->total,
            'hasNext' => $this->has_next,
            'hasPrevious' => $this->has_previous
        ];
    }
}
