<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * GameMode
 *
 * Game mode - Player vs Player or AI difficulty
 *
 * @generated
 */
enum GameMode: string
{
    case Pvp = 'pvp';
    case AiEasy = 'ai_easy';
    case AiMedium = 'ai_medium';
    case AiHard = 'ai_hard';
}
