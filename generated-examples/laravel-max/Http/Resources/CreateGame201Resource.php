<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelMaxApi\Models\Game;

/**
 * CreateGame201Resource
 *
 * Auto-generated Laravel Resource for createGame operation (HTTP 201)
 * Returns Game schema with Location header
 *
 * OpenAPI Operation: createGame
 * Response: 201 Created
 * Schema: Game
 * Headers: Location (REQUIRED)
 *
 * PSR-4 COMPLIANT: One class per file, one Resource per operation response
 */
class CreateGame201Resource extends JsonResource
{
    /**
     * HTTP status code for this response
     * Hardcoded: 201 Created
     *
     * @var int
     */
    protected int $httpCode = 201;

    /**
     * Location header (REQUIRED for 201 Created)
     * MUST be set by Handler
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
     * Enforces HTTP 201 status code and Location header from OpenAPI spec
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     * @throws \RuntimeException if required headers missing
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 201 Created status
        $response->setStatusCode($this->httpCode);

        // Location header is REQUIRED for 201 Created
        if ($this->location === null) {
            throw new \RuntimeException(
                'Location header is REQUIRED for createGame (HTTP 201) but was not set. ' .
                'Set $resource->location in your handler.'
            );
        }
        $response->header('Location', $this->location);
    }
}
