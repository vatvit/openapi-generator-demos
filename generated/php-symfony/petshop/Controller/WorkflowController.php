<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use \Exception;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;
use PetshopApi\Api\WorkflowApiInterface;
use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * WorkflowController
 *
 * Handles WorkflowApiInterface operations.
 * Auto-generated from OpenAPI specification.
 */
class WorkflowController extends Controller
{

    /**
     * Operation addPet
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function addPetAction(Request $request)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json'];
        if (!static::isContentTypeAllowed($request, $consumes)) {
            // We can't consume the content that the client is sending us
            return new Response('', 415);
        }

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
        $newPet = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $inputFormat = $request->getMimeType($request->getContentTypeFormat());
            $newPet = $this->deserialize($newPet, 'PetshopApi\Model\NewPet', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("PetshopApi\Model\NewPet");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($newPet, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();


            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];

            $result = $handler->addPet($newPet, $responseCode, $responseHeaders);

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
     * @return WorkflowApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('workflow');
    }
}
