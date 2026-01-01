<?php
declare(strict_types=1);
namespace App\Handler\PetShop;

use PetShopApi\PetShopApi\Api\SearchApiInterface;

class SearchHandler extends AbstractPetShopHandler implements SearchApiInterface
{
    public function getUserByName(string $username, int &$responseCode, array &$responseHeaders): array|object|null
    {
        return $this->notImplemented($responseCode);
    }
}
