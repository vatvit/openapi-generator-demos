<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Game
 *
 * Auto-generated model from OpenAPI specification.
 */

class Game 
{
        /**
     * Unique game identifier
     *
     * @var string|null
     * @SerializedName("id")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $id = null;

    /**
     * @var GameStatus|null
     * @SerializedName("status")
    * @Accessor(getter="getSerializedStatus", setter="setDeserializedStatus")
    * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    protected ?GameStatus $status = null;

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
     * Player assigned to X marks
     *
     * @var Player|null
     * @SerializedName("playerX")
     * @Type("TictactoeApi\Model\Player")
    */
    #[Assert\Type("TictactoeApi\Model\Player")]
    protected ?Player $playerX = null;

    /**
     * Player assigned to O marks
     *
     * @var Player|null
     * @SerializedName("playerO")
     * @Type("TictactoeApi\Model\Player")
    */
    #[Assert\Type("TictactoeApi\Model\Player")]
    protected ?Player $playerO = null;

    /**
     * @var Mark|null
     * @SerializedName("currentTurn")
    * @Accessor(getter="getSerializedCurrentTurn", setter="setDeserializedCurrentTurn")
    * @Type("string")
    */
    protected ?Mark $currentTurn = null;

    /**
     * @var Winner|null
     * @SerializedName("winner")
    * @Accessor(getter="getSerializedWinner", setter="setDeserializedWinner")
    * @Type("string")
    */
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
     * Game creation timestamp
     *
     * @var \DateTime|null
     * @SerializedName("createdAt")
     * @Type("DateTime")
    */
    #[Assert\NotNull]
    #[Assert\Type("\DateTime")]
    protected ?\DateTime $createdAt = null;

    /**
     * Last update timestamp
     *
     * @var \DateTime|null
     * @SerializedName("updatedAt")
     * @Type("DateTime")
    */
    #[Assert\Type("\DateTime")]
    protected ?\DateTime $updatedAt = null;

    /**
     * Game completion timestamp
     *
     * @var \DateTime|null
     * @SerializedName("completedAt")
     * @Type("DateTime")
    */
    #[Assert\Type("\DateTime")]
    protected ?\DateTime $completedAt = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->id = array_key_exists('id', $data) ? $data['id'] : $this->id;
            $this->status = array_key_exists('status', $data) ? $data['status'] : $this->status;
            $this->mode = array_key_exists('mode', $data) ? $data['mode'] : $this->mode;
            $this->playerX = array_key_exists('playerX', $data) ? $data['playerX'] : $this->playerX;
            $this->playerO = array_key_exists('playerO', $data) ? $data['playerO'] : $this->playerO;
            $this->currentTurn = array_key_exists('currentTurn', $data) ? $data['currentTurn'] : $this->currentTurn;
            $this->winner = array_key_exists('winner', $data) ? $data['winner'] : $this->winner;
            $this->board = array_key_exists('board', $data) ? $data['board'] : $this->board;
            $this->createdAt = array_key_exists('createdAt', $data) ? $data['createdAt'] : $this->createdAt;
            $this->updatedAt = array_key_exists('updatedAt', $data) ? $data['updatedAt'] : $this->updatedAt;
            $this->completedAt = array_key_exists('completedAt', $data) ? $data['completedAt'] : $this->completedAt;
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
    * @param string|null $id  Unique game identifier
    *
    * @return $this
    */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }




    /**
     * Gets status.
     *
     * @return GameStatus|null
     */
    public function getStatus(): ?GameStatus
    {
        return $this->status;
    }

    /**
    * Sets status.
    *
    * @param GameStatus|null $status
    *
    * @return $this
    */
    public function setStatus(?GameStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
    * Gets status for serialization.
    *
    * @return string|null
    */
    public function getSerializedStatus(): string|null
    {
        return !is_null($this->status?->value) ? (string) $this->status->value : null;
    }

    /**
    * Sets status.
    *
    * @param string|GameStatus|null $status
    *
    * @return $this
    */
    public function setDeserializedStatus(string|GameStatus|null $status): self
    {
        if (is_string($status)) {
            $status = GameStatus::tryFrom($status);
        }

        $this->status = $status;

        return $this;
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
     * Gets playerX.
     *
     * @return Player|null
     */
    public function getPlayerX(): ?Player
    {
        return $this->playerX;
    }

    /**
    * Sets playerX.
    *
    * @param Player|null $playerX  Player assigned to X marks
    *
    * @return $this
    */
    public function setPlayerX(?Player $playerX = null): self
    {
        $this->playerX = $playerX;

        return $this;
    }




    /**
     * Gets playerO.
     *
     * @return Player|null
     */
    public function getPlayerO(): ?Player
    {
        return $this->playerO;
    }

    /**
    * Sets playerO.
    *
    * @param Player|null $playerO  Player assigned to O marks
    *
    * @return $this
    */
    public function setPlayerO(?Player $playerO = null): self
    {
        $this->playerO = $playerO;

        return $this;
    }




    /**
     * Gets currentTurn.
     *
     * @return Mark|null
     */
    public function getCurrentTurn(): ?Mark
    {
        return $this->currentTurn;
    }

    /**
    * Sets currentTurn.
    *
    * @param Mark|null $currentTurn
    *
    * @return $this
    */
    public function setCurrentTurn(?Mark $currentTurn = null): self
    {
        $this->currentTurn = $currentTurn;

        return $this;
    }

    /**
    * Gets currentTurn for serialization.
    *
    * @return string|null
    */
    public function getSerializedCurrentTurn(): string|null
    {
        return !is_null($this->currentTurn?->value) ? (string) $this->currentTurn->value : null;
    }

    /**
    * Sets currentTurn.
    *
    * @param string|Mark|null $currentTurn
    *
    * @return $this
    */
    public function setDeserializedCurrentTurn(string|Mark|null $currentTurn = null): self
    {
        if (is_string($currentTurn)) {
            $currentTurn = Mark::tryFrom($currentTurn);
        }

        $this->currentTurn = $currentTurn;

        return $this;
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
    public function setWinner(?Winner $winner = null): self
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
    public function setDeserializedWinner(string|Winner|null $winner = null): self
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




    /**
     * Gets createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
    * Sets createdAt.
    *
    * @param \DateTime|null $createdAt  Game creation timestamp
    *
    * @return $this
    */
    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }




    /**
     * Gets updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
    * Sets updatedAt.
    *
    * @param \DateTime|null $updatedAt  Last update timestamp
    *
    * @return $this
    */
    public function setUpdatedAt(?\DateTime $updatedAt = null): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }




    /**
     * Gets completedAt.
     *
     * @return \DateTime|null
     */
    public function getCompletedAt(): ?\DateTime
    {
        return $this->completedAt;
    }

    /**
    * Sets completedAt.
    *
    * @param \DateTime|null $completedAt  Game completion timestamp
    *
    * @return $this
    */
    public function setCompletedAt(?\DateTime $completedAt = null): self
    {
        $this->completedAt = $completedAt;

        return $this;
    }



}


