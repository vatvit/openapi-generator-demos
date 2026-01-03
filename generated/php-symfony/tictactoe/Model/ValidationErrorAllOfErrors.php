<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ValidationErrorAllOfErrors
 *
 * Auto-generated model from OpenAPI specification.
 */

class ValidationErrorAllOfErrors 
{
        /**
     * Field that failed validation
     *
     * @var string|null
     * @SerializedName("field")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $field = null;

    /**
     * Validation error message
     *
     * @var string|null
     * @SerializedName("message")
     * @Type("string")
    */
    #[Assert\NotNull]
    #[Assert\Type("string")]
    protected ?string $message = null;

    /**
     * @var 
     * @SerializedName("value")
     * @Type("AnyType")
    */
    #[Assert\Type("AnyType")]
    protected  $value = null;

    /**
     * Constructor
     *
     * @param array<string, mixed>|null $data Associated array of property values initializing the model
     */
    public function __construct(?array $data = null)
    {
        if (is_array($data)) {
            $this->field = array_key_exists('field', $data) ? $data['field'] : $this->field;
            $this->message = array_key_exists('message', $data) ? $data['message'] : $this->message;
            $this->value = array_key_exists('value', $data) ? $data['value'] : $this->value;
        }
    }

    /**
     * Gets field.
     *
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
    * Sets field.
    *
    * @param string|null $field  Field that failed validation
    *
    * @return $this
    */
    public function setField(?string $field): self
    {
        $this->field = $field;

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
    * @param string|null $message  Validation error message
    *
    * @return $this
    */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }




    /**
     * Gets value.
     *
     * @return 
     */
    public function getValue(): 
    {
        return $this->value;
    }

    /**
    * Sets value.
    *
    * @param  $value
    *
    * @return $this
    */
    public function setValue( $value = null): self
    {
        $this->value = $value;

        return $this;
    }



}


