<?php

declare(strict_types=1);

namespace PetshopApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PetshopApi\Api\DeletePetHandlerServiceInterface;
use PetshopApi\Handler\DeletePetValidator;
use PetshopApi\Response\DeletePet204Response;
use PetshopApi\Response\DeletePet0Response;

/**
 * DeletePetHandler
 *
 * PSR-15 request handler for deletePet operation.
 *
 * @generated
 */
class DeletePetHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly DeletePetHandlerServiceInterface $service,
        private readonly DeletePetValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $id = $request->getAttribute('id');



        // Validate input
        $validationResult = $this->validator->validate([
            'id' => $id,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->deletePet(
            $id
        );

        return $this->jsonResponse($result->getData(), $result->getStatusCode());
    }

    /**
     * Create a JSON response
     */
    private function jsonResponse(mixed $data, int $status = 200): ResponseInterface
    {
        $response = new \Slim\Psr7\Response($status);
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
