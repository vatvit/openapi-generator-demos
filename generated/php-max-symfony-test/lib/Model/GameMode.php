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
    case PVP = 'pvp';
    case AI_EASY = 'ai_easy';
    case AI_MEDIUM = 'ai_medium';
    case AI_HARD = 'ai_hard';
}

