<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Leaderboard
 *
 * Auto-generated model from OpenAPI specification.
 */

class Leaderboard 
{
        /**
     * @var string|null
     * @SerializedName("timeframe")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Choice(['daily', 'weekly', 'monthly', 'all-time'])]
    #[Assert\Type("string")]
    protected ?string $timeframe = null;

    /**
     * @var LeaderboardEntry[]|null
     * @SerializedName("entries")
     * @Type("array<TictactoeApi\Model\LeaderboardEntry>")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    #[Assert\All([
        new Assert\Type("TictactoeApi\Model\LeaderboardEntry"),
    ])]
    protected ?array $entries = null;

    /**
     * When this leaderboard was generated
     *
     * @var \DateTime|null
     * @SerializedName("generatedAt")
     * @Type("DateTime")
    */
    #[Assert\NotNull]
    #[Assert\Type("\DateTime")]
    protected ?\DateTime $generatedAt = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->timeframe = array_key_exists('timeframe', $data) ? $data['timeframe'] : $this->timeframe;
            $this->entries = array_key_exists('entries', $data) ? $data['entries'] : $this->entries;
            $this->generatedAt = array_key_exists('generatedAt', $data) ? $data['generatedAt'] : $this->generatedAt;
        }
    }

    /**
     * Gets timeframe.
     *
     * @return string|null
     */
    public function getTimeframe(): ?string
    {
        return $this->timeframe;
    }

    /**
    * Sets timeframe.
    *
    * @param string|null $timeframe
    *
    * @return $this
    */
    public function setTimeframe(?string $timeframe): self
    {
        $this->timeframe = $timeframe;

        return $this;
    }




    /**
     * Gets entries.
     *
     * @return LeaderboardEntry[]|null
     */
    public function getEntries(): ?array
    {
        return $this->entries;
    }

    /**
    * Sets entries.
    *
    * @param LeaderboardEntry[]|null $entries
    *
    * @return $this
    */
    public function setEntries(?array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }




    /**
     * Gets generatedAt.
     *
     * @return \DateTime|null
     */
    public function getGeneratedAt(): ?\DateTime
    {
        return $this->generatedAt;
    }

    /**
    * Sets generatedAt.
    *
    * @param \DateTime|null $generatedAt  When this leaderboard was generated
    *
    * @return $this
    */
    public function setGeneratedAt(?\DateTime $generatedAt): self
    {
        $this->generatedAt = $generatedAt;

        return $this;
    }



}


