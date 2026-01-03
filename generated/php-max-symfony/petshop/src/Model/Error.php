<?php

declare(strict_types=1);

namespace PetshopApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Error
{
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public int $code;
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    public string $message;

    /**
     */
    public function __construct(
        int $code,
        string $message,
    ) {
        $this->code = $code;
        $this->message = $message;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            message: $data['message'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}
