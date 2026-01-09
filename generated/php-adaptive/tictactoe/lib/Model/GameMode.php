<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * GameMode enum.
 *
 * Game mode - Player vs Player or AI difficulty
 */
enum GameMode: string
{
    case PVP = 'pvp';
    case AI_EASY = 'ai_easy';
    case AI_MEDIUM = 'ai_medium';
    case AI_HARD = 'ai_hard';
}
