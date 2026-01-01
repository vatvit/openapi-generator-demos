<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\TicTacApiInterface;

/**
 * GetBoardController
 *
 * Get the game board
 */
final class TicTacApiInterfaceGetBoardController extends Controller
{
    public function __construct(
        private readonly TicTacApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    ) {}

    public function __invoke(Request $request, string $gameId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'gameId' => $gameId,
                ],
                $request->all(),
            ),
            [
                'gameId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->getBoard($gameId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\Status) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        return response()->abort(500);
    }
}
---SPLIT:TicTacApiInterfaceGetBoardController.php---
