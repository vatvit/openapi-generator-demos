<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Forbidden error - insufficient permissions
 */
class ForbiddenError
{
    /**
     * Error code
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    public string $code;
    /**
     * Human-readable error message
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]



    public string $message;
    /**
     * Additional error details
     * @var array<string, mixed>|null
     */
    public mixed $details = null;
    /**
     * Error type identifier
     */
    #[Assert\Type('string')]



    #[Assert\Choice(['FORBIDDEN'])]
    public ?string $errorType = null;

    /**
     * @param array<string, mixed>|null $details
     */
    public function __construct(
        string $code,
        string $message,
        mixed $details = null,
        ?string $errorType = null,
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
        $this->errorType = $errorType;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            message: $data['message'],
            details: $data['details'] ?? null,
            errorType: $data['errorType'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details,
            'errorType' => $this->errorType,
        ];
    }
}
