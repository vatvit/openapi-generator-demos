<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mark
 *
 * Possible values for a board square. &#x60;.&#x60; means empty square.
 *
 * Auto-generated model from OpenAPI specification.
 */
enum Mark: string
{
        case PERIOD = '.';
        case X = 'X';
        case O = 'O';
}



