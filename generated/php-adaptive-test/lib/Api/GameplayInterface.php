<?php
// Handler Interface: Gameplay
namespace TicTacToeApi\Api;

interface GameplayInterface
{
    public function getBoard();
    public function getGame();
    public function getMoves();
    public function getSquare();
    public function putSquare();
}
