<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameManagementApiInterface;

/**
 * CreateGameController
 *
 * Create a new game
 */
final class GameManagementApiInterfaceCreateGameController extends Controller
{
    public function __construct(
        private readonly GameManagementApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    
                ],
                $request->all(),
            ),
            [
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $createGameRequest = $this->serde->deserialize($request->getContent(), from: 'json', to: \TictactoeApi\TictactoeApi\Model\CreateGameRequest::class);

        try {
            $apiResult = $this->api->createGame($createGameRequest);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\Game) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 201);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\BadRequestError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 400);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\UnauthorizedError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 401);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\ValidationError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 422);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameManagementApiInterfaceCreateGameController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameManagementApiInterface;

/**
 * DeleteGameController
 *
 * Delete a game
 */
final class GameManagementApiInterfaceDeleteGameController extends Controller
{
    public function __construct(
        private readonly GameManagementApiInterface $api,
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
            $apiResult = $this->api->deleteGame($gameId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NoContent204) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 204);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\ForbiddenError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 403);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameManagementApiInterfaceDeleteGameController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameManagementApiInterface;

/**
 * GetGameController
 *
 * Get game details
 */
final class GameManagementApiInterfaceGetGameController extends Controller
{
    public function __construct(
        private readonly GameManagementApiInterface $api,
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
---SPLIT:GameManagementApiInterfaceGetGameController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\GameManagementApiInterface;

/**
 * ListGamesController
 *
 * List all games
 */
final class GameManagementApiInterfaceListGamesController extends Controller
{
    public function __construct(
        private readonly GameManagementApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    
                ],
                $request->all(),
            ),
            [
                'page' => [
                    'gte:1',
                    'integer',
                ],
                'limit' => [
                    'gte:1',
                    'lte:100',
                    'integer',
                ],
                'status' => [
                ],
                'playerId' => [
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $page = $request->integer('page');

        $limit = $request->integer('limit');

        $status = $this->serde->deserialize($request->getContent(), from: 'json', to: \TictactoeApi\TictactoeApi\Model\GameStatus::class);

        $playerId = $request->string('playerId')->value();

        try {
            $apiResult = $this->api->listGames($page, $limit, $status, $playerId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\GameListResponse) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\BadRequestError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 400);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\UnauthorizedError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 401);
        }


        return response()->abort(500);
    }
}
---SPLIT:GameManagementApiInterfaceListGamesController.php---
