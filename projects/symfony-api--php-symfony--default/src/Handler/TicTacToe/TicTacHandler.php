<?php

declare(strict_types=1);

namespace App\Handler\TicTacToe;

use TicTacToeApi\TicTacToeApi\Api\TicTacApiInterface;

class TicTacHandler implements TicTacApiInterface
{
    public function setbearerHttpAuthentication(?string $value): void {}

    public function getBoard(string $gameId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }
}
