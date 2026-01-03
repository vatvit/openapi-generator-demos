<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * GameStatus
 *
 * Current status of the game
 *
 * @generated
 */
enum GameStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case ABANDONED = 'abandoned';
}
