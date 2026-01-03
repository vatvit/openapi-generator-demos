<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use PetshopApi\Handler\FindPetsApiHandlerInterface;

/**
 * FindPetsController
 *
 * Symfony single-action controller for findPets operation.
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
#[Route('/pets', name: 'api.findPets', methods: ['GET'])]
class FindPetsController
{
    public function __construct(
        private readonly FindPetsApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        Request $request
    ): JsonResponse
    {
        // Extract query parameters
        $tags = $request->query->get('tags');
        $limit = $request->query->get('limit');

        // Delegate to handler
        $response = $this->handler->findPets(
            $tags,
            $limit,
        );

        // Serialize and return response
        return new JsonResponse(
            $this->serializer->serialize($response->getData(), 'json'),
            $response->getStatusCode(),
            $response->getHeaders(),
            true
        );
    }
}
