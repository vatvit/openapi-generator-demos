<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Game;

/**
 * GameResource
 *
 * Auto-generated Laravel Resource from OpenAPI schema: Game
 * Enforces response structure and HTTP headers
 *
 * Used by operations:
 * - createGame: HTTP 201 (requires $location header)
 * - getGame: HTTP 200 (no headers)
 *
 * PSR-4 COMPLIANT: One class per file
 */
class GameResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * MUST be set by Handler
     *
     * @var int
     */
    public int $httpCode;

    /**
     * Location header for 201 Created responses
     * REQUIRED for createGame (201)
     * NOT used for getGame (200)
     *
     * @var string|null
     */
    public ?string $location = null;

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
     * Enforces HTTP status code and headers from OpenAPI spec
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     * @throws \RuntimeException if httpCode not set or required headers missing
     */
    public function withResponse($request, $response)
    {
        // Enforce HTTP status code is set
        if (!isset($this->httpCode)) {
            throw new \RuntimeException('HTTP status code not set for GameResource. Handler must set $resource->httpCode');
        }

        $response->setStatusCode($this->httpCode);

        // Enforce headers based on HTTP code
        if ($this->httpCode === 201) {
            // 201 Created REQUIRES Location header
            if ($this->location === null) {
                throw new \RuntimeException('Location header is REQUIRED for HTTP 201 (createGame) but was not set');
            }
            $response->header('Location', $this->location);
        }

        // 200 OK (getGame) has no special headers
    }
}
