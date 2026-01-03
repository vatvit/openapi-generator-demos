<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Winner
 *
 * Winner of the game. &#x60;.&#x60; means nobody has won yet.
 *
 * Auto-generated model from OpenAPI specification.
 */
enum Winner: string
{
        case PERIOD = '.';
        case X = 'X';
        case O = 'O';
}



