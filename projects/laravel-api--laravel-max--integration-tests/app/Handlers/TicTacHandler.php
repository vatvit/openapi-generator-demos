<?php

declare(strict_types=1);

namespace App\Handlers;

use TictactoeApi\Api\Handlers\TicTacApiHandlerInterface;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;
use TictactoeApi\Model\Winner;
use TictactoeApi\Api\Http\Resources\GetBoard200Resource;
use TictactoeApi\Api\Http\Resources\GetBoard404Resource;

/**
 * TicTac Handler Implementation
 *
 * Implements the TicTacApiHandler interface.
 * Delegates to GameplayHandler for shared game logic.
 */
class TicTacHandler implements TicTacApiHandlerInterface
{
    private GameplayHandler $gameplayHandler;

    public function __construct()
    {
        $this->gameplayHandler = new GameplayHandler();
    }

    /**
     * Get the game board
     */
    public function getBoard(
        string $game_id
    ): GetBoard200Resource|GetBoard404Resource {
        // Delegate to GameplayHandler since the logic is the same
        return $this->gameplayHandler->getBoard($game_id);
    }
}
