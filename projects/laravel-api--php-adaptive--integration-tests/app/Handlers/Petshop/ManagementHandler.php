<?php

declare(strict_types=1);

namespace App\Handlers\Petshop;

use PetshopApi\Api\ManagementHandlerInterface;

/**
 * Stub implementation of ManagementHandlerInterface for testing.
 */
class ManagementHandler implements ManagementHandlerInterface
{
    use PetOperationsTrait;
}
