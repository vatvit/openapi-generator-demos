<?php

declare(strict_types=1);

namespace PetshopApi\Model;

/**
 * Pet model.
 */
class Pet
{
    public string $name;

    public ?string $tag = null;

    public int $id;

    /**
     * Create a new Pet instance.
     */
    public function __construct(
        string $name,
        int $id,
        ?string $tag = null
    ) {
        $this->name = $name;
        $this->tag = $tag;
        $this->id = $id;
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
            name: $data['name'] ?? throw new \InvalidArgumentException('name is required'),
            tag: $data['tag'] ?? null,
            id: $data['id'] ?? throw new \InvalidArgumentException('id is required')
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
            'name' => $this->name,
            'tag' => $this->tag,
            'id' => $this->id
        ];
    }
}
