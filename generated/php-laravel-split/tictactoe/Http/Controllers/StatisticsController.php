<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\StatisticsApiInterface;

/**
 * GetLeaderboardController
 *
 * Get leaderboard
 */
final class StatisticsApiInterfaceGetLeaderboardController extends Controller
{
    public function __construct(
        private readonly StatisticsApiInterface $api,
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
                'timeframe' => [
                ],
                'limit' => [
                    'gte:1',
                    'lte:100',
                    'integer',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $timeframe = $this->serde->deserialize($request->getContent(), from: 'json', to: \TictactoeApi\TictactoeApi\Model\GetLeaderboardTimeframeParameter::class);

        $limit = $request->integer('limit');

        try {
            $apiResult = $this->api->getLeaderboard($timeframe, $limit);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\Leaderboard) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        return response()->abort(500);
    }
}
---SPLIT:StatisticsApiInterfaceGetLeaderboardController.php---
<?php declare(strict_types=1);

namespace TictactoeApi\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use TictactoeApi\TictactoeApi\Api\StatisticsApiInterface;

/**
 * GetPlayerStatsController
 *
 * Get player statistics
 */
final class StatisticsApiInterfaceGetPlayerStatsController extends Controller
{
    public function __construct(
        private readonly StatisticsApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    ) {}

    public function __invoke(Request $request, string $playerId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'playerId' => $playerId,
                ],
                $request->all(),
            ),
            [
                'playerId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->getPlayerStats($playerId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\PlayerStats) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \TictactoeApi\TictactoeApi\Model\NotFoundError) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        return response()->abort(500);
    }
}
---SPLIT:StatisticsApiInterfaceGetPlayerStatsController.php---
