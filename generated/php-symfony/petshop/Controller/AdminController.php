<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use \Exception;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;
use PetshopApi\Api\AdminApiInterface;
use PetshopApi\Model\Error;

/**
 * AdminController
 *
 * Handles AdminApiInterface operations.
 * Auto-generated from OpenAPI specification.
 */
class AdminController extends Controller
{

    /**
     * Operation deletePet
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function deletePetAction(Request $request, $id)
    {
        // Handle authentication

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $id = $this->deserialize($id, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($id, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();


            // Make the call to the business logic
            $responseCode = 204;
            $responseHeaders = [];

            $handler->deletePet($id, $responseCode, $responseHeaders);

            $message = match($responseCode) {
                204 => 'pet deleted',
                0 => 'unexpected error',
                default => 'unexpected error',
            };

            return new Response(
                '',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
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
     * @return AdminApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('admin');
    }
}
