<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pagination
 *
 * Auto-generated model from OpenAPI specification.
 */

class Pagination 
{
        /**
     * Current page number
     *
     * @var int|null
     * @SerializedName("page")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(1)]
    protected ?int $page = null;

    /**
     * Items per page
     *
     * @var int|null
     * @SerializedName("limit")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(1)]
    protected ?int $limit = null;

    /**
     * Total number of items
     *
     * @var int|null
     * @SerializedName("total")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    #[Assert\GreaterThanOrEqual(0)]
    protected ?int $total = null;

    /**
     * Whether there is a next page
     *
     * @var bool|null
     * @SerializedName("hasNext")
     * @Type("bool")
    */
    #[Assert\Type("bool")]
    protected ?bool $hasNext = null;

    /**
     * Whether there is a previous page
     *
     * @var bool|null
     * @SerializedName("hasPrevious")
     * @Type("bool")
    */
    #[Assert\Type("bool")]
    protected ?bool $hasPrevious = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->page = array_key_exists('page', $data) ? $data['page'] : $this->page;
            $this->limit = array_key_exists('limit', $data) ? $data['limit'] : $this->limit;
            $this->total = array_key_exists('total', $data) ? $data['total'] : $this->total;
            $this->hasNext = array_key_exists('hasNext', $data) ? $data['hasNext'] : $this->hasNext;
            $this->hasPrevious = array_key_exists('hasPrevious', $data) ? $data['hasPrevious'] : $this->hasPrevious;
        }
    }

    /**
     * Gets page.
     *
     * @return int|null
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
    * Sets page.
    *
    * @param int|null $page  Current page number
    *
    * @return $this
    */
    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }




    /**
     * Gets limit.
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
    * Sets limit.
    *
    * @param int|null $limit  Items per page
    *
    * @return $this
    */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }




    /**
     * Gets total.
     *
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
    * Sets total.
    *
    * @param int|null $total  Total number of items
    *
    * @return $this
    */
    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }




    /**
     * Gets hasNext.
     *
     * @return bool|null
     */
    public function isHasNext(): ?bool
    {
        return $this->hasNext;
    }

    /**
    * Sets hasNext.
    *
    * @param bool|null $hasNext  Whether there is a next page
    *
    * @return $this
    */
    public function setHasNext(?bool $hasNext = null): self
    {
        $this->hasNext = $hasNext;

        return $this;
    }




    /**
     * Gets hasPrevious.
     *
     * @return bool|null
     */
    public function isHasPrevious(): ?bool
    {
        return $this->hasPrevious;
    }

    /**
    * Sets hasPrevious.
    *
    * @param bool|null $hasPrevious  Whether there is a previous page
    *
    * @return $this
    */
    public function setHasPrevious(?bool $hasPrevious = null): self
    {
        $this->hasPrevious = $hasPrevious;

        return $this;
    }



}


