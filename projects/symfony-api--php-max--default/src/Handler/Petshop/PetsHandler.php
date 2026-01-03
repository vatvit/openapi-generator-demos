<?php

declare(strict_types=1);

namespace App\Handler\Petshop;

use PetshopApi\Api\Handler\PetsApiHandlerInterface;
use PetshopApi\Api\Response\AddPet200Response;
use PetshopApi\Api\Response\AddPet0Response;
use PetshopApi\Api\Response\DeletePet204Response;
use PetshopApi\Api\Response\DeletePet0Response;
use PetshopApi\Api\Response\FindPetById200Response;
use PetshopApi\Api\Response\FindPetById0Response;
use PetshopApi\Api\Response\FindPets200Response;
use PetshopApi\Api\Response\FindPets0Response;
use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * Handler for Pets API operations.
 *
 * Mock implementation for integration testing.
 */
class PetsHandler implements PetsApiHandlerInterface
{
    /** @var array<int, Pet> */
    private static array $pets = [];
    private static int $nextId = 1;

    public function __construct()
    {
        // Initialize with some mock data
        if (empty(self::$pets)) {
            self::$pets[1] = new Pet(name: 'Fluffy', id: 1, tag: 'cat');
            self::$pets[2] = new Pet(name: 'Buddy', id: 2, tag: 'dog');
            self::$pets[3] = new Pet(name: 'Goldie', id: 3, tag: 'fish');
            self::$nextId = 4;
        }
    }

    public static function resetPets(): void
    {
        self::$pets = [];
        self::$nextId = 1;
    }

    public function addPet(NewPet $new_pet): AddPet200Response|AddPet0Response
    {
        $id = self::$nextId++;
        $pet = new Pet(
            name: $new_pet->name,
            id: $id,
            tag: $new_pet->tag
        );
        self::$pets[$id] = $pet;

        return new AddPet200Response($pet);
    }

    public function deletePet(int $id): DeletePet204Response|DeletePet0Response
    {
        if (!isset(self::$pets[$id])) {
            $error = new Error(
                code: 404,
                message: 'Pet not found'
            );
            return new DeletePet0Response($error);
        }

        unset(self::$pets[$id]);
        return new DeletePet204Response();
    }

    public function findPetById(int $id): FindPetById200Response|FindPetById0Response
    {
        if (!isset(self::$pets[$id])) {
            $error = new Error(
                code: 404,
                message: 'Pet not found'
            );
            return new FindPetById0Response($error);
        }

        return new FindPetById200Response(self::$pets[$id]);
    }

    public function findPets(
        array|null $tags = null,
        int|null $limit = null
    ): FindPets200Response|FindPets0Response {
        $pets = array_values(self::$pets);

        // Filter by tags if provided
        if ($tags !== null && count($tags) > 0) {
            $pets = array_filter($pets, fn(Pet $pet) =>
                $pet->tag !== null && in_array($pet->tag, $tags, true)
            );
            $pets = array_values($pets);
        }

        // Apply limit if provided
        if ($limit !== null && $limit > 0) {
            $pets = array_slice($pets, 0, $limit);
        }

        // Note: The response type expects a single Pet, but we return the first pet
        // This is a known limitation in the generator for array responses
        if (empty($pets)) {
            $error = new Error(code: 404, message: 'No pets found');
            return new FindPets0Response($error);
        }

        // Return first pet (generator limitation - should return array)
        return new FindPets200Response($pets[0]);
    }
}
