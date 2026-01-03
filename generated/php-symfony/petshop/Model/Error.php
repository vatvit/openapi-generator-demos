<?php

declare(strict_types=1);

namespace PetshopApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Error
 *
 * Auto-generated model from OpenAPI specification.
 */

class Error 
{
        /**
     * @var int|null
     * @SerializedName("code")
     * @Type("int")
    */
    #[Assert\NotNull]
    #[Assert\Type("int")]
    protected ?int $code = null;

    /**
     * @var string|null
     * @SerializedName("message")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $message = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->code = array_key_exists('code', $data) ? $data['code'] : $this->code;
            $this->message = array_key_exists('message', $data) ? $data['message'] : $this->message;
        }
    }

    /**
     * Gets code.
     *
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
    * Sets code.
    *
    * @param int|null $code
    *
    * @return $this
    */
    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }




    /**
     * Gets message.
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
    * Sets message.
    *
    * @param string|null $message
    *
    * @return $this
    */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }



}


