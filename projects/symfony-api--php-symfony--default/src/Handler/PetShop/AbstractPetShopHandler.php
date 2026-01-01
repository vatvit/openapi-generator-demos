<?php

declare(strict_types=1);

namespace App\Handler\PetShop;

/**
 * Base class for PetShop handlers.
 * Provides common authentication setters.
 */
abstract class AbstractPetShopHandler
{
    protected ?string $apiKey = null;
    protected ?string $bearerToken = null;
    protected ?string $oauth = null;

    public function setapiKeyAuth(?string $value): void
    {
        $this->apiKey = $value;
    }

    public function setbearerHttpAuthentication(?string $value): void
    {
        $this->bearerToken = $value;
    }

    public function setoauth2(?string $value): void
    {
        $this->oauth = $value;
    }

    protected function notImplemented(int &$responseCode): array
    {
        $responseCode = 501;
        return ['error' => 'Not implemented'];
    }
}
