# Laravel API Example - Laravel Max Library

This is an example Laravel project that demonstrates using the `laravel-max` generated library from OpenAPI specifications.

## Requirements

| Dependency | Version |
|------------|---------|
| PHP | 8.4+ |
| Laravel | 12.x |
| OpenAPI Generator | 7.18.0 |
| Java | 11+ (for generator) |

## Purpose

This project shows:
- ✅ How to integrate the generated `laravel-max` library into a Laravel application
- ✅ How to configure middleware groups for security validation
- ✅ How to bind Handler interfaces to implementations
- ✅ How to include generated routes
- ✅ PHPUnit tests validating the API works correctly

## Structure

```
laravel-api--example--laravel-max/
├── app/
│   └── Providers/
│       └── AppServiceProvider.php      # Binds GameApi interface to handler
├── bootstrap/
│   └── app.php                         # Laravel 11 bootstrap with middleware config
├── routes/
│   ├── api.php                         # Includes generated routes
│   └── console.php                     # Console routes
├── tests/
│   └── Feature/
│       └── GameApiTest.php             # PHPUnit tests for Game API
├── composer.json                       # Autoloads LaravelMaxApi\ namespace
├── phpunit.xml                         # PHPUnit configuration
└── Makefile                            # Docker commands for testing
```

## Library Integration

### 1. Autoloading (composer.json)

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "TictactoeApi\\": "../../generated/laravel-max/tictactoe/app/"
        }
    }
}
```

The generated library is autoloaded under the `TictactoeApi\` namespace from `generated/laravel-max/tictactoe/`.
This unique namespace prevents conflicts with the application's own `App\` namespace.

**Why a unique namespace?**
- Prevents naming collisions with application code
- Makes it clear which code is generated vs application-specific
- Allows side-by-side usage of multiple generated libraries
- Follows package naming best practices

### 2. Middleware Configuration (bootstrap/app.php)

```php
->withMiddleware(function (Middleware $middleware) {
    // Register security middleware groups for OpenAPI security schemes
    $middleware->group('api.security.bearerHttpAuthentication', [
        LaravelMaxApi\Http\Middleware\AuthenticateGame::class,
    ]);
})
```

This satisfies the security middleware validation from the library.

### 3. Service Binding (app/Providers/AppServiceProvider.php)

```php
public function register(): void
{
    // Bind per-operation handler interfaces to implementation
    $this->app->bind(CreateGameApiHandlerInterface::class, TictactoeApiHandler::class);
    $this->app->bind(DeleteGameApiHandlerInterface::class, TictactoeApiHandler::class);
    $this->app->bind(GetBoardApiHandlerInterface::class, TictactoeApiHandler::class);
    // ... and so on for each operation
}
```

The generator creates one handler interface per operation. Bind each to your implementation class.
Laravel's dependency injection will automatically inject the handler into controllers.

### 4. Route Registration (routes/api.php)

```php
Route::group(['middleware' => ['api']], function ($router) {
    // Include generated routes from laravel-max library
    // Routes are included WITHOUT prefix to match OpenAPI spec exactly
    require base_path('../../generated/laravel-max/tictactoe/routes/api.php');
});
```

Generated routes are included **without any prefix** to match the OpenAPI specification exactly.

## Running Tests

### Install Dependencies

```bash
make install
```

This runs `composer install` via Docker (no local PHP needed).

### Run Tests

```bash
make test
```

This runs all PHPUnit tests via Docker.

### Run Tests with Verbose Output

```bash
make test-verbose
```

## Test Coverage

The `GameApiTest` feature test validates:

✅ **Route Registration** - Routes are properly registered
✅ **Create Game (201)** - Returns 201 with Location header
✅ **Create Game Validation** - Required fields validated
✅ **Mode Enum Validation** - Invalid mode rejected
✅ **Conditional Validation** - playerOId required for two-player mode
✅ **Single Player Mode** - Allows single-player without playerOId
✅ **Get Game (200)** - Returns 200 without Location header
✅ **Get Game (404-like)** - Returns 422 for game not found
✅ **Get Game (Invalid ID)** - Returns 422 for invalid game ID
✅ **Location Header** - Points to correct getGame route
✅ **Health Check** - Application health endpoint works

## API Endpoints

Routes match the OpenAPI specification exactly (no `/api` or `/v1` prefix).

### POST /games
Create a new game

**Request:**
```json
{
    "mode": "two-player",
    "playerXId": "player1",
    "playerOId": "player2"
}
```

**Response:** HTTP 201 Created
```
Location: http://localhost/games/{gameId}
```
```json
{
    "id": "game_abc123",
    "status": "waiting",
    "mode": "two-player",
    "playerXId": "player1",
    "playerOId": "player2",
    "currentTurn": "X",
    "winner": null,
    "createdAt": "2025-12-27T12:00:00+00:00",
    "updatedAt": "2025-12-27T12:00:00+00:00"
}
```

### GET /games/{gameId}
Get game details

**Response:** HTTP 200 OK
```json
{
    "id": "game_abc123",
    "status": "in-progress",
    "mode": "two-player",
    "playerXId": "player1",
    "playerOId": "player2",
    "currentTurn": "O",
    "winner": null,
    "createdAt": "2025-01-01T00:00:00+00:00",
    "updatedAt": "2025-12-27T12:00:00+00:00"
}
```

## What This Demonstrates

This example project proves that the `laravel-max` library achieves all goals:

✅ **Easy Integration** - Just autoload and include routes
✅ **Contract Enforcement** - Interface binding enforces API contract
✅ **Security Validation** - Middleware groups validated in debug mode
✅ **Automatic Validation** - FormRequest validates based on OpenAPI schema
✅ **Type Safety** - DTOs and Resources enforce data structures
✅ **HTTP Code Enforcement** - Resources hardcode correct status codes
✅ **Header Enforcement** - Required headers validated at runtime
✅ **Developer-Friendly** - Tests show simple usage patterns

## Key Takeaways

1. **No Manual Route Definitions** - Routes auto-generated from OpenAPI
2. **No Manual Validation** - FormRequest rules from OpenAPI schema
3. **Type-Safe Everywhere** - DTOs, Resources, Interfaces
4. **Security Enforced** - Middleware validation catches configuration errors
5. **Tests Pass** - Everything works as specified in OpenAPI contract

This is the **proof** that the library works correctly! 🎉

## Test Results

All 25 PHPUnit tests pass successfully:

```
OK (25 tests, 66 assertions)
```

Tests cover:
- Game Management (create, get, list, delete)
- Gameplay (board, moves, squares)
- Statistics (leaderboard, player stats)
- Error handling (404, 400, 409 responses)

**Requirements:**
- PHP 8.4+ (tests run via Docker with `php:8.4-cli`)
- Laravel 12.x
- Composer dependencies installed via `make install`
