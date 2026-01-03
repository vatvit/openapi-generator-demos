<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GameStatus
 *
 * Current status of the game
 *
 * Auto-generated model from OpenAPI specification.
 */
enum GameStatus: string
{
        case PENDING = 'pending';
        case IN_PROGRESS = 'in_progress';
        case COMPLETED = 'completed';
        case ABANDONED = 'abandoned';
}



