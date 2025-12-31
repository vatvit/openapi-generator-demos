<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelMaxApi\Models\Game;

/**
 * GetGame200Resource
 *
 * Auto-generated Laravel Resource for getGame operation (HTTP 200)
 * Returns Game schema without special headers
 *
 * OpenAPI Operation: getGame
 * Response: 200 OK
 * Schema: Game
 * Headers: None
 *
 * PSR-4 COMPLIANT: One class per file, one Resource per operation response
 */
class GetGame200Resource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 200 OK
     *
     * @var int
     */
    protected int $httpCode = 200;

    /**
     * Transform the resource into an array.
     *
     * Structure enforced by OpenAPI schema: Game
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Game $game */
        $game = $this->resource;

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
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 200 status code from OpenAPI spec
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 200 OK status
        $response->setStatusCode($this->httpCode);

        // No special headers for getGame
    }
}
