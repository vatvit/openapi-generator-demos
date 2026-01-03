<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Api\GameplayApiServiceInterface;

/**
 * PutSquareController
 *
 * Set a single board square
 *
 * @generated
 */
class PutSquareController extends AbstractController
{
    public function __construct(
        private readonly GameplayApiServiceInterface $handler,
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     */
    public function __invoke(Request $request, string $game_id, int $row, int $column): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $requestDto = MoveRequest::fromArray($data);

        $violations = $this->validator->validate($requestDto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $result = $this->handler->putSquare(
            game_id: $game_id,
            row: $row,
            column: $column,
            move_request: $requestDto,
        );

        return new JsonResponse($result);
    }
}
