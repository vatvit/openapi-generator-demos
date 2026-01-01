<?php
declare(strict_types=1);
namespace App\Handler\PetShop;

use PetShopApi\PetShopApi\Api\WorkflowApiInterface;

class WorkflowHandler extends AbstractPetShopHandler implements WorkflowApiInterface
{
    public function loginUser(string $username, string $password, int &$responseCode, array &$responseHeaders): array|object|null
    {
        return $this->notImplemented($responseCode);
    }

    public function logoutUser(int &$responseCode, array &$responseHeaders): void
    {
        $responseCode = 501;
    }
}
