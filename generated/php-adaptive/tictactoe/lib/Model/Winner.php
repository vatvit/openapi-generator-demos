<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Winner enum.
 *
 * Winner of the game. &#x60;.&#x60; means nobody has won yet.
 */
enum Winner: string
{
    case PERIOD = '.';
    case X = 'X';
    case O = 'O';
}
