<?php declare(strict_types=1);

namespace TictactoeApi\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * ListGames200Resource
 *
 * Auto-generated Laravel ResourceCollection for listGames operation
 * Handles array responses with pagination headers
 *
 * OpenAPI Operation: listGames
 * HTTP Method: GET /games
 * Response Code: 200
 *
 * PSR-4 COMPLIANT: One class per file
 */
class ListGames200Resource extends ResourceCollection
{
    /**
     * HTTP status code for this response
     * Hardcoded: 200
     *
     * @var int
     */
    protected int $httpCode = 200;

    /**
     * Total number of games
     * REQUIRED
     *
     * @var int
     */
    public int $xTotalCount;

    /**
     * Current page number
     * OPTIONAL
     *
     * @var ?int
     */
    public ?int $xPageNumber = null;

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = GameListResponseResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return $this->collection->toArray();
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP 200 status code and pagination headers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);

        // REQUIRED header: X-Total-Count
        if ($this->xTotalCount === null) {
            throw new \RuntimeException(
                'X-Total-Count header is REQUIRED for ListGames200Resource but was not set. ' .
                'Set $resource->xTotalCount in your handler.'
            );
        }
        $response->header('X-Total-Count', (string) $this->xTotalCount);

        // OPTIONAL header: X-Page-Number
        if ($this->xPageNumber !== null) {
            $response->header('X-Page-Number', (string) $this->xPageNumber);
        }

    }

    /**
     * Set pagination metadata
     *
     * @param int $totalCount Total number of items
     * @param int|null $pageNumber Current page number
     * @param int|null $pageSize Items per page
     * @return static
     */
    public function withPagination(int $totalCount, ?int $pageNumber = null, ?int $pageSize = null): static
    {
        $this->xTotalCount = $totalCount;
        if ($pageNumber !== null) {
            $this->xPageNumber = $pageNumber;
        }
        return $this;
    }
}
