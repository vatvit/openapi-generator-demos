# Laravel API - php-laravel Default (OOTB)

This demo project demonstrates integration with the **default (OOTB) php-laravel generator** without any custom templates.

**Purpose:** Show OOTB integration patterns and document remaining limitations.

## Quick Start

```bash
make setup    # Install dependencies
make start    # Start at http://localhost:8001
make stop     # Stop services
```

## OOTB Integration Pattern

### 1. Create Config File (Required for Proper Namespaces)

Create `openapi-generator-configs/tictactoe-config.json`:
```json
{
  "invokerPackage": "TicTacToeApi",
  "apiPackage": "TicTacToeApi\\Api",
  "modelPackage": "TicTacToeApi\\Model",
  "controllerPackage": "TicTacToeApi\\Http\\Controllers",
  "variableNamingConvention": "camelCase"
}
```

**Important:** The `controllerPackage` option is not listed in `config-help` but IS supported via config file. Without it, controllers use hardcoded `OpenAPI\Server` namespace.

### 2. Generate Code

```bash
docker run --rm -v "$(pwd)/../..:/local" \
  openapitools/openapi-generator-cli:v7.12.0 generate \
  -g php-laravel \
  -i /local/openapi-generator-specs/tictactoe/tictactoe.json \
  -o /local/projects/laravel-api--php-laravel--default/generated/tictactoe \
  -c /local/projects/laravel-api--php-laravel--default/openapi-generator-configs/tictactoe-config.json
```

### 3. Configure Autoloading (composer.json)

```json
{
  "autoload": {
    "psr-4": {
      "TicTacToeApi\\": "generated/tictactoe/",
      "PetShopApi\\": "generated/petshop/"
    }
  },
  "require": {
    "crell/serde": "^1.0"
  }
}
```

### 4. Include Generated Routes (routes/api.php)

```php
require base_path('generated/tictactoe/routes.php');
require base_path('generated/petshop/routes.php');
```

### 5. Implement Handler Interfaces

```php
class GameManagementHandler implements GameManagementApiInterface
{
    public function createGame(CreateGameRequest $request): Game
    {
        return new Game(id: 'game-123', status: GameStatus::InProgress);
    }
}
```

### 6. Register Handlers (AppServiceProvider.php)

```php
$this->app->bind(GameManagementApiInterface::class, GameManagementHandler::class);
```

## Remaining OOTB Limitations

### 1. Per-Tag Controllers (Not Per-Operation)

All operations in a tag share one controller:

```php
class GameManagementController {
    public function createGame() { ... }
    public function deleteGame() { ... }
    public function getGame() { ... }
    public function listGames() { ... }
}
```

**Impact:** Cannot have per-operation middleware, logging, or error handling.

### 2. No Security Handling

No security schemes, middleware, or authentication code generated.

### 3. Inline Validation Only

Uses `Validator::make()` instead of Laravel FormRequest:

```php
// Generated:
$validator = Validator::make($request->all(), [...]);

// Better Laravel pattern:
public function createGame(CreateGameFormRequest $request) { ... }
```

### 4. No Response DTOs

Returns raw serialized models, no response-specific classes:

```php
// Generated:
if ($apiResult instanceof Game) {
    return response()->json($this->serde->serialize($apiResult, format: 'array'), 201);
}

// Better pattern:
return CreateGame201Resource::make($result);
```

## What Works Well

- **Multiple APIs** - With `controllerPackage` config, each API gets its own namespace
- **Interface-based handlers** - Clean separation of generated code and business logic
- **Union return types** - Type-safe returns like `Game | NotFoundError`
- **Crell/Serde** - Modern serialization with PHP 8.1+ attributes
- **Auto-generated routes** - Ready to include in Laravel routing

## Comparison: OOTB vs Custom Templates

| Feature | OOTB | Custom Templates |
|---------|------|------------------|
| Controller per operation | Per tag | Per operation |
| Multiple APIs | Works (with config) | Works |
| Security middleware | None | Full support |
| FormRequest validation | Inline | FormRequest classes |
| Response DTOs | None | Per-response Resources |

**GOAL_MAX Score:** OOTB = 40%, Custom Templates = ~85%

## Project Structure

```
laravel-api--php-laravel--default/
├── app/
│   ├── Api/
│   │   └── TicTacToe/           # Handler implementations
│   └── Providers/
│       └── AppServiceProvider.php
├── generated/
│   ├── tictactoe/               # TicTacToe API
│   │   ├── Api/                 # Interfaces
│   │   ├── Http/Controllers/    # Controllers
│   │   ├── Model/               # DTOs
│   │   └── routes.php
│   └── petshop/                 # PetShop API
│       └── ...
├── openapi-generator-configs/   # Generator config files
│   ├── tictactoe-config.json
│   └── petshop-config.json
├── routes/
│   └── api.php
└── README.md
```

## Key Discovery: `controllerPackage` Option

The `controllerPackage` option is **not documented** in `config-help` output but works via config file:

```bash
# This does NOT show controllerPackage:
docker run --rm openapitools/openapi-generator-cli:v7.12.0 config-help -g php-laravel

# But it WORKS in config file:
{
  "controllerPackage": "MyApi\\Http\\Controllers"
}
```

This enables proper namespace isolation for multiple APIs.

## Related Documentation

- [GENERATOR-ANALYSIS.md](../../openapi-generator-server-templates/openapi-generator-server-php-laravel-default/GENERATOR-ANALYSIS.md)
- [GENERATOR-COMPARISON.md](../../docs/GENERATOR-COMPARISON.md)
- [GOAL_MAX.md](../../GOAL_MAX.md)
