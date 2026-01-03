<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Winner
 *
 * Winner of the game. &#x60;.&#x60; means nobody has won yet.
 *
 * @generated
 */
enum Winner: string
{
    case PERIOD = '.';
    case X = 'X';
    case O = 'O';
}

