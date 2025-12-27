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
│   │   └── AuthenticateGame.php             # Bearer auth from OpenAPI security
│   ├── Requests/
│   │   └── CreateGameRequest.php            # Validation rules from OpenAPI schema
│   ├── Controllers/
│   │   └── GameController.php               # HTTP layer delegation
│   └── Resources/
│       ├── GameResource.php                 # Success response (200/201)
│       ├── ValidationErrorResource.php      # Validation error (422)
│       └── UnauthorizedErrorResource.php    # Auth error (401)
├── Models/
│   ├── CreateGameRequestDto.php             # Typed request DTO
│   └── Game.php                             # Game model DTO
└── Api/
    ├── GameApi.php                          # Handler interface (contract)
    └── Handlers/
        └── GameApiHandler.php               # Business logic implementation (example)
```

## Key Components

### 1. Routes with Middleware

**File:** `routes/api.php`

```php
Route::post('/games', [GameController::class, 'createGame'])
    ->name('api.createGame')
    ->middleware(['api', AuthenticateGame::class]);

Route::get('/games/{gameId}', [GameController::class, 'getGame'])
    ->name('api.getGame')
    ->middleware(['api', AuthenticateGame::class]);
```

**Auto-generated from:**
- OpenAPI paths and operations
- OpenAPI security schemes → middleware
- operationId → route name

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

**File:** `Http/Resources/GameResource.php`

```php
class GameResource extends JsonResource
{
    /**
     * HTTP status code for this response
     * MUST be set by Handler
     */
    public int $httpCode;

    /**
     * Location header for 201 Created responses
     * REQUIRED for createGame (201)
     * NOT used for getGame (200)
     */
    public ?string $location = null;

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
```

**Auto-generated from:**
- OpenAPI response schemas (Game schema) → `toArray()` structure
- OpenAPI response headers → public properties (`$location`, `$xTotalCount`, etc.)
- OpenAPI response codes per operation → `withResponse()` validation logic

**This Pattern Solves Everything:**
- ✅ **PSR-4 Compliant** - One class per file
- ✅ **Reusable** - Same Resource for multiple operations (createGame=201, getGame=200)
- ✅ **Validates HTTP Code** - Runtime check ensures Handler set it
- ✅ **Validates Headers** - Required headers checked based on HTTP code
- ✅ **Type-Safe Data** - `toArray()` structure from OpenAPI schema
- ✅ **No Post-Processing** - All generated directly from templates

**Error Resources:**

**File:** `Http/Resources/ValidationErrorResource.php`

```php
class ValidationErrorResource extends JsonResource
{
    public int $httpCode;

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
        if (!isset($this->httpCode)) {
            throw new \RuntimeException('HTTP status code not set for ValidationErrorResource. Handler must set $resource->httpCode');
        }

        $response->setStatusCode($this->httpCode);
    }
}
```

**File:** `Http/Resources/UnauthorizedErrorResource.php`

```php
class UnauthorizedErrorResource extends JsonResource
{
    public int $httpCode;

    public function toArray($request): array
    {
        return [
            'error' => 'Unauthorized',
            'message' => $this->resource['message'] ?? 'Authentication required',
        ];
    }

    public function withResponse($request, $response)
    {
        if (!isset($this->httpCode)) {
            throw new \RuntimeException('HTTP status code not set for UnauthorizedErrorResource. Handler must set $resource->httpCode');
        }

        $response->setStatusCode($this->httpCode);
    }
}
```

### 9. Handler Implementation (Developer Code)

**File:** `Api/Handlers/GameApiHandler.php`

**This is what the DEVELOPER writes** (not generated):

```php
class GameApiHandler implements GameApi
{
    public function createGame(CreateGameRequestDto $request): GameResource|ValidationErrorResource|UnauthorizedErrorResource
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

        // Return GameResource with 201 Created
        $resource = new GameResource($game);
        $resource->httpCode = 201; // REQUIRED
        $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED for 201

        return $resource;
    }

    public function getGame(string $gameId): GameResource|ValidationErrorResource
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

        // Return GameResource with 200 OK
        $resource = new GameResource($game);
        $resource->httpCode = 200; // REQUIRED
        // Note: No Location header for GET

        return $resource;
    }
}
```

**Developer Workflow:**
1. Implement `GameApi` interface
2. Write business logic
3. Create appropriate Resource
4. **Set `$httpCode`** (required)
5. **Set header properties** (if required for that code)
6. Return Resource

**What Happens if Developer Forgets:**
- Forgets `$httpCode` → RuntimeException in `withResponse()`
- Forgets `$location` for 201 → RuntimeException in `withResponse()`
- Returns wrong Resource type → Compilation error (union types)
- Returns wrong data structure → Type error (DTO properties)

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
- Runtime: `$httpCode` set, required headers present

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
