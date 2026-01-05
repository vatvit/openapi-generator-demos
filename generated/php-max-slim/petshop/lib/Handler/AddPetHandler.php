<?php

declare(strict_types=1);

namespace PetshopApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PetshopApi\Api\AddPetHandlerServiceInterface;
use PetshopApi\Handler\AddPetValidator;
use PetshopApi\Response\AddPet200Response;
use PetshopApi\Response\AddPet0Response;

/**
 * AddPetHandler
 *
 * PSR-15 request handler for addPet operation.
 *
 * @generated
 */
class AddPetHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly AddPetHandlerServiceInterface $service,
        private readonly AddPetValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {


        // Parse request body
        $body = $request->getParsedBody();

        // Validate input
        $validationResult = $this->validator->validate([
            'body' => $body,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->addPet(
            $body
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
