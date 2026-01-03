<?php

declare(strict_types=1);

namespace App\Handlers\Petshop;

use PetshopApi\Api\Handlers\PetsApiHandlerInterface;
use PetshopApi\Api\Handlers\RetrievalApiHandlerInterface;
use PetshopApi\Api\Handlers\SearchApiHandlerInterface;
use PetshopApi\Api\Handlers\WorkflowApiHandlerInterface;
use PetshopApi\Api\Http\Resources\AddPet200Resource;
use PetshopApi\Api\Http\Resources\AddPet0Resource;
use PetshopApi\Api\Http\Resources\DeletePet204Resource;
use PetshopApi\Api\Http\Resources\DeletePet0Resource;
use PetshopApi\Api\Http\Resources\FindPetById200Resource;
use PetshopApi\Api\Http\Resources\FindPetById0Resource;
use PetshopApi\Api\Http\Resources\FindPets200Resource;
use PetshopApi\Api\Http\Resources\FindPets0Resource;
use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * Handler for Pets API operations.
 *
 * Mock implementation for integration testing.
 */
class PetsHandler implements PetsApiHandlerInterface, RetrievalApiHandlerInterface, SearchApiHandlerInterface, WorkflowApiHandlerInterface
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

    public function addPet(NewPet $new_pet): AddPet200Resource|AddPet0Resource
    {
        $id = self::$nextId++;
        $pet = new Pet(
            name: $new_pet->name,
            id: $id,
            tag: $new_pet->tag
        );
        self::$pets[$id] = $pet;

        return new AddPet200Resource($pet);
    }

    public function deletePet(int $id): DeletePet204Resource|DeletePet0Resource
    {
        if (!isset(self::$pets[$id])) {
            $error = new Error(
                code: 404,
                message: 'Pet not found'
            );
            return new DeletePet0Resource($error);
        }

        unset(self::$pets[$id]);
        return new DeletePet204Resource(null);
    }

    public function findPetById(int $id): FindPetById200Resource|FindPetById0Resource
    {
        if (!isset(self::$pets[$id])) {
            $error = new Error(
                code: 404,
                message: 'Pet not found'
            );
            return new FindPetById0Resource($error);
        }

        return new FindPetById200Resource(self::$pets[$id]);
    }

    public function findPets(
        array|null $tags = null,
        int|null $limit = null
    ): FindPets200Resource|FindPets0Resource {
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

        return new FindPets200Resource($pets);
    }
}
