<?php

declare(strict_types=1);

namespace App\Handler\PetShop;

use PetShopApi\Api\DetailsApiInterface;
use PetShopApi\Model\Pet;

class DetailsHandler extends AbstractPetShopHandler implements DetailsApiInterface
{
    public function findPetById(int $id, int &$responseCode, array &$responseHeaders): array|object|null
    {
        $responseCode = 200;
        return new Pet([
            'id' => $id,
            'name' => 'Sample Pet',
            'tag' => 'sample',
        ]);
    }
}
