<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * GameStatus
 *
 * Current status of the game
 *
 * @generated
 */
enum GameStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Abandoned = 'abandoned';
}
