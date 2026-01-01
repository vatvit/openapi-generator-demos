# Symfony API - php-symfony Default (OOTB)

This demo project demonstrates integration with the **default (OOTB) php-symfony generator** without any custom templates.

**Symfony Version:** 8.0 (latest stable, requires PHP 8.4+)

**Purpose:** Show OOTB integration patterns, validate generated code works, and document remaining limitations.

## Quick Start

```bash
make setup    # Install dependencies
make start    # Start at http://localhost:8002
make stop     # Stop services
```

## OOTB Integration Pattern

### 1. Generate Code with Config Files

```bash
docker run --rm -v "$(pwd)/../..:/local" \
  openapitools/openapi-generator-cli:v7.12.0 generate \
  -g php-symfony \
  -i /local/openapi-generator-specs/tictactoe/tictactoe.json \
  -o /local/projects/symfony-api--php-symfony--default/generated/tictactoe \
  -c /local/projects/symfony-api--php-symfony--default/openapi-generator-configs/tictactoe-config.json
```

### 2. Configure Autoloading (composer.json)

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/",
      "TicTacToeApi\\": "generated/tictactoe/",
      "PetShopApi\\": "generated/petshop/"
    }
  }
}
```

### 3. Register Bundles (config/bundles.php)

```php
return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    JMS\SerializerBundle\JMSSerializerBundle::class => ['all' => true],
    TicTacToeApi\TicTacToeApiBundleBundle::class => ['all' => true],
    PetShopApi\PetShopApiBundleBundle::class => ['all' => true],
];
```

### 4. Import Routes (config/routes.yaml)

```yaml
tictactoe_api:
    resource: "../generated/tictactoe/Resources/config/routing.yaml"
    prefix: /api/tictactoe

petshop_api:
    resource: "../generated/petshop/Resources/config/routing.yaml"
    prefix: /api/petshop
```

### 5. Import Services (config/services.yaml)

```yaml
imports:
    - { resource: '../generated/tictactoe/Resources/config/services.yaml' }
    - { resource: '../generated/petshop/Resources/config/services.yaml' }

services:
    # Bind handler implementations to API interfaces
    TicTacToeApi\TicTacToeApi\Api\GameManagementApiInterface:
        class: App\Handler\TicTacToe\GameManagementHandler
```

### 6. Implement Handler Interfaces

```php
class GameManagementHandler implements GameManagementApiInterface
{
    public function setbearerHttpAuthentication(?string $value): void
    {
        $this->bearerToken = $value;
    }

    public function createGame(
        CreateGameRequest $createGameRequest,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null {
        $game = new Game([
            'id' => 'game-' . uniqid(),
            'status' => GameStatus::InProgress,
        ]);

        $responseCode = 201;
        return $game;
    }
}
```

## Key Observations

### Namespace Duplication Issue

The generator creates duplicated namespaces:
- Interface: `TicTacToeApi\TicTacToeApi\Api\GameManagementApiInterface`
- Model: `TicTacToeApi\TicTacToeApi\Model\Game`

This happens because `apiPackage` and `modelPackage` include the `invokerPackage` prefix.

### Handler Interface Pattern

Unlike php-laravel which uses union return types, php-symfony uses:
- `array|object|null` return type
- Pass-by-reference `&$responseCode` parameter
- Pass-by-reference `&$responseHeaders` parameter

```php
public function createGame(
    CreateGameRequest $createGameRequest,
    int &$responseCode,           // Set response code here
    array &$responseHeaders       // Add headers here
): array|object|null;             // Return model or error
```

### Security Methods

Each interface includes authentication setter methods:
```php
public function setbearerHttpAuthentication(?string $value): void;
public function setdefaultApiKey(?string $value): void;
public function setapp2AppOauth(?string $value): void;
```

## OOTB Limitations

### 1. Weak Return Type Safety
```php
// Generated interface - any object allowed
public function createGame(...): array|object|null;

// vs. php-laravel union types
public function createGame(...): Game | BadRequestError | UnauthorizedError;
```

### 2. Manual Response Code Management
Developer must set `$responseCode` manually - no type-safe response factories.

### 3. No Per-Operation Controllers
All operations in a tag share one controller class.

### 4. JMS Serializer Required
Requires JMS Serializer bundle for model serialization.

## Project Structure

```
symfony-api--php-symfony--default/
├── config/
│   ├── bundles.php          # Bundle registration
│   ├── routes.yaml          # Route imports
│   └── services.yaml        # Service bindings
├── generated/
│   ├── tictactoe/           # TicTacToe API bundle
│   │   ├── Api/             # Interfaces
│   │   ├── Controller/      # Controllers
│   │   ├── Model/           # DTOs with JMS annotations
│   │   └── Resources/config/
│   │       ├── routing.yaml
│   │       └── services.yaml
│   └── petshop/             # PetShop API bundle
├── src/
│   └── Handler/             # Handler implementations
│       ├── TicTacToe/
│       └── PetShop/
├── docker-compose.yml
├── Dockerfile
└── Makefile
```

## Comparison: php-symfony vs php-laravel

| Feature | php-symfony | php-laravel |
|---------|-------------|-------------|
| Output type | Symfony Bundle | Laravel Library |
| Return type safety | `array\|object\|null` | Union types |
| Response codes | Pass-by-reference | Implicit in return type |
| Serialization | JMS Serializer | Crell/Serde |
| Validation | Symfony Validator | Laravel Validator |
| Security | Method-based setters | None |
| DI config | services.yaml | Manual binding |
| Documentation | Model + API docs | Basic README |
| GOAL_MAX score | 54% | 40% |

## Make Commands

```bash
make help         # Show all commands
make setup        # Install dependencies
make start        # Start Docker services (port 8002)
make stop         # Stop Docker services
make logs         # View application logs
make shell        # Open container shell
make generate     # Regenerate APIs
make routes       # List all routes
make cache-clear  # Clear Symfony cache
```

## Related Documentation

- [GENERATOR-ANALYSIS.md](../../openapi-generator-server-templates/openapi-generator-server-php-symfony-default/GENERATOR-ANALYSIS.md)
- [GOAL_MAX.md](../../GOAL_MAX.md)
