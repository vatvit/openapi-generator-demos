<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlayerStats
 *
 * Auto-generated model from OpenAPI specification.
 */

class PlayerStats 
{
        /**
     * @var string|null
     * @SerializedName("playerId")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $playerId = null;

    /**
     * @var Player|null
     * @SerializedName("player")
     * @Type("TictactoeApi\Model\Player")
    */
    #[Assert\Type("TictactoeApi\Model\Player")]
    protected ?Player $player = null;

    /**
     * Total games played
     *
     * @var int|null
     * @SerializedName("gamesPlayed")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(0)]
    protected ?int $gamesPlayed = null;

    /**
     * Total wins
     *
     * @var int|null
     * @SerializedName("wins")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(0)]
    protected ?int $wins = null;

    /**
     * Total losses
     *
     * @var int|null
     * @SerializedName("losses")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(0)]
    protected ?int $losses = null;

    /**
     * Total draws
     *
     * @var int|null
     * @SerializedName("draws")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(0)]
    protected ?int $draws = null;

    /**
     * Win rate (0.0 to 1.0)
     *
     * @var float|null
     * @SerializedName("winRate")
     * @Type("float")
    */
    #[Assert\Type("float")]
    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\LessThanOrEqual(1)]
    protected ?float $winRate = null;

    /**
     * Current win/loss streak (positive for wins, negative for losses)
     *
     * @var int|null
     * @SerializedName("currentStreak")
     * @Type("int")
    */
    #[Assert\Type("int")]
    protected ?int $currentStreak = null;

    /**
     * Longest win streak
     *
     * @var int|null
     * @SerializedName("longestWinStreak")
     * @Type("int")
    */
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(0)]
    protected ?int $longestWinStreak = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->playerId = array_key_exists('playerId', $data) ? $data['playerId'] : $this->playerId;
            $this->player = array_key_exists('player', $data) ? $data['player'] : $this->player;
            $this->gamesPlayed = array_key_exists('gamesPlayed', $data) ? $data['gamesPlayed'] : $this->gamesPlayed;
            $this->wins = array_key_exists('wins', $data) ? $data['wins'] : $this->wins;
            $this->losses = array_key_exists('losses', $data) ? $data['losses'] : $this->losses;
            $this->draws = array_key_exists('draws', $data) ? $data['draws'] : $this->draws;
            $this->winRate = array_key_exists('winRate', $data) ? $data['winRate'] : $this->winRate;
            $this->currentStreak = array_key_exists('currentStreak', $data) ? $data['currentStreak'] : $this->currentStreak;
            $this->longestWinStreak = array_key_exists('longestWinStreak', $data) ? $data['longestWinStreak'] : $this->longestWinStreak;
        }
    }

    /**
     * Gets playerId.
     *
     * @return string|null
     */
    public function getPlayerId(): ?string
    {
        return $this->playerId;
    }

    /**
    * Sets playerId.
    *
    * @param string|null $playerId
    *
    * @return $this
    */
    public function setPlayerId(?string $playerId): self
    {
        $this->playerId = $playerId;

        return $this;
    }




    /**
     * Gets player.
     *
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
    * Sets player.
    *
    * @param Player|null $player
    *
    * @return $this
    */
    public function setPlayer(?Player $player = null): self
    {
        $this->player = $player;

        return $this;
    }




    /**
     * Gets gamesPlayed.
     *
     * @return int|null
     */
    public function getGamesPlayed(): ?int
    {
        return $this->gamesPlayed;
    }

    /**
    * Sets gamesPlayed.
    *
    * @param int|null $gamesPlayed  Total games played
    *
    * @return $this
    */
    public function setGamesPlayed(?int $gamesPlayed): self
    {
        $this->gamesPlayed = $gamesPlayed;

        return $this;
    }




    /**
     * Gets wins.
     *
     * @return int|null
     */
    public function getWins(): ?int
    {
        return $this->wins;
    }

    /**
    * Sets wins.
    *
    * @param int|null $wins  Total wins
    *
    * @return $this
    */
    public function setWins(?int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }




    /**
     * Gets losses.
     *
     * @return int|null
     */
    public function getLosses(): ?int
    {
        return $this->losses;
    }

    /**
    * Sets losses.
    *
    * @param int|null $losses  Total losses
    *
    * @return $this
    */
    public function setLosses(?int $losses): self
    {
        $this->losses = $losses;

        return $this;
    }




    /**
     * Gets draws.
     *
     * @return int|null
     */
    public function getDraws(): ?int
    {
        return $this->draws;
    }

    /**
    * Sets draws.
    *
    * @param int|null $draws  Total draws
    *
    * @return $this
    */
    public function setDraws(?int $draws): self
    {
        $this->draws = $draws;

        return $this;
    }




    /**
     * Gets winRate.
     *
     * @return float|null
     */
    public function getWinRate(): ?float
    {
        return $this->winRate;
    }

    /**
    * Sets winRate.
    *
    * @param float|null $winRate  Win rate (0.0 to 1.0)
    *
    * @return $this
    */
    public function setWinRate(?float $winRate = null): self
    {
        $this->winRate = $winRate;

        return $this;
    }




    /**
     * Gets currentStreak.
     *
     * @return int|null
     */
    public function getCurrentStreak(): ?int
    {
        return $this->currentStreak;
    }

    /**
    * Sets currentStreak.
    *
    * @param int|null $currentStreak  Current win/loss streak (positive for wins, negative for losses)
    *
    * @return $this
    */
    public function setCurrentStreak(?int $currentStreak = null): self
    {
        $this->currentStreak = $currentStreak;

        return $this;
    }




    /**
     * Gets longestWinStreak.
     *
     * @return int|null
     */
    public function getLongestWinStreak(): ?int
    {
        return $this->longestWinStreak;
    }

    /**
    * Sets longestWinStreak.
    *
    * @param int|null $longestWinStreak  Longest win streak
    *
    * @return $this
    */
    public function setLongestWinStreak(?int $longestWinStreak = null): self
    {
        $this->longestWinStreak = $longestWinStreak;

        return $this;
    }



}


