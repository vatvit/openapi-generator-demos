<?php

declare(strict_types=1);

namespace Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PetshopApi\Api\FindPetByIdApiHandlerInterfaceServiceInterface;
use Handler\FindPetByIdValidator;
use Response\FindPetById200Response;
use Response\FindPetById0Response;

/**
 * FindPetByIdHandler
 *
 * PSR-15 request handler for findPetById operation.
 *
 * @generated
 */
class FindPetByIdHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly FindPetByIdApiHandlerInterfaceServiceInterface $service,
        private readonly FindPetByIdValidator $validator
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
        $result = $this->service->findPetById(
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
