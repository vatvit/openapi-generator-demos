<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use \Exception;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;
use PetshopApi\Api\InventoryApiInterface;
use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;

/**
 * InventoryController
 *
 * Handles InventoryApiInterface operations.
 * Auto-generated from OpenAPI specification.
 */
class InventoryController extends Controller
{

    /**
     * Operation findPets
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function findPetsAction(Request $request)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication

        // Read out all input parameter values into variables
        $tags = $request->query->get('tags');
        $limit = $request->query->get('limit');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $tags = $this->deserialize($tags, 'array<multi,string>', 'string');
            $limit = $this->deserialize($limit, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\All([
            new Assert\Type("string"),
        ]);
        $asserts[] = new Assert\Valid();
        $response = $this->validate($tags, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($limit, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();


            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];

            $result = $handler->findPets($tags, $limit, $responseCode, $responseHeaders);

            $message = match($responseCode) {
                200 => 'pet response',
                0 => 'unexpected error',
                default => 'unexpected error',
            };

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (\Throwable $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Returns the handler for this API controller.
     * @return InventoryApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('inventory');
    }
}
