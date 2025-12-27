# Laravel API Reference Implementation

**Status:** Reference Implementation (Hand-crafted, NOT generated)

This directory contains the **ideal structure** that OpenAPI generator templates should produce. It demonstrates contract-enforced API development with Laravel following all quality requirements.

## Purpose

This reference implementation shows:
- ✅ **PSR-4 Compliance** - One class per file
- ✅ **Contract Enforcement** - Type-safe interfaces and DTOs
- ✅ **HTTP Code Validation** - Runtime enforcement via Resources
- ✅ **Header Enforcement** - Required headers validated by Resources
- ✅ **No Post-Processing** - All generated directly from templates
- ✅ **Developer-Friendly** - Clear separation of generated code vs business logic

## Complete Request Flow

```
Route (with Middleware)
    ↓
FormRequest (Validation)
    ↓
Controller (HTTP Layer)
    ↓
DTO Conversion
    ↓
Handler (Business Logic) ← Developer implements this
    ↓
Resource (Response Transformation)
    ↓
withResponse() (HTTP Code + Headers Enforcement)
    ↓
JSON Response
```

## Directory Structure

```
generated-examples/laravel-max/
├── routes/
│   └── api.php                              # Route definitions with middleware
├── Http/
│   ├── Middleware/
│   │   └── AuthenticateGame.php             # Bearer auth (implements security interface)
│   ├── Requests/
│   │   └── CreateGameRequest.php            # Validation rules from OpenAPI schema
│   ├── Controllers/
│   │   └── GameController.php               # HTTP layer delegation
│   └── Resources/
│       ├── CreateGame201Resource.php        # createGame operation (HTTP 201 with Location)
│       ├── GetGame200Resource.php           # getGame operation (HTTP 200)
│       ├── GameCollectionResource.php       # listGames operation (HTTP 200 with pagination)
│       ├── ValidationErrorResource.php      # Validation error (422)
│       └── UnauthorizedErrorResource.php    # Auth error (401)
├── Models/
│   ├── CreateGameRequestDto.php             # Typed request DTO
│   └── Game.php                             # Game model DTO
├── Security/
│   ├── BearerHttpAuthenticationInterface.php # Security interface from OpenAPI
│   └── SecurityValidator.php                # Validates middleware implements interfaces
└── Api/
    ├── GameApi.php                          # Handler interface (contract)
    └── Handlers/
        └── GameApiHandler.php               # Business logic implementation (example)
```

## Key Components

### 1. Routes with Conditional Middleware

**File:** `routes/api.php`

This file is designed to be included from the main Laravel `routes/api.php` within a `Route::group()`:

```php
// routes/api.php (main Laravel routes file)
Route::group(['prefix' => 'v1', 'middleware' => ['api']], function ($router) {
    require base_path('generated/server/routes.php');
});
```

**Route pattern in generated file:**

```php
// Store route instance for conditional middleware attachment
$route = $router->POST('/games', [GameController::class, 'createGame'])
    ->name('api.createGame');

// SECURITY REQUIREMENT: This operation requires authentication
// Required security: bearerHttpAuthentication
// Middleware group 'api.middlewareGroup.createGame' MUST be defined and contain middleware implementing:
// - GameApiV2\Server\Security\bearerHttpAuthenticationInterface

// Attach middleware group (if defined)
if ($router->hasMiddlewareGroup('api.middlewareGroup.createGame')) {
    $route->middleware('api.middlewareGroup.createGame');
}
```

**Key features:**
- Uses `$router` variable from `Route::group()` closure
- Stores route in `$route` variable for middleware attachment
- **Conditional middleware:** Only attaches middleware if group is defined
- Named routes: `api.{operationId}`
- Extensive documentation comments with security requirements

**Auto-generated from:**
- OpenAPI paths and operations → HTTP method + path
- OpenAPI security schemes → security requirement comments + middleware group suggestions
- operationId → route name + middleware group name

**Middleware group definition (in bootstrap/app.php):**

```php
->withMiddleware(function (Middleware $middleware): void {
    // Define middleware groups for specific operations
    $middleware->group('api.middlewareGroup.createGame', [
        \LaravelMaxApi\Http\Middleware\AuthenticateGame::class,
    ]);

    $middleware->group('api.middlewareGroup.getGame', [
        \LaravelMaxApi\Http\Middleware\AuthenticateGame::class,
        \LaravelMaxApi\Http\Middleware\CacheResponse::class,
    ]);
})
```

**Benefits:**
- ✅ Flexible: Middleware only applied when group is defined
- ✅ Operation-specific: Each operation can have different middleware
- ✅ No hardcoded middleware classes in generated routes
- ✅ Developer controls middleware in bootstrap/app.php

### 2. Middleware (Authentication)

**File:** `Http/Middleware/AuthenticateGame.php`

```php
public function handle(Request $request, Closure $next): Response
{
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Missing authentication token'
        ], 401);
    }

    if (!$this->validateToken($token)) {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Invalid authentication token'
        ], 401);
    }

    return $next($request);
}
```

**Auto-generated from:**
- OpenAPI security schemes (Bearer authentication)
- Returns UnauthorizedErrorResource structure on failure

### 3. FormRequest with Validation

**File:** `Http/Requests/CreateGameRequest.php`

```php
public function rules(): array
{
    return [
        'mode' => ['required', 'string', 'in:single-player,two-player'],
        'playerXId' => ['required', 'string', 'max:255'],
        'playerOId' => ['nullable', 'string', 'max:255', 'required_if:mode,two-player'],
    ];
}

protected function failedValidation(Validator $validator): void
{
    throw new HttpResponseException(
        response()->json([
            'error' => 'Validation Error',
            'message' => 'The request data is invalid',
            'errors' => $validator->errors()->toArray()
        ], 422)
    );
}
```

**Auto-generated from:**
- OpenAPI requestBody schema
- `required` fields → `'required'` rule
- `enum` values → `'in:...'` rule
- `maxLength` → `'max:...'` rule
- Conditional requirements → `'required_if:...'`
- Returns ValidationErrorResource structure on failure

### 4. Request DTOs

**File:** `Models/CreateGameRequestDto.php`

```php
public function __construct(
    public string $mode,
    public string $playerXId,
    public ?string $playerOId = null,
) {}

public static function fromArray(array $data): self
{
    return new self(
        mode: $data['mode'],
        playerXId: $data['playerXId'],
        playerOId: $data['playerOId'] ?? null,
    );
}
```

**Auto-generated from:**
- OpenAPI requestBody schema properties
- Type-safe constructor properties
- Factory method for Controller conversion

**Benefits:**
- IDE autocomplete
- Type safety
- Immutable data structure

### 5. Model DTOs

**File:** `Models/Game.php`

```php
public function __construct(
    public string $id,
    public string $status,
    public string $mode,
    public string $playerXId,
    public ?string $playerOId,
    public string $currentTurn,
    public ?string $winner,
    public \DateTime $createdAt,
    public \DateTime $updatedAt,
) {}
```

**Auto-generated from:**
- OpenAPI components/schemas (Game schema)
- All properties from schema
- Typed according to OpenAPI types

### 6. Handler Interface (THE CONTRACT)

**File:** `Api/GameApi.php`

```php
interface GameApi
{
    /**
     * @return GameResource|ValidationErrorResource|UnauthorizedErrorResource
     */
    public function createGame(CreateGameRequestDto $request): GameResource|ValidationErrorResource|UnauthorizedErrorResource;

    /**
     * @return GameResource|ValidationErrorResource
     */
    public function getGame(string $gameId): GameResource|ValidationErrorResource;
}
```

**Auto-generated from:**
- OpenAPI operations
- Parameter types from request schemas
- **Union return types from response schemas** (200, 201, 401, 422, etc.)

**Contract Enforcement:**
- Developer MUST implement this interface
- Cannot change method signatures
- Cannot return wrong Resource types
- Type hints enforce compile-time checking

### 7. Controller (HTTP Layer)

**File:** `Http/Controllers/GameController.php`

```php
public function __construct(
    private readonly GameApi $handler
) {}

public function createGame(CreateGameRequest $request): JsonResponse
{
    // Convert validated data to DTO
    $dto = CreateGameRequestDto::fromArray($request->validated());

    // Delegate to Handler
    $resource = $this->handler->createGame($dto);

    // Resource enforces HTTP code and headers
    return $resource->response($request);
}
```

**Auto-generated from:**
- OpenAPI operations → methods
- Injects Handler interface
- Injects FormRequest for validation
- Delegates to Handler
- Returns Resource response

**Responsibilities:**
- HTTP layer only
- Validation (via FormRequest)
- DTO conversion
- Delegation
- NOT business logic

### 8. Resources (THE KEY SOLUTION)

**CRITICAL PRINCIPLE: One Resource Per Operation Response**

Each operation response (operation + HTTP code) gets its own Resource class, even if they return the same schema.

**Why?**
- ✅ **Single Responsibility** - Each Resource knows its exact HTTP code and headers
- ✅ **No Conditional Logic** - No `if ($httpCode === 201)` branches
- ✅ **Clear Mapping** - Operation → Resource is 1:1
- ✅ **Type Safety** - Union types enforce correct Resource per operation
- ✅ **Hardcoded Values** - HTTP codes and required headers are baked in

**File:** `Http/Resources/CreateGame201Resource.php`

```php
/**
 * Auto-generated for: createGame operation, HTTP 201 response
 * OpenAPI Operation: createGame
 * Response: 201 Created
 * Schema: Game
 * Headers: Location (REQUIRED)
 */
class CreateGame201Resource extends JsonResource
{
    /**
     * HTTP status code - Hardcoded: 201 Created
     */
    protected int $httpCode = 201;

    /**
     * Location header (REQUIRED for 201)
     */
    public ?string $location = null;

    public function toArray($request): array
    {
        /** @var Game $game */
        $game = $this->resource;

        return [
            'id' => $game->id,
            'status' => $game->status,
            // ... all Game schema properties
        ];
    }

    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 201 status
        $response->setStatusCode($this->httpCode);

        // Location header is REQUIRED for 201 Created
        if ($this->location === null) {
            throw new \RuntimeException('Location header is REQUIRED for createGame (HTTP 201)');
        }
        $response->header('Location', $this->location);
    }
}
```

**File:** `Http/Resources/GetGame200Resource.php`

```php
/**
 * Auto-generated for: getGame operation, HTTP 200 response
 * OpenAPI Operation: getGame
 * Response: 200 OK
 * Schema: Game (SAME schema as createGame, but DIFFERENT Resource!)
 * Headers: None
 */
class GetGame200Resource extends JsonResource
{
    /**
     * HTTP status code - Hardcoded: 200 OK
     */
    protected int $httpCode = 200;

    public function toArray($request): array
    {
        /** @var Game $game */
        $game = $this->resource;

        return [
            'id' => $game->id,
            'status' => $game->status,
            // ... all Game schema properties (SAME as CreateGame201Resource)
        ];
    }

    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 200 status
        $response->setStatusCode($this->httpCode);

        // No special headers for getGame
    }
}
```

**Key Differences:**
- **CreateGame201Resource**: HTTP 201, requires Location header
- **GetGame200Resource**: HTTP 200, no headers
- **SAME data structure** (Game schema) but **DIFFERENT HTTP context**

**Auto-generated from:**
- OpenAPI operation + response code → Resource class name
- OpenAPI response schema → `toArray()` structure
- OpenAPI response headers → public properties
- HTTP status code → hardcoded `$httpCode` property

**Key Features:**
- ✅ **One Resource per operation response** - createGame/201, getGame/200, etc.
- ✅ **Protected httpCode hardcoded** - No constructor parameter needed
- ✅ **PSR-4 Compliant** - One class per file
- ✅ **No Conditional Logic** - Each Resource knows its exact requirements
- ✅ **Validates Headers** - Required headers validated, optional skipped
- ✅ **Type-Safe Data** - `toArray()` structure from OpenAPI schema
- ✅ **No Post-Processing** - All generated directly from templates

**Error Resources (Fixed HTTP Codes):**

**File:** `Http/Resources/ValidationErrorResource.php`

```php
class ValidationErrorResource extends JsonResource
{
    /**
     * HTTP status code - Hardcoded: 422 Unprocessable Entity
     */
    protected int $httpCode = 422;

    public function toArray($request): array
    {
        return [
            'error' => 'Validation Error',
            'message' => $this->resource['message'] ?? 'The request data is invalid',
            'errors' => $this->resource['errors'] ?? [],
        ];
    }

    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 422 status
        $response->setStatusCode($this->httpCode);
    }
}
```

**File:** `Http/Resources/UnauthorizedErrorResource.php`

```php
class UnauthorizedErrorResource extends JsonResource
{
    /**
     * HTTP status code - Hardcoded: 401 Unauthorized
     */
    protected int $httpCode = 401;

    public function toArray($request): array
    {
        return [
            'error' => 'Unauthorized',
            'message' => $this->resource['message'] ?? 'Authentication required',
        ];
    }

    public function withResponse($request, $response)
    {
        // Set hardcoded HTTP 401 status
        $response->setStatusCode($this->httpCode);
    }
}
```

**Collection Resource with Custom Headers (Example):**

**File:** `Http/Resources/GameCollectionResource.php`

```php
class GameCollectionResource extends ResourceCollection
{
    /**
     * HTTP status code - Hardcoded: 200 OK
     */
    protected int $httpCode = 200;

    // REQUIRED header from OpenAPI spec
    public ?int $xTotalCount = null;

    // OPTIONAL headers from OpenAPI spec
    public ?int $xPageNumber = null;
    public ?int $xPageSize = null;
    public ?string $link = null; // RFC 5988 pagination links

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

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);

        // REQUIRED header validation
        if ($this->xTotalCount === null) {
            throw new \RuntimeException('X-Total-Count header is REQUIRED but was not set');
        }
        $response->header('X-Total-Count', (string) $this->xTotalCount);

        // OPTIONAL headers (only set if provided)
        if ($this->xPageNumber !== null) {
            $response->header('X-Page-Number', (string) $this->xPageNumber);
        }
        if ($this->xPageSize !== null) {
            $response->header('X-Page-Size', (string) $this->xPageSize);
        }
        if ($this->link !== null) {
            $response->header('Link', $this->link);
        }
    }
}
```

**Usage Example:**

```php
// Handler returns collection with pagination headers
public function listGames(ListGamesRequest $request): GameCollectionResource
{
    $games = Game::paginate(20);

    $resource = new GameCollectionResource($games->items());
    $resource->xTotalCount = $games->total(); // REQUIRED
    $resource->xPageNumber = $games->currentPage(); // OPTIONAL
    $resource->xPageSize = $games->perPage(); // OPTIONAL
    $resource->link = GameCollectionResource::buildLinkHeader(
        url('/api/games'),
        $games->currentPage(),
        $games->lastPage()
    ); // OPTIONAL

    return $resource;
}
```

**Response includes headers:**
```
HTTP/1.1 200 OK
X-Total-Count: 150
X-Page-Number: 2
X-Page-Size: 20
Link: <https://api.example.com/games?page=1>; rel="first", <https://api.example.com/games?page=1>; rel="prev", <https://api.example.com/games?page=3>; rel="next", <https://api.example.com/games?page=8>; rel="last"
```

### 9. Handler Implementation (Developer Code)

**File:** `Api/Handlers/GameApiHandler.php`

**This is what the DEVELOPER writes** (not generated):

```php
class GameApiHandler implements GameApi
{
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
    {
        // Business logic: Create game
        $game = new Game(
            id: 'game_' . uniqid(),
            status: 'waiting',
            mode: $request->mode,
            playerXId: $request->playerXId,
            playerOId: $request->playerOId,
            currentTurn: 'X',
            winner: null,
            createdAt: new \DateTime(),
            updatedAt: new \DateTime(),
        );

        // Return CreateGame201Resource (HTTP 201 hardcoded)
        $resource = new CreateGame201Resource($game);
        $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED for 201

        return $resource;
    }

    public function getGame(string $gameId): GetGame200Resource|ValidationErrorResource
    {
        // Business logic: Fetch game
        $game = new Game(
            id: $gameId,
            status: 'in-progress',
            mode: 'two-player',
            playerXId: 'player1',
            playerOId: 'player2',
            currentTurn: 'O',
            winner: null,
            createdAt: new \DateTime('2025-01-01'),
            updatedAt: new \DateTime(),
        );

        // Return GetGame200Resource (HTTP 200 hardcoded)
        $resource = new GetGame200Resource($game);
        // Note: No Location header for GET

        return $resource;
    }
}
```

**Developer Workflow:**
1. Implement `GameApi` interface
2. Write business logic
3. Create **operation-specific Resource** (e.g., `CreateGame201Resource`)
4. **Set header properties** (if required)
5. Return Resource

**What Happens if Developer Forgets:**
- Forgets to set required header → RuntimeException in `withResponse()`
- Uses wrong Resource (e.g., GetGame200Resource for createGame) → Compilation error (union types)
- Returns wrong data structure → Type error (DTO properties)
- HTTP code is always correct (hardcoded in Resource)

**Key Benefit:**
- ✅ **Cannot use wrong HTTP code** - It's hardcoded in each Resource
- ✅ **Clear which Resource to use** - Operation name in Resource class name
- ✅ **No constructor parameters** - Just `new CreateGame201Resource($game)`

## Why This Pattern Works

### Problem Solved: PSR-4 + Validation + No Post-Processing

**Requirements:**
1. ✅ PSR-4 compliance (one class per file)
2. ✅ Enforce data structure + HTTP code relationship
3. ✅ No post-processing scripts
4. ✅ Automatic header enforcement
5. ✅ Developer cannot break API contract

**How it's achieved:**

**One Resource per Model Schema** (not per response code)
- `GameResource` used for both 200 and 201 responses
- `ValidationErrorResource` for 422 responses
- `UnauthorizedErrorResource` for 401 responses

**Handler Sets `$httpCode` Property**
- Public property on Resource: `public int $httpCode`
- Handler MUST set it: `$resource->httpCode = 201`
- Runtime validation in `withResponse()` ensures it's set

**Headers Based on HTTP Code**
- Header properties are optional: `public ?string $location = null`
- `withResponse()` validates based on `$httpCode`:
  ```php
  if ($this->httpCode === 201) {
      if ($this->location === null) {
          throw new \RuntimeException('Location header REQUIRED for 201');
      }
      $response->header('Location', $this->location);
  }
  ```

**Union Return Types Limit Resource Types**
```php
// createGame can return: 201, 401, 422
public function createGame(...): GameResource|ValidationErrorResource|UnauthorizedErrorResource;

// getGame can return: 200, 422
public function getGame(...): GameResource|ValidationErrorResource;
```

**Compile-time + Runtime Enforcement:**
- Compile-time: Interface signature, union types, DTO types
- Runtime: `$httpCode` set, required headers present, **security middleware validated**

## Security Middleware Validation

### The Problem

How do we ensure developers implement authentication middleware as specified in the OpenAPI security schemes?

### The Solution: Interface-Based Validation

The library provides **security interfaces** from OpenAPI security schemes and **validates** that developer's middleware implements these interfaces (debug mode only).

**1. Generated Security Interface (from OpenAPI):**

**File:** `Security/BearerHttpAuthenticationInterface.php`

```php
/**
 * Auto-generated from OpenAPI security scheme: bearerHttpAuthentication
 * Type: http, Scheme: bearer, Bearer Format: JWT
 */
interface BearerHttpAuthenticationInterface
{
    public function handle(Request $request, Closure $next);
}
```

**2. Developer's Middleware Implementation:**

**File:** `Http/Middleware/AuthenticateGame.php`

```php
class AuthenticateGame implements BearerHttpAuthenticationInterface
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token || !$this->validateToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
```

**3. Middleware Registration (bootstrap/app.php):**

```php
->withMiddleware(function (Middleware $middleware): void {
    // Register security middleware group
    $middleware->group('api.security.bearerHttpAuthentication', [
        \LaravelMaxApi\Http\Middleware\AuthenticateGame::class,
    ]);
})
```

**4. Automatic Validation (routes/api.php):**

```php
// At end of routes file - only runs in debug mode
if (config('app.debug', false)) {
    if (class_exists(LaravelMaxApi\Security\SecurityValidator::class)) {
        try {
            LaravelMaxApi\Security\SecurityValidator::validateMiddleware($router);
        } catch (\RuntimeException $e) {
            error_log("Security middleware validation failed:");
            error_log($e->getMessage());
        }
    }
}
```

**5. SecurityValidator validates:**

**File:** `Security/SecurityValidator.php`

```php
class SecurityValidator
{
    private static array $securitySchemes = [
        'bearerHttpAuthentication' => BearerHttpAuthenticationInterface::class,
    ];

    private static array $operationSecurity = [
        'createGame' => ['bearerHttpAuthentication'],
        'getGame' => ['bearerHttpAuthentication'],
    ];

    public static function validateMiddleware(Router $router): void
    {
        // For each required security scheme:
        // 1. Check middleware group 'api.security.{scheme}' is defined
        // 2. Check group contains middleware implementing required interface
        // 3. Throw detailed error if validation fails
    }
}
```

**What Gets Validated:**

✅ Middleware group `api.security.bearerHttpAuthentication` is defined
✅ Group contains at least one middleware class
✅ Middleware class implements `BearerHttpAuthenticationInterface`
❌ Throws detailed error if any check fails (debug mode only)

**Example Validation Error:**

```
================================================================================
SECURITY MIDDLEWARE VALIDATION FAILED
================================================================================

Missing middleware group 'api.security.bearerHttpAuthentication' for security scheme 'bearerHttpAuthentication'
  Required by operations: createGame, getGame
  Middleware must implement: LaravelMaxApi\Security\BearerHttpAuthenticationInterface
  Define in bootstrap/app.php:
    $middleware->group('api.security.bearerHttpAuthentication', [
        \LaravelMaxApi\Http\Middleware\YourAuthMiddleware::class,
    ]);

================================================================================
Fix these issues in bootstrap/app.php or disable validation in production
by setting APP_DEBUG=false
================================================================================
```

**Benefits:**

- ✅ **Contract enforcement:** Library defines interface, developer implements
- ✅ **Automatic validation:** Catches missing/incorrect security setup
- ✅ **Debug-only:** No performance impact in production (APP_DEBUG=false)
- ✅ **Clear errors:** Detailed messages show exactly what's missing
- ✅ **Auto-generated:** All interfaces and validation from OpenAPI spec

**Key Pattern:**

1. **OpenAPI defines:** Security scheme (bearer, apiKey, oauth2, etc.)
2. **Library generates:** Interface for that scheme
3. **Developer implements:** Middleware with that interface
4. **Library validates:** Implementation is correct (debug mode only)

This ensures security requirements from the API spec are **enforced** at runtime!

## Developer Experience

### What Developer Writes

**Only business logic:**

```php
class MyGameHandler implements GameApi
{
    public function createGame(CreateGameRequestDto $request): GameResource|ValidationErrorResource|UnauthorizedErrorResource
    {
        // 1. Business logic
        $game = $this->gameService->create($request);

        // 2. Create Resource
        $resource = new GameResource($game);

        // 3. Set HTTP code
        $resource->httpCode = 201;

        // 4. Set required headers
        $resource->location = route('api.getGame', ['gameId' => $game->id]);

        // 5. Return
        return $resource;
    }
}
```

### What Developer Gets

**Automatic enforcement:**
- ✅ Request validation (FormRequest)
- ✅ Type-safe DTOs (IDE autocomplete)
- ✅ Contract compliance (interface implementation)
- ✅ HTTP code validation (runtime check)
- ✅ Header validation (runtime check)
- ✅ Response structure (Resource toArray)
- ✅ **Security middleware validation (debug mode)**

**Clear error messages:**
```
RuntimeException: HTTP status code not set for GameResource. Handler must set $resource->httpCode

RuntimeException: Location header is REQUIRED for HTTP 201 (createGame) but was not set
```

## Template Generation Strategy

To generate this structure from OpenAPI spec:

### 1. Route Template
- Loop: `{{#apiInfo}}{{#apis}}{{#operations}}{{#operation}}`
- Output: One route per operation
- Middleware from security schemes

### 2. Middleware Template
- Loop: `{{#authMethods}}`
- Output: One middleware per unique security scheme
- Bearer, API key, OAuth2 support

### 3. FormRequest Template
- Loop: `{{#apiInfo}}{{#apis}}{{#operations}}{{#operation}}` (if has requestBody)
- Output: One FormRequest per operation with requestBody
- Validation rules from schema properties

### 4. Request DTO Template
- Loop: `{{#models}}{{#model}}` (for requestBody schemas)
- Output: One DTO per request schema
- Typed constructor from schema properties

### 5. Model DTO Template
- Loop: `{{#models}}{{#model}}` (for component schemas)
- Output: One DTO per schema
- Typed constructor from schema properties

### 6. Handler Interface Template
- Loop: `{{#apiInfo}}{{#apis}}` (one interface per tag/controller)
- Methods: `{{#operations}}{{#operation}}`
- Union return types from response schemas

### 7. Controller Template
- Loop: `{{#apiInfo}}{{#apis}}` (one controller per tag/group)
- Methods: `{{#operations}}{{#operation}}`
- Constructor injection of Handler interface

### 8. Resource Template (KEY)
- Loop: `{{#models}}{{#model}}` (for response schemas)
- Output: One Resource per unique response schema
- Properties: `{{#responses}}{{#headers}}` (all headers from all codes that use this schema)
- `withResponse()`: Conditional validation based on `$httpCode` value

**Example Resource Generation Logic:**

```mustache
{{#models}}
{{#model}}
class {{classname}}Resource extends JsonResource
{
    public int $httpCode;

    {{#allHeadersForThisModel}}
    public ?string ${{nameInCamelCase}} = null;
    {{/allHeadersForThisModel}}

    public function toArray($request): array
    {
        return [
            {{#vars}}
            '{{name}}' => $this->resource->{{name}},
            {{/vars}}
        ];
    }

    public function withResponse($request, $response)
    {
        if (!isset($this->httpCode)) {
            throw new \RuntimeException('HTTP status code not set for {{classname}}Resource');
        }

        $response->setStatusCode($this->httpCode);

        {{#responseCodes}}
        if ($this->httpCode === {{code}}) {
            {{#headers}}
            {{#required}}
            if ($this->{{nameInCamelCase}} === null) {
                throw new \RuntimeException('{{baseName}} header REQUIRED for HTTP {{code}}');
            }
            {{/required}}
            {{#-last}}
            if ($this->{{nameInCamelCase}} !== null) {
            {{/-last}}
            $response->header('{{baseName}}', $this->{{nameInCamelCase}});
            {{#-last}}
            }
            {{/-last}}
            {{/headers}}
        }
        {{/responseCodes}}
    }
}
{{/model}}
{{/models}}
```

## Summary

This reference implementation demonstrates:

1. **Complete Flow:** Route → Middleware → FormRequest → Controller → DTO → Handler → Resource → Response
2. **Contract Enforcement:** Interfaces, union types, DTOs, validation
3. **PSR-4 Compliance:** One class per file
4. **No Post-Processing:** Everything generated directly
5. **Developer-Friendly:** Only implement business logic, framework handles the rest
6. **Runtime Safety:** HTTP codes and headers validated automatically

**This is the target structure that php-lumen (and other) generator templates should produce.**
