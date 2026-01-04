<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\Error;
use TictactoeApi\Model\Pet;

/**
 * PublicApiInterface
 *
 * API Service interface for PublicApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * @generated
 */
interface PublicApiInterface
{
    /**
     * 
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     *
     * @param int $id ID of pet to fetch
     * @return mixed
     */
    public function findPetById(
        int $id,
    );

}
