<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Status
 *
 * Current game status including board state and winner
 *
 * Auto-generated model from OpenAPI specification.
 */

class Status 
{
        /**
     * @var Winner|null
     * @SerializedName("winner")
    * @Accessor(getter="getSerializedWinner", setter="setDeserializedWinner")
    * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    protected ?Winner $winner = null;

    /**
     * 3x3 game board represented as nested arrays
     *
     * @var Mark[]|null
     * @SerializedName("board")
     * @Type("array<TictactoeApi\Model\Mark>")
    */
    #[Assert\NotNull]
    #[Assert\All([
        new Assert\Type("TictactoeApi\Model\Mark"),
    ])]
    #[Assert\Count(max: 3)]
    #[Assert\Count(min: 3)]
    protected ?array $board = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->winner = array_key_exists('winner', $data) ? $data['winner'] : $this->winner;
            $this->board = array_key_exists('board', $data) ? $data['board'] : $this->board;
        }
    }

    /**
     * Gets winner.
     *
     * @return Winner|null
     */
    public function getWinner(): ?Winner
    {
        return $this->winner;
    }

    /**
    * Sets winner.
    *
    * @param Winner|null $winner
    *
    * @return $this
    */
    public function setWinner(?Winner $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    /**
    * Gets winner for serialization.
    *
    * @return string|null
    */
    public function getSerializedWinner(): string|null
    {
        return !is_null($this->winner?->value) ? (string) $this->winner->value : null;
    }

    /**
    * Sets winner.
    *
    * @param string|Winner|null $winner
    *
    * @return $this
    */
    public function setDeserializedWinner(string|Winner|null $winner): self
    {
        if (is_string($winner)) {
            $winner = Winner::tryFrom($winner);
        }

        $this->winner = $winner;

        return $this;
    }



    /**
     * Gets board.
     *
     * @return Mark[]|null
     */
    public function getBoard(): ?array
    {
        return $this->board;
    }

    /**
    * Sets board.
    *
    * @param Mark[]|null $board  3x3 game board represented as nested arrays
    *
    * @return $this
    */
    public function setBoard(?array $board): self
    {
        $this->board = $board;

        return $this;
    }



}


