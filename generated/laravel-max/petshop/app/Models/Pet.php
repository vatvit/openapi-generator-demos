<?php

declare(strict_types=1);

namespace PetshopApi\Model;

final class Pet
{
    public string $name;
    public int $id;
    public ?string $tag = null;

    /**
     */
    public function __construct(
        string $name,
        int $id,
        ?string $tag = null,
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->tag = $tag;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            id: $data['id'],
            tag: $data['tag'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'tag' => $this->tag,
        ];
    }
}
