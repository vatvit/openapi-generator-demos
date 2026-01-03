<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Mark
 *
 * Possible values for a board square. &#x60;.&#x60; means empty square.
 *
 * @generated
 */
enum Mark: string
{
    case PERIOD = '.';
    case X = 'X';
    case O = 'O';
}

