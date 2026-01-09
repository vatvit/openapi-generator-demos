<?php

declare(strict_types=1);

namespace PetshopApi\Model;

/**
 * NewPet model.
 */
class NewPet
{
    public string $name;

    public ?string $tag = null;

    /**
     * Create a new NewPet instance.
     */
    public function __construct(
        string $name,
        ?string $tag = null
    ) {
        $this->name = $name;
        $this->tag = $tag;
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
            tag: $data['tag'] ?? null
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
            'tag' => $this->tag
        ];
    }
}
