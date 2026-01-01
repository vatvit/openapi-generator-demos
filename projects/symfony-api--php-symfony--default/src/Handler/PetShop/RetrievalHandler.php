<?php
declare(strict_types=1);
namespace App\Handler\PetShop;

use PetShopApi\PetShopApi\Api\RetrievalApiInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RetrievalHandler extends AbstractPetShopHandler implements RetrievalApiInterface
{
    public function uploadFile(int $petId, ?string $additionalMetadata, ?UploadedFile $file, int &$responseCode, array &$responseHeaders): array|object|null
    {
        return $this->notImplemented($responseCode);
    }
}
