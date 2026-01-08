<?php

declare(strict_types=1);

namespace App\Handlers\Petshop;

use PetshopApi\Api\InventoryHandlerInterface;

/**
 * Stub implementation of InventoryHandlerInterface for testing.
 */
class InventoryHandler implements InventoryHandlerInterface
{
    use PetOperationsTrait;
}
