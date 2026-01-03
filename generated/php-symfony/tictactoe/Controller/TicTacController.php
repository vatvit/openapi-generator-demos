<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use \Exception;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;
use TictactoeApi\Api\TicTacApiInterface;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;

/**
 * TicTacController
 *
 * Handles TicTacApiInterface operations.
 * Auto-generated from OpenAPI specification.
 */
class TicTacController extends Controller
{

    /**
     * Operation getBoard
     *
     * Get the game board
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getBoardAction(Request $request, $gameId)
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
        // Authentication 'defaultApiKey' required
        // Set key with prefix in header
        $securitydefaultApiKey = $request->headers->get('api-key');
        // Authentication 'app2AppOauth' required
        // Oauth required
        $securityapp2AppOauth = $request->headers->get('authorization');

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $gameId = $this->deserialize($gameId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($gameId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'defaultApiKey'
            $handler->setdefaultApiKey($securitydefaultApiKey);
            // Set authentication method 'app2AppOauth'
            $handler->setapp2AppOauth($securityapp2AppOauth);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];

            $result = $handler->getBoard($gameId, $responseCode, $responseHeaders);

            $message = match($responseCode) {
                200 => 'OK',
                404 => 'Not Found - Resource does not exist',
                default => '',
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
     * @return TicTacApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('ticTac');
    }
}
