<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelMaxApi\Models\Board;

/**
 * GetBoard200Resource
 *
 * Auto-generated Laravel Resource for get-board operation (HTTP 200)
 * Returns board state with winner information
 *
 * OpenAPI Operation: get-board
 * Response: 200 OK
 * Schema: Board
 *
 * PSR-4 COMPLIANT: One class per file, one Resource per operation response
 */
class GetBoard200Resource extends JsonResource
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
     * Structure enforced by OpenAPI schema: Board
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Board $board */
        $board = $this->resource;

        return [
            'board' => $board->squares,
            'winner' => $board->winner,
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 200 status code
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);
    }
}
