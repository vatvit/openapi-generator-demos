<?php

declare(strict_types=1);

namespace App\Api\TicTacToe;

use TicTacToeApi\Api\TicTacApiInterface;
use TicTacToeApi\Model\Status;
use TicTacToeApi\Model\NotFoundError;

/**
 * Stub handler for TicTac API.
 */
class TicTacHandler implements TicTacApiInterface
{
    public function getBoard(string $gameId): Status|NotFoundError
    {
        return new Status(
            board: [['X', null, 'O'], [null, 'X', null], [null, null, null]],
        );
    }
}
