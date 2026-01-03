<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GameMode
 *
 * Game mode - Player vs Player or AI difficulty
 *
 * Auto-generated model from OpenAPI specification.
 */
enum GameMode: string
{
        case PVP = 'pvp';
        case AI_EASY = 'ai_easy';
        case AI_MEDIUM = 'ai_medium';
        case AI_HARD = 'ai_hard';
}



