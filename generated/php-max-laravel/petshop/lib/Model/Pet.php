<?php

declare(strict_types=1);

namespace PetshopApi\Model;

class Pet
{
    public string $name;
    public ?string $tag = null;
    public int $id;

    /**
     */
    public function __construct(
        string $name,
        ?string $tag = null,
        int $id,
    ) {
        $this->name = $name;
        $this->tag = $tag;
        $this->id = $id;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            tag: $data['tag'] ?? null,
            id: $data['id'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'tag' => $this->tag,
            'id' => $this->id,
        ];
    }
}
