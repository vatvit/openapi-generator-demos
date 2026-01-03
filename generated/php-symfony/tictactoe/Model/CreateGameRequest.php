<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CreateGameRequest
 *
 * Auto-generated model from OpenAPI specification.
 */

class CreateGameRequest 
{
        /**
     * @var GameMode|null
     * @SerializedName("mode")
    * @Accessor(getter="getSerializedMode", setter="setDeserializedMode")
    * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    protected ?GameMode $mode = null;

    /**
     * Opponent player ID (required for PvP mode)
     *
     * @var string|null
     * @SerializedName("opponentId")
     * @Type("string")
    */
    #[Assert\Type("string")]
    protected ?string $opponentId = null;

    /**
     * Whether the game is private
     *
     * @var bool|null
     * @SerializedName("isPrivate")
     * @Type("bool")
    */
    #[Assert\Type("bool")]
    protected ?bool $isPrivate = false;

    /**
     * Additional game metadata
     *
     * @var []|null
     * @SerializedName("metadata")
     * @Type("array<string, AnyType>")
    */
    #[Assert\All([
        new Assert\Type("AnyType"),
    ])]
    protected ?array $metadata = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->mode = array_key_exists('mode', $data) ? $data['mode'] : $this->mode;
            $this->opponentId = array_key_exists('opponentId', $data) ? $data['opponentId'] : $this->opponentId;
            $this->isPrivate = array_key_exists('isPrivate', $data) ? $data['isPrivate'] : $this->isPrivate;
            $this->metadata = array_key_exists('metadata', $data) ? $data['metadata'] : $this->metadata;
        }
    }

    /**
     * Gets mode.
     *
     * @return GameMode|null
     */
    public function getMode(): ?GameMode
    {
        return $this->mode;
    }

    /**
    * Sets mode.
    *
    * @param GameMode|null $mode
    *
    * @return $this
    */
    public function setMode(?GameMode $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
    * Gets mode for serialization.
    *
    * @return string|null
    */
    public function getSerializedMode(): string|null
    {
        return !is_null($this->mode?->value) ? (string) $this->mode->value : null;
    }

    /**
    * Sets mode.
    *
    * @param string|GameMode|null $mode
    *
    * @return $this
    */
    public function setDeserializedMode(string|GameMode|null $mode): self
    {
        if (is_string($mode)) {
            $mode = GameMode::tryFrom($mode);
        }

        $this->mode = $mode;

        return $this;
    }



    /**
     * Gets opponentId.
     *
     * @return string|null
     */
    public function getOpponentId(): ?string
    {
        return $this->opponentId;
    }

    /**
    * Sets opponentId.
    *
    * @param string|null $opponentId  Opponent player ID (required for PvP mode)
    *
    * @return $this
    */
    public function setOpponentId(?string $opponentId = null): self
    {
        $this->opponentId = $opponentId;

        return $this;
    }




    /**
     * Gets isPrivate.
     *
     * @return bool|null
     */
    public function isIsPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    /**
    * Sets isPrivate.
    *
    * @param bool|null $isPrivate  Whether the game is private
    *
    * @return $this
    */
    public function setIsPrivate(?bool $isPrivate = null): self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }




    /**
     * Gets metadata.
     *
     * @return []|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
    * Sets metadata.
    *
    * @param []|null $metadata  Additional game metadata
    *
    * @return $this
    */
    public function setMetadata(?array $metadata = null): self
    {
        $this->metadata = $metadata;

        return $this;
    }



}


