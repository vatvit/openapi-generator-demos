<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Current status of the game
 */
enum GameStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case ABANDONED = 'abandoned';
}
