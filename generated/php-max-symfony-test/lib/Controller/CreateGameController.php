<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Api\GameManagementApiServiceInterface;

/**
 * CreateGameController
 *
 * Create a new game
 *
 * @generated
 */
class CreateGameController extends AbstractController
{
    public function __construct(
        private readonly GameManagementApiServiceInterface $handler,
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $requestDto = CreateGameRequest::fromArray($data);

        $violations = $this->validator->validate($requestDto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $result = $this->handler->createGame(
            create_game_request: $requestDto,
        );

        return new JsonResponse($result);
    }
}
