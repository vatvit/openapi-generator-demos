<?php

declare(strict_types=1);

namespace App\Handlers\Petshop;

use PetshopApi\Api\PetsHandlerInterface;

/**
 * Stub implementation of PetsHandlerInterface for testing.
 */
class PetsHandler implements PetsHandlerInterface
{
    use PetOperationsTrait;
}
