<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? throw new \InvalidArgumentException('Missing required parameter: id');
        $this->username = $data['username'] ?? throw new \InvalidArgumentException('Missing required parameter: username');
        $this->display_name = $data['display_name'] ?? null;
        $this->avatar_url = $data['avatar_url'] ?? null;
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'id' => $data['id'] ?? null,
            'username' => $data['username'] ?? null,
            'display_name' => $data['displayName'] ?? null,
            'avatar_url' => $data['avatarUrl'] ?? null,
        ]);
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
