<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * NewPet
 *
 * 
 *
 * @generated
 */
class NewPet
{
    /**
     */
    public string $name;

    /**
     */
    public ?string $tag = null;

    /**
     * Constructor
     */
    public function __construct(
        string $name,
        ?string $tag = null,
    ) {
        $this->name = $name;
        $this->tag = $tag;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            tag: $data['tag'] ?? null,
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
            'name' => $this->name,
            'tag' => $this->tag,
        ];
    }
}
