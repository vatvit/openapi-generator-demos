<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * GameCollectionResource
 *
 * EXAMPLE of Resource with custom headers (pagination)
 * Auto-generated Laravel Resource collection from OpenAPI schema with headers
 *
 * Demonstrates:
 * - Custom pagination headers from OpenAPI response headers
 * - Protected httpCode with default value
 * - Conditional required vs optional headers
 *
 * OpenAPI Response Headers:
 * - X-Total-Count (required): Total number of items across all pages
 * - X-Page-Number (optional): Current page number
 * - X-Page-Size (optional): Number of items per page
 * - Link (optional): RFC 5988 pagination links (first, prev, next, last)
 *
 * Used by operations:
 * - listGames: HTTP 200 (with pagination headers)
 *
 * PSR-4 COMPLIANT: One class per file
 */
class GameCollectionResource extends ResourceCollection
{
    /**
     * HTTP status code for this response
     * Hardcoded: 200 OK
     *
     * @var int
     */
    protected int $httpCode = 200;

    /**
     * Total count header (REQUIRED)
     * MUST be set by Handler
     *
     * @var int|null
     */
    public ?int $xTotalCount = null;

    /**
     * Page number header (OPTIONAL)
     *
     * @var int|null
     */
    public ?int $xPageNumber = null;

    /**
     * Page size header (OPTIONAL)
     *
     * @var int|null
     */
    public ?int $xPageSize = null;

    /**
     * RFC 5988 Link header (OPTIONAL)
     * Example: <https://api.example.com/games?page=3>; rel="next", <https://api.example.com/games?page=1>; rel="first"
     *
     * @var string|null
     */
    public ?string $link = null;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => GameResource::collection($this->collection),
            'meta' => [
                'total' => $this->xTotalCount,
                'page' => $this->xPageNumber,
                'pageSize' => $this->xPageSize,
            ],
        ];
    }

    /**
     * Customize the outgoing response.
     *
     * Enforces HTTP status code and pagination headers from OpenAPI spec
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     * @throws \RuntimeException if required headers not set
     */
    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

        // REQUIRED header: X-Total-Count
        if ($this->xTotalCount === null) {
            throw new \RuntimeException(
                'X-Total-Count header is REQUIRED for GameCollectionResource but was not set. ' .
                'Set $resource->xTotalCount in your handler.'
            );
        }
        $response->header('X-Total-Count', (string) $this->xTotalCount);

        // OPTIONAL header: X-Page-Number
        if ($this->xPageNumber !== null) {
            $response->header('X-Page-Number', (string) $this->xPageNumber);
        }

        // OPTIONAL header: X-Page-Size
        if ($this->xPageSize !== null) {
            $response->header('X-Page-Size', (string) $this->xPageSize);
        }

        // OPTIONAL header: Link (RFC 5988 pagination links)
        if ($this->link !== null) {
            $response->header('Link', $this->link);
        }
    }

    /**
     * Helper method to build RFC 5988 Link header
     *
     * @param string $baseUrl Base URL for pagination links
     * @param int $currentPage Current page number
     * @param int $lastPage Last page number
     * @return string Link header value
     */
    public static function buildLinkHeader(string $baseUrl, int $currentPage, int $lastPage): string
    {
        $links = [];

        // First page
        $links[] = "<{$baseUrl}?page=1>; rel=\"first\"";

        // Previous page
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $links[] = "<{$baseUrl}?page={$prevPage}>; rel=\"prev\"";
        }

        // Next page
        if ($currentPage < $lastPage) {
            $nextPage = $currentPage + 1;
            $links[] = "<{$baseUrl}?page={$nextPage}>; rel=\"next\"";
        }

        // Last page
        $links[] = "<{$baseUrl}?page={$lastPage}>; rel=\"last\"";

        return implode(', ', $links);
    }
}
