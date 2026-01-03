<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Winner of the game. &#x60;.&#x60; means nobody has won yet.
 */
enum Winner: string
{
    case EMPTY = '.';
    case X = 'X';
    case O = 'O';
}
