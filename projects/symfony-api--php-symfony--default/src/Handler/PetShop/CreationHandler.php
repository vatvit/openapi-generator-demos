<?php

declare(strict_types=1);

namespace App\Handler\PetShop;

use PetShopApi\Api\CreationApiInterface;
use PetShopApi\Model\NewPet;
use PetShopApi\Model\Pet;

class CreationHandler extends AbstractPetShopHandler implements CreationApiInterface
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
}
