<?php
declare(strict_types=1);
namespace App\Handler\PetShop;

use PetShopApi\PetShopApi\Api\InventoryApiInterface;

class InventoryHandler extends AbstractPetShopHandler implements InventoryApiInterface
{
    public function getInventory(int &$responseCode, array &$responseHeaders): array|object|null
    {
        return $this->notImplemented($responseCode);
    }
}
