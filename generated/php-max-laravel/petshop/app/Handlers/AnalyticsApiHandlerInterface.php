<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handlers;

use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;
use PetshopApi\Api\Http\Resources\FindPets200Resource;
use PetshopApi\Api\Http\Resources\FindPets0Resource;

/**
 * AnalyticsApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: findPets
 */
interface AnalyticsApiHandlerInterface
{
    /**
     * Returns all pets from the system that the user has access to.
     *
     * @param array<string>|null $tags tags to filter by
     * @param int|null $limit maximum number of results to return
     */
    public function findPets(
        array|null $tags = null,
        int|null $limit = null
    ): FindPets200Resource|FindPets0Resource;

}
