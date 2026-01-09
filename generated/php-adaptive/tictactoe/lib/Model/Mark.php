<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Mark enum.
 *
 * Possible values for a board square. &#x60;.&#x60; means empty square.
 */
enum Mark: string
{
    case PERIOD = '.';
    case X = 'X';
    case O = 'O';
}
