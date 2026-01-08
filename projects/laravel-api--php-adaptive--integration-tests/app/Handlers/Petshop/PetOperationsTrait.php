<?php

declare(strict_types=1);

namespace App\Handlers\Petshop;

use Illuminate\Http\JsonResponse;
use PetshopApi\Model\NewPet;

/**
 * Shared pet operations implementation trait.
 *
 * Provides stub implementations for common pet API operations.
 */
trait PetOperationsTrait
{
    /**
     * Add a new pet.
     */
    public function addPet(NewPet $new_pet): JsonResponse
    {
        $petId = random_int(1000, 9999);

        return new JsonResponse([
            'id' => $petId,
            'name' => $new_pet->name,
            'tag' => $new_pet->tag,
        ], 201);
    }

    /**
     * Delete a pet by ID.
     */
    public function deletePet(int $id): JsonResponse
    {
        return new JsonResponse(null, 204);
    }

    /**
     * Find a pet by ID.
     */
    public function findPetById(int $id): JsonResponse
    {
        return new JsonResponse([
            'id' => $id,
            'name' => 'Fluffy',
            'tag' => 'cat',
        ], 200);
    }

    /**
     * Find pets with optional filtering.
     *
     * @param string[]|null $tags
     */
    public function findPets(?array $tags = null, ?int $limit = null): JsonResponse
    {
        $limit = $limit ?? 10;

        $pets = [
            [
                'id' => 1,
                'name' => 'Fluffy',
                'tag' => 'cat',
            ],
            [
                'id' => 2,
                'name' => 'Buddy',
                'tag' => 'dog',
            ],
            [
                'id' => 3,
                'name' => 'Whiskers',
                'tag' => 'cat',
            ],
        ];

        // Filter by tags if provided
        if ($tags !== null && count($tags) > 0) {
            $pets = array_filter($pets, fn($pet) => in_array($pet['tag'], $tags, true));
            $pets = array_values($pets);
        }

        // Apply limit
        $pets = array_slice($pets, 0, $limit);

        return new JsonResponse($pets, 200);
    }
}
