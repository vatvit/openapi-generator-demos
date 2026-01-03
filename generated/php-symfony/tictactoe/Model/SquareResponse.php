<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SquareResponse
 *
 * Auto-generated model from OpenAPI specification.
 */

class SquareResponse 
{
        /**
     * Board coordinate (1-3)
     *
     * @var int|null
     * @SerializedName("row")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(3)]
    protected ?int $row = null;

    /**
     * Board coordinate (1-3)
     *
     * @var int|null
     * @SerializedName("column")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(3)]
    protected ?int $column = null;

    /**
     * @var Mark|null
     * @SerializedName("mark")
    * @Accessor(getter="getSerializedMark", setter="setDeserializedMark")
    * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Valid]
    protected ?Mark $mark = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->row = array_key_exists('row', $data) ? $data['row'] : $this->row;
            $this->column = array_key_exists('column', $data) ? $data['column'] : $this->column;
            $this->mark = array_key_exists('mark', $data) ? $data['mark'] : $this->mark;
        }
    }

    /**
     * Gets row.
     *
     * @return int|null
     */
    public function getRow(): ?int
    {
        return $this->row;
    }

    /**
    * Sets row.
    *
    * @param int|null $row  Board coordinate (1-3)
    *
    * @return $this
    */
    public function setRow(?int $row): self
    {
        $this->row = $row;

        return $this;
    }




    /**
     * Gets column.
     *
     * @return int|null
     */
    public function getColumn(): ?int
    {
        return $this->column;
    }

    /**
    * Sets column.
    *
    * @param int|null $column  Board coordinate (1-3)
    *
    * @return $this
    */
    public function setColumn(?int $column): self
    {
        $this->column = $column;

        return $this;
    }




    /**
     * Gets mark.
     *
     * @return Mark|null
     */
    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    /**
    * Sets mark.
    *
    * @param Mark|null $mark
    *
    * @return $this
    */
    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    /**
    * Gets mark for serialization.
    *
    * @return string|null
    */
    public function getSerializedMark(): string|null
    {
        return !is_null($this->mark?->value) ? (string) $this->mark->value : null;
    }

    /**
    * Sets mark.
    *
    * @param string|Mark|null $mark
    *
    * @return $this
    */
    public function setDeserializedMark(string|Mark|null $mark): self
    {
        if (is_string($mark)) {
            $mark = Mark::tryFrom($mark);
        }

        $this->mark = $mark;

        return $this;
    }


}


