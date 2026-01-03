<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Possible values for a board square. &#x60;.&#x60; means empty square.
 */
enum Mark: string
{
    case EMPTY = '.';
    case X = 'X';
    case O = 'O';
}
