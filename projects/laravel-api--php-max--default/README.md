# Laravel API - php-max (laravel-max) Generator Demo

This demo project demonstrates the **php-max generator** with **laravel-max** output for Laravel applications.

## Overview

- **Generator:** `php-max` (custom multi-framework generator)
- **Output Type:** `laravel-max` (Laravel-optimized code)
- **Generated Library:** `../../generated/laravel-max/tictactoe/`
- **Port:** 8002

## Features

The generated code includes:
- One controller per operation
- Laravel FormRequest for validation
- Laravel JsonResource for responses
- Type-safe DTOs with PHP 8.1+ features
- Union return types on handler interfaces
- Security interfaces

## Quick Start

```bash
make setup    # Install dependencies
make start    # Start at http://localhost:8002
make stop     # Stop services
```

## Generate Code

```bash
# Regenerate from OpenAPI spec
cd ../../openapi-generator-generators/php-max
make generate \
    SPEC=openapi-generator-specs/tictactoe/tictactoe.json \
    OUTPUT_DIR=generated/laravel-max/tictactoe \
    GENERATOR=laravel-max
```

## Testing

```bash
make test-phpunit
```

## Project Structure

```
laravel-api--php-max--default/
├── app/
│   ├── Handlers/          # Handler implementations
│   └── Providers/         # Service bindings
├── routes/
│   └── api.php            # Includes generated routes
├── tests/
│   └── Feature/           # Integration tests
├── composer.json          # References generated lib
└── docker-compose.yml     # Port 8002
```

## Generated Library Structure

```
generated/laravel-max/tictactoe/app/
├── Handlers/              # Handler interfaces
├── Http/
│   ├── Controllers/       # One per operation
│   ├── Requests/          # FormRequest classes
│   └── Resources/         # JsonResource classes
├── Models/                # DTOs and Enums
├── Security/              # Security interfaces
└── routes/
    └── api.php            # Route definitions
```

## Integration Pattern

### 1. Autoload Generated Code (composer.json)

```json
{
  "autoload": {
    "psr-4": {
      "TictactoeApi\\": "../../generated/laravel-max/tictactoe/app/"
    }
  }
}
```

### 2. Include Generated Routes (routes/api.php)

```php
require base_path('../../generated/laravel-max/tictactoe/routes/api.php');
```

### 3. Implement Handler Interfaces

```php
use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;

class GameManagementHandler implements GameManagementApiHandlerInterface
{
    public function createGame(CreateGameRequest $request)
        : CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource
    {
        $game = new Game(id: 'game-123', status: GameStatus::PENDING);
        return new CreateGame201Resource($game);
    }
}
```

### 4. Register Handlers (AppServiceProvider.php)

```php
$this->app->bind(GameManagementApiHandlerInterface::class, GameManagementHandler::class);
```

## Comparison: OOTB php-laravel vs php-max

| Feature | OOTB php-laravel | php-max |
|---------|------------------|---------|
| Controller per operation | Per tag | Per operation |
| Validation | Inline Validator | FormRequest |
| Responses | Raw arrays | JsonResource |
| Security | None | Full interfaces |
| Handler return types | Single type | Union types |
| Multi-framework | Laravel only | Laravel, Symfony, more |

**GOAL_MAX Score:** OOTB = 40%, php-max = 95%

## Related Documentation

- [php-max Generator](../../openapi-generator-generators/php-max/)
- [GOAL_MAX.md](../../GOAL_MAX.md)
