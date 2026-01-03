<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BadRequestError
 *
 * Bad request error with invalid parameters
 *
 * Auto-generated model from OpenAPI specification.
 */

class BadRequestError 
{
        /**
     * Error code
     *
     * @var string|null
     * @SerializedName("code")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $code = null;

    /**
     * Human-readable error message
     *
     * @var string|null
     * @SerializedName("message")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $message = null;

    /**
     * Additional error details
     *
     * @var []|null
     * @SerializedName("details")
     * @Type("array<string, AnyType>")
    */
    #[Assert\All([
        new Assert\Type("AnyType"),
    ])]
    protected ?array $details = null;

    /**
     * Error type identifier
     *
     * @var string|null
     * @SerializedName("errorType")
     * @Type("string")
    */
    #[Assert\Choice(['BAD_REQUEST'])]
    #[Assert\Type("string")]
    protected ?string $errorType = null;

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
            $this->details = array_key_exists('details', $data) ? $data['details'] : $this->details;
            $this->errorType = array_key_exists('errorType', $data) ? $data['errorType'] : $this->errorType;
        }
    }

    /**
     * Gets code.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
    * Sets code.
    *
    * @param string|null $code  Error code
    *
    * @return $this
    */
    public function setCode(?string $code): self
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
    * @param string|null $message  Human-readable error message
    *
    * @return $this
    */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }




    /**
     * Gets details.
     *
     * @return []|null
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
    * Sets details.
    *
    * @param []|null $details  Additional error details
    *
    * @return $this
    */
    public function setDetails(?array $details = null): self
    {
        $this->details = $details;

        return $this;
    }




    /**
     * Gets errorType.
     *
     * @return string|null
     */
    public function getErrorType(): ?string
    {
        return $this->errorType;
    }

    /**
    * Sets errorType.
    *
    * @param string|null $errorType  Error type identifier
    *
    * @return $this
    */
    public function setErrorType(?string $errorType = null): self
    {
        $this->errorType = $errorType;

        return $this;
    }



}


