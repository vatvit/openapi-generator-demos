<?php
// Handler Interface: GameManagement
namespace TicTacToeApi\Api;

interface GameManagementInterface
{
    public function createGame();
    public function deleteGame();
    public function getGame();
    public function listGames();
}
