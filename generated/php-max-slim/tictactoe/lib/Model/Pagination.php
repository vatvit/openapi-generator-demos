<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * Pagination
 *
 * 
 *
 * @generated
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
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->page = $data['page'] ?? throw new \InvalidArgumentException('Missing required parameter: page');
        $this->limit = $data['limit'] ?? throw new \InvalidArgumentException('Missing required parameter: limit');
        $this->total = $data['total'] ?? throw new \InvalidArgumentException('Missing required parameter: total');
        $this->has_next = $data['has_next'] ?? null;
        $this->has_previous = $data['has_previous'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'page' => $data['page'] ?? null,
            'limit' => $data['limit'] ?? null,
            'total' => $data['total'] ?? null,
            'has_next' => $data['hasNext'] ?? null,
            'has_previous' => $data['hasPrevious'] ?? null,
        ]);
    }

    /**
     * Convert to array
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
            'hasPrevious' => $this->has_previous,
        ];
    }
}
