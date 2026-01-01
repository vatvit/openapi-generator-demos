<?php

declare(strict_types=1);

namespace App\Handler\TicTacToe;

use TicTacToeApi\TicTacToeApi\Api\GameplayApiInterface;
use TicTacToeApi\TicTacToeApi\Model\MoveRequest;

class GameplayHandler implements GameplayApiInterface
{
    public function setdefaultApiKey(?string $value): void {}
    public function setapp2AppOauth(?string $value): void {}
    public function setbearerHttpAuthentication(?string $value): void {}
    public function setuser2AppOauth(?string $value): void {}

    public function getBoard(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }

    public function getGame(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }

    public function getMoves(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }

    public function getSquare(string $gameId, int $row, int $column, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }

    public function putSquare(string $gameId, int $row, int $column, MoveRequest $moveRequest, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }
}
