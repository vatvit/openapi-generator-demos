<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameplayApiInterface;

/**
 * GetBoardController
 *
 * Get the game board
 */
final class GameplayApiInterfaceGetBoardController extends Controller
{
    public function __construct(
        private readonly GameplayApiInterface $api,
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
---SPLIT:GameplayApiInterfaceGetBoardController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameplayApiInterface;

/**
 * GetGameController
 *
 * Get game details
 */
final class GameplayApiInterfaceGetGameController extends Controller
{
    public function __construct(
        private readonly GameplayApiInterface $api,
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
            $apiResult = $this->api->getGame($gameId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\Game) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameplayApiInterfaceGetGameController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameplayApiInterface;

/**
 * GetMovesController
 *
 * Get move history
 */
final class GameplayApiInterfaceGetMovesController extends Controller
{
    public function __construct(
        private readonly GameplayApiInterface $api,
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
            $apiResult = $this->api->getMoves($gameId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\MoveHistory) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameplayApiInterfaceGetMovesController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameplayApiInterface;

/**
 * GetSquareController
 *
 * Get a single board square
 */
final class GameplayApiInterfaceGetSquareController extends Controller
{
    public function __construct(
        private readonly GameplayApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    ) {}

    public function __invoke(Request $request, string $gameId, int $row, int $column): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'gameId' => $gameId,'row' => $row,'column' => $column,
                ],
                $request->all(),
            ),
            [
                'gameId' => [
                    'required',
                    'string',
                ],
                'row' => [
                    'required',
                    'gte:1',
                    'lte:3',
                    'integer',
                ],
                'column' => [
                    'required',
                    'gte:1',
                    'lte:3',
                    'integer',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }




        try {
            $apiResult = $this->api->getSquare($gameId, $row, $column);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\SquareResponse) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\BadRequestError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 400);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameplayApiInterfaceGetSquareController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameplayApiInterface;

/**
 * PutSquareController
 *
 * Set a single board square
 */
final class GameplayApiInterfacePutSquareController extends Controller
{
    public function __construct(
        private readonly GameplayApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    ) {}

    public function __invoke(Request $request, string $gameId, int $row, int $column): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'gameId' => $gameId,'row' => $row,'column' => $column,
                ],
                $request->all(),
            ),
            [
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }




        $moveRequest = $this->serde->deserialize($request->getContent(), from: 'json', to: \TictactoeApi\TictactoeApi\Model\MoveRequest::class);

        try {
            $apiResult = $this->api->putSquare($gameId, $row, $column, $moveRequest);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\Status) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\BadRequestError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 400);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\Error) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 409);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameplayApiInterfacePutSquareController.php---
