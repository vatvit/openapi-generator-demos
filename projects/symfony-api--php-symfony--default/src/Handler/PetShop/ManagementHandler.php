<?php
declare(strict_types=1);
namespace App\Handler\PetShop;

use PetShopApi\PetShopApi\Api\ManagementApiInterface;
use PetShopApi\PetShopApi\Model\Pet;

class ManagementHandler extends AbstractPetShopHandler implements ManagementApiInterface
{
    public function updatePet(Pet $pet, int &$responseCode, array &$responseHeaders): array|object|null
    {
        return $this->notImplemented($responseCode);
    }

    public function deletePet(int $petId, ?string $apiKey, int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 501;
    }

    public function updatePetWithForm(int $petId, ?string $name, ?string $status, int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 501;
    }

    public function updateUser(string $username, $user, int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 501;
    }

    public function deleteUser(string $username, int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 501;
    }

    public function deleteOrder(int $orderId, int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 501;
    }
}
