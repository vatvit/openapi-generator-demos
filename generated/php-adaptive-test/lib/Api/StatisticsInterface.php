<?php
// Handler Interface: Statistics
namespace TicTacToeApi\Api;

interface StatisticsInterface
{
    public function getLeaderboard();
    public function getPlayerStats();
}
