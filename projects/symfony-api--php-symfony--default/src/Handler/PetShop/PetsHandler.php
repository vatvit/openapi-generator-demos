<?php

declare(strict_types=1);

namespace App\Handler\PetShop;

use PetShopApi\Api\PetsApiInterface;
use PetShopApi\Model\NewPet;
use PetShopApi\Model\Pet;

class PetsHandler extends AbstractPetShopHandler implements PetsApiInterface
{
    public function addPet(NewPet $newPet, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 201;
        return new Pet([
            'id' => rand(1, 1000),
            'name' => $newPet->getName(),
            'tag' => $newPet->getTag(),
        ]);
    }

    public function deletePet(int $id, int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 204;
    }

    public function findPetById(int $id, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 200;
        return new Pet([
            'id' => $id,
            'name' => 'Sample Pet',
            'tag' => 'sample',
        ]);
    }

    public function findPets(?array $tags, ?int $limit, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 200;
        return [
            new Pet(['id' => 1, 'name' => 'Pet 1', 'tag' => 'dog']),
            new Pet(['id' => 2, 'name' => 'Pet 2', 'tag' => 'cat']),
        ];
    }
}
