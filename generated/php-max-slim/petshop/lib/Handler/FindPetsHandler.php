<?php

declare(strict_types=1);

namespace PetshopApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PetshopApi\Api\FindPetsHandlerServiceInterface;
use PetshopApi\Handler\FindPetsValidator;
use PetshopApi\Response\FindPets200Response;
use PetshopApi\Response\FindPets0Response;

/**
 * FindPetsHandler
 *
 * PSR-15 request handler for findPets operation.
 *
 * @generated
 */
class FindPetsHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly FindPetsHandlerServiceInterface $service,
        private readonly FindPetsValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // Extract query parameters
        $queryParams = $request->getQueryParams();
        $tags = $queryParams['tags'] ?? null;
        $tags = is_array($tags) ? $tags : ($tags !== null ? explode(',', $tags) : null);
        $limit = $queryParams['limit'] ?? null;
        $limit = $limit !== null ? (int) $limit : null;


        // Validate input
        $validationResult = $this->validator->validate([
            'tags' => $tags,
            'limit' => $limit,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->findPets(
            $tags,
            $limit
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
