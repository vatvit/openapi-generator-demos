<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GameListResponse
 *
 * Auto-generated model from OpenAPI specification.
 */

class GameListResponse 
{
        /**
     * @var Game[]|null
     * @SerializedName("games")
     * @Type("array<TictactoeApi\Model\Game>")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    #[Assert\All([
        new Assert\Type("TictactoeApi\Model\Game"),
    ])]
    protected ?array $games = null;

    /**
     * @var Pagination|null
     * @SerializedName("pagination")
     * @Type("TictactoeApi\Model\Pagination")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    #[Assert\Type("TictactoeApi\Model\Pagination")]
    protected ?Pagination $pagination = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->games = array_key_exists('games', $data) ? $data['games'] : $this->games;
            $this->pagination = array_key_exists('pagination', $data) ? $data['pagination'] : $this->pagination;
        }
    }

    /**
     * Gets games.
     *
     * @return Game[]|null
     */
    public function getGames(): ?array
    {
        return $this->games;
    }

    /**
    * Sets games.
    *
    * @param Game[]|null $games
    *
    * @return $this
    */
    public function setGames(?array $games): self
    {
        $this->games = $games;

        return $this;
    }




    /**
     * Gets pagination.
     *
     * @return Pagination|null
     */
    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    /**
    * Sets pagination.
    *
    * @param Pagination|null $pagination
    *
    * @return $this
    */
    public function setPagination(?Pagination $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }



}


