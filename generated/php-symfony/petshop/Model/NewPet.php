<?php

declare(strict_types=1);

namespace PetshopApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NewPet
 *
 * Auto-generated model from OpenAPI specification.
 */

class NewPet 
{
        /**
     * @var string|null
     * @SerializedName("name")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $name = null;

    /**
     * @var string|null
     * @SerializedName("tag")
     * @Type("string")
    */
    #[Assert\Type("string")]
    protected ?string $tag = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->name = array_key_exists('name', $data) ? $data['name'] : $this->name;
            $this->tag = array_key_exists('tag', $data) ? $data['tag'] : $this->tag;
        }
    }

    /**
     * Gets name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
    * Sets name.
    *
    * @param string|null $name
    *
    * @return $this
    */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }




    /**
     * Gets tag.
     *
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
    * Sets tag.
    *
    * @param string|null $tag
    *
    * @return $this
    */
    public function setTag(?string $tag = null): self
    {
        $this->tag = $tag;

        return $this;
    }



}


