<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * ListGames200Resource
 *
 * Auto-generated Laravel Resource for list-games operation (HTTP 200)
 * Returns collection of Games with pagination headers
 *
 * OpenAPI Operation: list-games
 * Response: 200 OK
 * Schema: Array of Game
 * Headers: X-Total-Count (REQUIRED), X-Page-Number (OPTIONAL), X-Page-Size (OPTIONAL)
 *
 * PSR-4 COMPLIANT: One class per file, one Resource per operation response
 */
class ListGames200Resource extends ResourceCollection
{
    /**
     * HTTP status code for this response
     * Hardcoded: 200 OK
     *
     * @var int
     */
    protected int $httpCode = 200;

    /**
     * X-Total-Count header (REQUIRED)
     * Total number of games across all pages
     *
     * @var int|null
     */
    public ?int $xTotalCount = null;

    /**
     * X-Page-Number header (OPTIONAL)
     * Current page number
     *
     * @var int|null
     */
    public ?int $xPageNumber = null;

    /**
     * X-Page-Size header (OPTIONAL)
     * Number of items per page
     *
     * @var int|null
     */
    public ?int $xPageSize = null;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function ($game) {
                return [
                    'id' => $game->id,
                    'status' => $game->status,
                    'mode' => $game->mode,
                    'playerXId' => $game->playerXId,
                    'playerOId' => $game->playerOId,
                    'currentTurn' => $game->currentTurn,
                    'winner' => $game->winner,
                    'createdAt' => $game->createdAt->format(\DateTime::ISO8601),
                    'updatedAt' => $game->updatedAt->format(\DateTime::ISO8601),
                ];
            })->toArray(),
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 200 status code and pagination headers from OpenAPI spec
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     * @throws \RuntimeException if required headers missing
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 200 OK status
        $response->setStatusCode($this->httpCode);

        // X-Total-Count is REQUIRED for list operations
        if ($this->xTotalCount === null) {
            throw new \RuntimeException(
                'X-Total-Count header is REQUIRED for list-games (HTTP 200) but was not set. ' .
                'Set $resource->xTotalCount in your handler.'
            );
        }
        $response->header('X-Total-Count', (string) $this->xTotalCount);

        // Optional pagination headers
        if ($this->xPageNumber !== null) {
            $response->header('X-Page-Number', (string) $this->xPageNumber);
        }

        if ($this->xPageSize !== null) {
            $response->header('X-Page-Size', (string) $this->xPageSize);
        }
    }
}
