<?php

declare(strict_types=1);

namespace App\Handlers\Petshop;

use PetshopApi\Api\PublicHandlerInterface;

/**
 * Stub implementation of PublicHandlerInterface for testing.
 */
class PublicHandler implements PublicHandlerInterface
{
    use PetOperationsTrait;
}
