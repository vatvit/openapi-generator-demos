<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\Error;

/**
 * AdminApiInterface
 *
 * API Service interface for AdminApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * @generated
 */
interface AdminApiInterface
{
    /**
     * 
     *
     * deletes a single pet based on the ID supplied
     *
     * @param int $id ID of pet to delete
     * @return mixed
     */
    public function deletePet(
        int $id,
    );

}
