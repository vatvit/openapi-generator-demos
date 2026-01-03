<?php

declare(strict_types=1);

namespace PetshopApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class NewPet
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    public string $name;
    #[Assert\Type('string')]



    public ?string $tag = null;

    /**
     */
    public function __construct(
        string $name,
        ?string $tag = null,
    ) {
        $this->name = $name;
        $this->tag = $tag;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            tag: $data['tag'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'tag' => $this->tag,
        ];
    }
}
