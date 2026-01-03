<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MoveHistory
 *
 * Auto-generated model from OpenAPI specification.
 */

class MoveHistory 
{
        /**
     * @var string|null
     * @SerializedName("gameId")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $gameId = null;

    /**
     * @var Move[]|null
     * @SerializedName("moves")
     * @Type("array<TictactoeApi\Model\Move>")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    #[Assert\All([
        new Assert\Type("TictactoeApi\Model\Move"),
    ])]
    protected ?array $moves = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->gameId = array_key_exists('gameId', $data) ? $data['gameId'] : $this->gameId;
            $this->moves = array_key_exists('moves', $data) ? $data['moves'] : $this->moves;
        }
    }

    /**
     * Gets gameId.
     *
     * @return string|null
     */
    public function getGameId(): ?string
    {
        return $this->gameId;
    }

    /**
    * Sets gameId.
    *
    * @param string|null $gameId
    *
    * @return $this
    */
    public function setGameId(?string $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }




    /**
     * Gets moves.
     *
     * @return Move[]|null
     */
    public function getMoves(): ?array
    {
        return $this->moves;
    }

    /**
    * Sets moves.
    *
    * @param Move[]|null $moves
    *
    * @return $this
    */
    public function setMoves(?array $moves): self
    {
        $this->moves = $moves;

        return $this;
    }



}


