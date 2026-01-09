<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Player model.
 */
class Player
{
    /**
     * Unique player identifier
     */
    public string $id;

    /**
     * Player username
     */
    public string $username;

    /**
     * Player display name
     */
    public ?string $display_name = null;

    /**
     * URL to player avatar image
     */
    public ?string $avatar_url = null;

    /**
     * Create a new Player instance.
     */
    public function __construct(
        string $id,
        string $username,
        ?string $display_name = null,
        ?string $avatar_url = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->display_name = $display_name;
        $this->avatar_url = $avatar_url;
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
            id: $data['id'] ?? throw new \InvalidArgumentException('id is required'),
            username: $data['username'] ?? throw new \InvalidArgumentException('username is required'),
            display_name: $data['displayName'] ?? null,
            avatar_url: $data['avatarUrl'] ?? null
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
            'id' => $this->id,
            'username' => $this->username,
            'displayName' => $this->display_name,
            'avatarUrl' => $this->avatar_url
        ];
    }
}
