# Symfony API - php-max (symfony-max) Generator Demo

This demo project demonstrates the **php-max generator** with **symfony-max** output for Symfony applications.

## Overview

- **Generator:** `php-max` (custom multi-framework generator)
- **Output Type:** `symfony-max` (Symfony-optimized code)
- **Generated Library:** `../../generated/symfony-max/tictactoe/`
- **Port:** 8003

## Features

The generated code includes:
- One controller per operation with `#[Route]` attributes
- Symfony Validator `#[Assert\...]` attributes on DTOs
- Type-safe DTOs with PHP 8.1+ features
- Union return types on handler interfaces
- Response DTOs with status code enforcement
- Security interfaces

## Quick Start

```bash
make setup    # Install dependencies
make start    # Start at http://localhost:8003
make stop     # Stop services
```

## Generate Code

```bash
# Regenerate from OpenAPI spec
cd ../../openapi-generator-generators/php-max
make generate \
    SPEC=openapi-generator-specs/tictactoe/tictactoe.json \
    OUTPUT_DIR=generated/symfony-max/tictactoe \
    GENERATOR=symfony-max
```

## Testing

```bash
make test-phpunit
```

## Project Structure

```
symfony-api--php-max--default/
├── config/
│   ├── routes.yaml           # Includes generated routes
│   └── services.yaml         # Service bindings
├── src/
│   └── Handler/              # Handler implementations
├── tests/
│   └── Controller/           # Integration tests
├── composer.json             # References generated lib
└── docker-compose.yml        # Port 8003
```

## Generated Library Structure

```
generated/symfony-max/tictactoe/src/
├── Controller/               # One per operation
├── Dto/                      # Request DTOs
├── Handler/                  # Handler interfaces
├── Model/                    # DTOs with Assert attributes
├── Response/                 # Response DTOs
└── Security/                 # Security interfaces
```

## Integration Pattern

### 1. Autoload Generated Code (composer.json)

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/",
      "TictactoeApi\\": "../../generated/symfony-max/tictactoe/src/"
    }
  }
}
```

### 2. Import Routes (config/routes.yaml)

```yaml
tictactoe_controllers:
    resource: ../../generated/symfony-max/tictactoe/src/Controller/
    type: attribute
```

### 3. Register Services (config/services.yaml)

```yaml
services:
    # Generated controllers
    TictactoeApi\Api\Controller\:
        resource: '../../generated/symfony-max/tictactoe/src/Controller/'
        tags: ['controller.service_arguments']

    # Handler bindings
    TictactoeApi\Api\Handler\GameManagementHandlerInterface:
        class: App\Handler\GameManagementHandler
```

### 4. Implement Handler Interfaces

```php
use TictactoeApi\Api\Handler\GameManagementHandlerInterface;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Model\Game;

class GameManagementHandler implements GameManagementHandlerInterface
{
    public function createGame(
        CreateGameRequest $create_game_request
    ): CreateGame201Response|CreateGame400Response|CreateGame401Response|CreateGame422Response {
        $game = new Game(
            id: 'game-123',
            status: GameStatus::PENDING
        );
        return CreateGame201Response::create($game);
    }
}
```

## Key Differences: OOTB php-symfony vs php-max

| Feature | OOTB php-symfony | php-max symfony-max |
|---------|------------------|---------------------|
| Controller per operation | Per tag | Per operation |
| Return type safety | `array\|object\|null` | Union types |
| Response codes | Pass-by-reference | Response DTOs |
| Validation | JMS Serializer | Symfony Assert |
| Security | Method setters | Interface-based |
| Controller routing | YAML config | `#[Route]` attributes |

**GOAL_MAX Score:** OOTB = 54%, php-max = 95%

## Make Commands

```bash
make help         # Show all commands
make setup        # Install dependencies
make start        # Start Docker services (port 8003)
make stop         # Stop Docker services
make logs         # View application logs
make shell        # Open container shell
make test-phpunit # Run tests
make cache-clear  # Clear Symfony cache
```

## Related Documentation

- [php-max Generator](../../openapi-generator-generators/php-max/)
- [GOAL_MAX.md](../../GOAL_MAX.md)
