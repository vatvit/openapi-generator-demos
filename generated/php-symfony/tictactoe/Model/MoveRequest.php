<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MoveRequest
 *
 * Auto-generated model from OpenAPI specification.
 */

class MoveRequest 
{
        /**
     * Mark to place on the board
     *
     * @var string|null
     * @SerializedName("mark")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Choice(['X', 'O'])]
    #[Assert\Type("string")]
    protected ?string $mark = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->mark = array_key_exists('mark', $data) ? $data['mark'] : $this->mark;
        }
    }

    /**
     * Gets mark.
     *
     * @return string|null
     */
    public function getMark(): ?string
    {
        return $this->mark;
    }

    /**
    * Sets mark.
    *
    * @param string|null $mark  Mark to place on the board
    *
    * @return $this
    */
    public function setMark(?string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }



}


