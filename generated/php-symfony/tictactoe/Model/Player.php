<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Player
 *
 * Auto-generated model from OpenAPI specification.
 */

class Player 
{
        /**
     * Unique player identifier
     *
     * @var string|null
     * @SerializedName("id")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $id = null;

    /**
     * Player username
     *
     * @var string|null
     * @SerializedName("username")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    #[Assert\Length(max: 50)]
    #[Assert\Length(min: 3)]
    #[Assert\Regex("/^[a-zA-Z0-9_-]+$/")]
    protected ?string $username = null;

    /**
     * Player display name
     *
     * @var string|null
     * @SerializedName("displayName")
     * @Type("string")
    */
    #[Assert\Type("string")]
    #[Assert\Length(max: 100)]
    protected ?string $displayName = null;

    /**
     * URL to player avatar image
     *
     * @var string|null
     * @SerializedName("avatarUrl")
     * @Type("string")
    */
    #[Assert\Type("string")]
    protected ?string $avatarUrl = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->id = array_key_exists('id', $data) ? $data['id'] : $this->id;
            $this->username = array_key_exists('username', $data) ? $data['username'] : $this->username;
            $this->displayName = array_key_exists('displayName', $data) ? $data['displayName'] : $this->displayName;
            $this->avatarUrl = array_key_exists('avatarUrl', $data) ? $data['avatarUrl'] : $this->avatarUrl;
        }
    }

    /**
     * Gets id.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
    * Sets id.
    *
    * @param string|null $id  Unique player identifier
    *
    * @return $this
    */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }




    /**
     * Gets username.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
    * Sets username.
    *
    * @param string|null $username  Player username
    *
    * @return $this
    */
    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }




    /**
     * Gets displayName.
     *
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
    * Sets displayName.
    *
    * @param string|null $displayName  Player display name
    *
    * @return $this
    */
    public function setDisplayName(?string $displayName = null): self
    {
        $this->displayName = $displayName;

        return $this;
    }




    /**
     * Gets avatarUrl.
     *
     * @return string|null
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    /**
    * Sets avatarUrl.
    *
    * @param string|null $avatarUrl  URL to player avatar image
    *
    * @return $this
    */
    public function setAvatarUrl(?string $avatarUrl = null): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }



}


