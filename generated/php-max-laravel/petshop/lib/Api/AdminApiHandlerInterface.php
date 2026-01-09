<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use PetshopApi\Model\Error;

/**
 * AdminApiHandlerInterface
 *
 * Handler interface for AdminApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface AdminApiHandlerInterface
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
