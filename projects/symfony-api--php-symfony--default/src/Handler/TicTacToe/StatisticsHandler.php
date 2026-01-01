<?php

declare(strict_types=1);

namespace App\Handler\TicTacToe;

use TicTacToeApi\TicTacToeApi\Api\StatisticsApiInterface;

class StatisticsHandler implements StatisticsApiInterface
{
    public function setbearerHttpAuthentication(?string $value): void {}

    public function getLeaderboard(int $limit, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }

    public function getPlayerStats(string $playerId, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }
}
