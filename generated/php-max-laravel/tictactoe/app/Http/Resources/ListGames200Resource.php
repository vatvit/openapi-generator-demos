<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TictactoeApi\Model\GameListResponse;

final class ListGames200Resource extends JsonResource
{
    protected int $httpCode = 200;

    public ?string $xTotalCount = null;

    public ?string $xPageNumber = null;

    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        /** @var GameListResponse|null $model */
        $model = $this->resource;

        // Handle null resource (empty response or error response)
        if ($model === null) {
            return [];
        }

        return [
            'games' => $model->games,
            'pagination' => $model->pagination,
        ];
    }

    public function withResponse($request, \Illuminate\Http\JsonResponse $response): void
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

        // X-Total-Count header is REQUIRED
        if ($this->xTotalCount === null) {
            throw new \RuntimeException(
                'X-Total-Count header is REQUIRED for listGames (HTTP 200) but was not set'
            );
        }
        $response->header('X-Total-Count', $this->xTotalCount);

        // X-Page-Number header is optional
        if ($this->xPageNumber !== null) {
            $response->header('X-Page-Number', $this->xPageNumber);
        }

    }
}
