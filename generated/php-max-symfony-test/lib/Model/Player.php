<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Player
 *
 * 
 *
 * @generated
 */
class Player
{
    /**
     * Unique player identifier
     */
    #[Assert\NotNull]
    #[Assert\Uuid]
    public string $id;

    /**
     * Player username
     */
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 50)]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9_-]+$/')]
    public string $username;

    /**
     * Player display name
     */
    #[Assert\Length(max: 100)]
    public ?string $display_name = null;

    /**
     * URL to player avatar image
     */
    #[Assert\Url]
    public ?string $avatar_url = null;

    /**
     * Constructor
     */
    public function __construct(
        string $id,
        string $username,
        ?string $display_name = null,
        ?string $avatar_url = null,
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->display_name = $display_name;
        $this->avatar_url = $avatar_url;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            username: $data['username'] ?? null,
            display_name: $data['displayName'] ?? null,
            avatar_url: $data['avatarUrl'] ?? null,
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
            'id' => $this->id,
            'username' => $this->username,
            'displayName' => $this->display_name,
            'avatarUrl' => $this->avatar_url,
        ];
    }
}

