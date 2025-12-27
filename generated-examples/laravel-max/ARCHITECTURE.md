# Laravel-Max Library Architecture

This document describes the architecture patterns used in the laravel-max generated library.

## ⚠️ CRITICAL: Separation of Library vs Application

**THE LIBRARY DOES NOT CONTAIN BUSINESS LOGIC IMPLEMENTATIONS**

### What's in the Generated Library (laravel-max/)

✅ **Interface (Contract)** - `GameApi.php` - Defines what must be implemented
✅ **Controllers** - HTTP layer, delegates to interface
✅ **FormRequests** - Validation rules from OpenAPI
✅ **Resources** - Response formatting and status codes
✅ **DTOs** - Data transfer objects
✅ **Routes** - Route definitions
✅ **Middleware** - Optional framework middleware

❌ **NO Handler Implementation** - Business logic is NOT included

### What's in the Application (your project/)

✅ **Handler Implementation** - `app/Api/GameApiHandler.php` - YOUR business logic
✅ **Service Provider Binding** - Maps interface to your implementation
✅ **Database Models** - Eloquent models
✅ **Database Migrations** - Schema definitions
✅ **Application-specific Middleware** - Custom auth, logging, etc.

### Why This Separation?

1. **Reusability** - Library can be used across multiple projects
2. **Testability** - Test business logic separately from framework
3. **Flexibility** - Swap implementations without changing library
4. **Clear Boundaries** - Framework code vs. business code
5. **Composer Compatibility** - Library can be published as package

### How It Works

```
┌─────────────────────────────────────────────────────────────┐
│ Generated Library (laravel-max/) - Framework Components     │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────┐      ┌─────────────────┐                │
│  │ GameApi.php  │◄─────│ Controllers     │                │
│  │ (Interface)  │      │ - CreateGame    │                │
│  └──────────────┘      │ - GetGame       │                │
│         ▲              │ - ListGames     │                │
│         │              └─────────────────┘                │
│         │                                                  │
│         │              ┌─────────────────┐                │
│         │              │ FormRequests    │                │
│         │              │ Resources       │                │
│         │              │ DTOs            │                │
│         │              └─────────────────┘                │
│         │                                                  │
└─────────┼──────────────────────────────────────────────────┘
          │
          │ implements
          │
┌─────────┼──────────────────────────────────────────────────┐
│         │                                                  │
│  ┌──────▼──────────┐                                       │
│  │ GameApiHandler  │ ◄──── YOUR BUSINESS LOGIC            │
│  │ (app/Api/)      │                                       │
│  └─────────────────┘                                       │
│         │                                                  │
│         ├─── Database operations                           │
│         ├─── External API calls                            │
│         ├─── Business validation                           │
│         └─── Domain logic                                  │
│                                                             │
│ Application (your project/) - Business Logic               │
└─────────────────────────────────────────────────────────────┘
```

### Integration Example

**1. Generated Library provides Interface:**
```php
// generated-examples/laravel-max/Api/GameApi.php
interface GameApi
{
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource;
}
```

**2. Application implements Interface:**
```php
// app/Api/GameApiHandler.php
class GameApiHandler implements GameApi
{
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource
    {
        // YOUR business logic here:
        // - Database operations
        // - External services
        // - Business rules
        $game = Game::create([...]);

        $resource = new CreateGame201Resource($game);
        $resource->location = route('api.getGame', ['gameId' => $game->id]);
        return $resource;
    }
}
```

**3. Service Provider binds them:**
```php
// app/Providers/AppServiceProvider.php
$this->app->bind(GameApi::class, GameApiHandler::class);
```

**4. Controller uses Interface:**
```php
// Library controller automatically gets your implementation via DI
class CreateGameController
{
    public function __construct(private readonly GameApi $handler) {}

    public function __invoke(CreateGameRequest $request): JsonResponse
    {
        // $handler is YOUR GameApiHandler via binding
        $resource = $this->handler->createGame($dto);
        return $resource->response($request);
    }
}
```

## Controller Pattern: One Controller Per Operation

**PATTERN:** Each OpenAPI operation gets its own dedicated controller class.

### Advantages

1. **Clear 1:1 Mapping** - Direct correspondence between OpenAPI operations and controllers
2. **Easier Code Generation** - Generator can create files mechanically without complex logic
3. **Single Responsibility** - Each controller does exactly one thing
4. **Better Testability** - One test file per controller, focused tests
5. **Improved Discoverability** - Clear which controller handles which operation
6. **Operation-Specific Dependencies** - Each controller can inject only what it needs
7. **Simpler Maintenance** - Changes to one operation don't affect others

### Structure

```
Http/Controllers/
├── CreateGameController.php      # POST /games
├── ListGamesController.php       # GET /games
├── GetGameController.php         # GET /games/{gameId}
├── DeleteGameController.php      # DELETE /games/{gameId}
├── GetBoardController.php        # GET /games/{gameId}/board
└── PutSquareController.php       # PUT /games/{gameId}/board/{row}/{column}
```

### Controller Template

Each controller is an **invokable controller** (single `__invoke()` method):

```php
class CreateGameController
{
    public function __construct(
        private readonly GameApi $handler
    ) {}

    public function __invoke(CreateGameRequest $request): JsonResponse
    {
        $dto = CreateGameRequestDto::fromArray($request->validated());
        $resource = $this->handler->createGame($dto);
        return $resource->response($request);
    }
}
```

### Route Definition

Routes use the controller class directly:

```php
$router->POST('/games', LaravelMaxApi\Http\Controllers\CreateGameController::class)
    ->name('api.createGame');
```

## Authentication Middleware

**PATTERN:** Security middleware groups correspond to OpenAPI security schemes.

### Middleware Structure

```
Http/Middleware/
└── AuthenticateApiToken.php  # Bearer token authentication
```

### Registration (bootstrap/app.php)

```php
$middleware->group('api.security.bearerHttpAuthentication', [
    LaravelMaxApi\Http\Middleware\AuthenticateApiToken::class,
]);
```

### How It Works

1. **OpenAPI Spec** defines security scheme: `bearerHttpAuthentication`
2. **Generated Routes** automatically attach middleware group if defined
3. **Application** implements middleware and registers it in bootstrap/app.php
4. **Middleware** validates Bearer token and attaches user info to request

### Example Authentication Flow

```
Request: POST /games
Headers: Authorization: Bearer test-token-123

↓

Route → Middleware Group → AuthenticateApiToken
                          ↓
                   Validate token
                   Extract user ID
                   Attach to request
                          ↓
Controller → Handler → Response
```

## Complete Request Flow

```
1. CLIENT REQUEST
   POST /games
   Authorization: Bearer test-token-123
   Body: { mode: "two-player", playerXId: "p1", playerOId: "p2" }

2. ROUTING (routes/api.php)
   → Matches route: POST /games → CreateGameController

3. MIDDLEWARE
   → api.security.bearerHttpAuthentication
   → AuthenticateApiToken validates token
   → Attaches user_id to request

4. FORM REQUEST (CreateGameRequest)
   → Validates request body
   → mode: required, enum: single-player|two-player
   → playerXId: required, string
   → playerOId: required_if:mode,two-player

5. CONTROLLER (CreateGameController)
   → Converts validated data to DTO
   → Delegates to Handler

6. HANDLER (GameApiHandler)
   → Implements business logic
   → Creates Game object
   → Returns CreateGame201Resource

7. RESOURCE (CreateGame201Resource)
   → Transforms Game to JSON
   → Sets HTTP 201 status
   → Sets Location header
   → Enforces response structure

8. RESPONSE
   HTTP/1.1 201 Created
   Location: /games/game_abc123
   Content-Type: application/json

   {
     "id": "game_abc123",
     "status": "waiting",
     "mode": "two-player",
     "playerXId": "p1",
     "playerOId": "p2",
     "currentTurn": "X",
     "winner": null,
     "createdAt": "2025-01-15T10:30:00Z",
     "updatedAt": "2025-01-15T10:30:00Z"
   }
```

## Component Responsibilities

### Controllers
- Route handling
- Request validation delegation (FormRequest)
- DTO conversion
- Handler delegation
- Response return

### FormRequests
- Input validation
- Query parameter validation
- Request body validation
- Custom error messages
- 422 Validation Error responses

### Handlers (implements GameApi interface)
- Business logic
- Database operations
- Service calls
- Resource selection (200, 404, 409, etc.)
- Header population (Location, X-Total-Count, etc.)

### Resources
- HTTP status code enforcement
- Response structure enforcement
- Header enforcement (runtime validation)
- DTO to JSON transformation

### Middleware
- Authentication
- Authorization
- Rate limiting
- Logging
- Request/response modification

## File Organization

### Generated Library Structure

```
generated-examples/laravel-max/
├── Api/
│   └── GameApi.php                    # Interface (contract) - GENERATED
├── Http/
│   ├── Controllers/
│   │   ├── CreateGameController.php   # One per operation
│   │   ├── ListGamesController.php
│   │   ├── GetGameController.php
│   │   ├── DeleteGameController.php
│   │   ├── GetBoardController.php
│   │   └── PutSquareController.php
│   ├── Middleware/
│   │   └── AuthenticateApiToken.php   # Security middleware
│   ├── Requests/
│   │   ├── CreateGameRequest.php      # Validation
│   │   ├── ListGamesRequest.php
│   │   └── MoveRequest.php
│   └── Resources/
│       ├── CreateGame201Resource.php  # One per operation+status
│       ├── GetGame200Resource.php
│       ├── ListGames200Resource.php
│       ├── DeleteGame204Resource.php
│       ├── GetBoard200Resource.php
│       ├── PutSquare200Resource.php
│       ├── ValidationErrorResource.php # Shared errors
│       ├── UnauthorizedErrorResource.php
│       ├── ForbiddenErrorResource.php
│       ├── NotFoundErrorResource.php
│       └── ConflictErrorResource.php
├── Models/
│   ├── Game.php                       # DTOs
│   ├── Board.php
│   ├── CreateGameRequestDto.php
│   ├── GameListQueryParams.php
│   └── MoveRequestDto.php
└── routes/
    └── api.php                        # Generated routes
```

### Application Structure

```
projects/laravel-api--example--laravel-max/
├── app/
│   ├── Api/
│   │   └── GameApiHandler.php         # YOUR IMPLEMENTATION
│   ├── Models/                        # Eloquent models
│   ├── Providers/
│   │   └── AppServiceProvider.php     # Interface binding
│   └── ...
├── database/
│   └── migrations/                    # Database schema
├── bootstrap/
│   └── app.php                        # Middleware registration
└── tests/
    └── Feature/
        └── GameApiTest.php            # Integration tests
```

**Key Principle:** Generated library = Framework, Application = Business Logic

## Design Patterns

### 1. Interface-First Architecture
- `GameApi` interface defines contract
- `GameApiHandler` implements business logic
- Controllers depend on interface, not implementation
- Enables dependency injection and testing

### 2. DTO Pattern
- All requests converted to typed DTOs
- All responses use typed Resources
- No loose arrays or stdClass objects
- Full IDE autocomplete support

### 3. Resource Pattern
- One Resource class per operation+status code combination
- Hardcoded HTTP status codes
- Runtime header validation
- Enforces API contract

### 4. Form Request Pattern
- Validation rules from OpenAPI schema
- Custom error messages
- Automatic 422 responses
- Reusable validation logic

### 5. Invokable Controllers
- Single `__invoke()` method
- Clean route definitions
- No method name routing
- Laravel best practice

## Code Generation Benefits

This architecture is designed for **easy code generation** from OpenAPI specs:

1. **One-to-One Mappings**
   - Operation → Controller
   - Operation+Status → Resource
   - Request Body → FormRequest
   - Schema → DTO

2. **Predictable Structure**
   - Controller naming: `{OperationId}Controller`
   - Resource naming: `{OperationId}{StatusCode}Resource`
   - FormRequest naming: `{OperationId}Request`

3. **No Complex Logic**
   - Each file is self-contained
   - No inheritance hierarchies
   - Simple template substitution

4. **Declarative Configuration**
   - OpenAPI spec is single source of truth
   - Validation rules from schema
   - Status codes from responses
   - Headers from spec

## Testing

All 31 tests passing with 131 assertions:

```bash
$ make test

OK (31 tests, 131 assertions)
```

### Test Coverage

- ✅ Route registration
- ✅ Request validation (422)
- ✅ Success responses (200, 201, 204)
- ✅ Error responses (403, 404, 409)
- ✅ Header enforcement (Location, X-Total-Count)
- ✅ Query parameter validation
- ✅ Request body validation
- ✅ Path parameter validation
- ✅ Enum validation
- ✅ Conditional validation (required_if)
- ✅ Pagination headers
- ✅ Empty body responses (204)
- ✅ Collection responses
- ✅ Nested resource paths
- ✅ Multiple path parameters
- ✅ Conflict handling (409)

## Comparison: Multiple Controllers vs. Single Controller

### Multiple Controllers (Current Approach)

**Pros:**
- ✅ Clear 1:1 mapping (operation → controller)
- ✅ Easier to generate from OpenAPI
- ✅ Better separation of concerns
- ✅ Simpler testing (one test per controller)
- ✅ Operation-specific dependencies
- ✅ Smaller, focused files

**Cons:**
- ❌ More files to manage
- ❌ Can feel verbose for simple APIs

### Single Controller (Alternative)

**Pros:**
- ✅ Fewer files
- ✅ All operations in one place
- ✅ Easier to see all endpoints at once

**Cons:**
- ❌ Harder to generate (complex logic required)
- ❌ Violates Single Responsibility Principle
- ❌ Large, monolithic files
- ❌ Complex test files
- ❌ Harder to maintain
- ❌ All operations share same dependencies

## Conclusion

The **one controller per operation** pattern is optimal for generated code:

1. Simple to generate (mechanical 1:1 mapping)
2. Follows SOLID principles
3. Clean separation of concerns
4. Easy to test and maintain
5. Scales well with API growth

The authentication middleware demonstrates how OpenAPI security schemes map to Laravel middleware groups, providing a clean integration point between generated library and application-specific authentication logic.
