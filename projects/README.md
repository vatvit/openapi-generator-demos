# Integration Test Projects

This directory contains **integration test projects** that demonstrate the full integration flow of generated OpenAPI libraries.

## Purpose

Integration test projects serve two critical purposes:

1. **Validate Generated Libraries** - Verify that generated code compiles, type-checks, and functions correctly
2. **Demonstrate Integration Patterns** - Show how to integrate generated libraries into real framework applications

## Requirements

Each integration test project MUST:

### 1. Include Both API Libraries

Every project must integrate **both** generated API libraries:
- **Petshop API** - E-commerce/CRUD operations (pets, orders, users)
- **TicTacToe API** - Game logic with complex state management

This ensures the generator handles diverse API patterns:
- Simple CRUD operations
- Complex nested objects
- Enum types and validation
- Multiple response codes per operation
- Authentication schemes

### 2. Implement Handler/Business Logic

Each project must provide working handler implementations that:
- Implement all generated interfaces
- Return appropriate Response DTOs for different scenarios (200, 400, 404, 409, etc.)
- Demonstrate the contract-enforcement pattern

### 3. Comprehensive Test Coverage

Each project must have tests covering:

| Category | What to Test |
|----------|--------------|
| **Handler Tests** | Handler implements correct interface(s), returns correct Response types |
| **Response Type Tests** | All response scenarios (success, not found, validation error, conflict) |
| **Validation Tests** | Request DTOs have correct validation rules/attributes |
| **Controller Tests** | Controllers exist, are invokable, have correct dependencies |
| **Model Tests** | Models/Enums exist with correct values |
| **Integration Tests** | End-to-end handler flows (e.g., game flow with win detection) |

### 4. Docker-Based Execution

All projects must run via Docker to ensure:
- Consistent PHP version across environments
- No local dependency requirements
- Reproducible test results

### 5. Makefile with Standard Commands

Each project should have a Makefile with at minimum:
```makefile
make install   # Install dependencies
make test      # Run all tests
make help      # Show available commands
```

## Project Structure

```
projects/
├── README.md                              # This file
├── {framework}-api--{generator}--{variant}/
│   ├── Makefile                           # Build/test commands
│   ├── composer.json                      # Dependencies + autoload config
│   ├── phpunit.xml                        # Test configuration
│   ├── src/
│   │   └── Handler/                       # Handler implementations
│   │       ├── GameManagementHandler.php
│   │       ├── GameplayHandler.php
│   │       ├── StatisticsHandler.php
│   │       └── ... (petshop handlers)
│   └── tests/
│       ├── Tictactoe/                     # TicTacToe API tests
│       │   ├── GameManagementHandlerTest.php
│       │   ├── GameplayHandlerTest.php
│       │   ├── StatisticsHandlerTest.php
│       │   ├── *ControllerTest.php
│       │   └── *ValidationTest.php
│       └── Petshop/                       # Petshop API tests
│           └── ... (similar structure)
```

## Naming Convention

Project directories follow the pattern:
```
{framework/projectName}--{generator}--{variant}
```

Examples:
- `laravel-api--laravel-max--integration-tests` - Laravel with laravel-max generator
- `symfony-api--php-max--default` - Symfony with php-max/symfony-max generator

## Current Projects

| Project | Framework | Generator | APIs | Tests |
|---------|-----------|-----------|------|-------|
| `laravel-api--laravel-max--integration-tests` | Laravel | laravel-max | tictactoe, petshop | 69 tests |
| `symfony-api--php-max--default` | Symfony | symfony-max | tictactoe, petshop | 83 tests |

### Current State

**Generated Libraries:**

| Project | TicTacToe | Petshop |
|---------|-----------|---------|
| Laravel | Generated with laravel-max | Generated with laravel-max |
| Symfony | Generated with symfony-max | Generated with symfony-max |

**Implemented Handlers:**

| Project | TicTacToe Handlers | Petshop Handlers |
|---------|-------------------|------------------|
| Laravel | GameManagement, Gameplay, Statistics, TicTac | Pets |
| Symfony | GameManagement, Gameplay, Statistics | Pets |

**Autoload Configuration:**

| Project | TicTacToe | Petshop |
|---------|-----------|---------|
| Laravel | Configured | Configured |
| Symfony | Configured | Configured |

All handlers are implemented and all tests are passing.

## Test Categories Explained

### Handler Tests
Verify handlers implement the correct interfaces and return proper Response DTOs:
```php
public function test_handler_implements_interface(): void
{
    $this->assertInstanceOf(
        GameManagementApiHandlerInterface::class,
        $this->handler
    );
}

public function test_create_game_returns_201_response(): void
{
    $result = $this->handler->createGame($request);
    $this->assertInstanceOf(CreateGame201Response::class, $result);
}
```

### Response Type Tests
Verify all response scenarios work correctly:
```php
public function test_get_game_returns_404_for_notfound(): void
{
    $result = $this->handler->getGame('notfound_game');
    $this->assertInstanceOf(GetGame404Response::class, $result);
    $this->assertEquals(404, $result->getStatusCode());
}
```

### Validation Tests
Verify request DTOs have correct validation:
```php
// Laravel - FormRequest rules
public function test_rules_contain_required_mode(): void
{
    $rules = $formRequest->rules();
    $this->assertArrayHasKey('mode', $rules);
    $this->assertContains('required', $rules['mode']);
}

// Symfony - Assert attributes
public function test_mode_has_not_blank_attribute(): void
{
    $attributes = $property->getAttributes();
    $this->assertContains(
        'Symfony\Component\Validator\Constraints\NotBlank',
        $attributeNames
    );
}
```

### Controller Tests
Verify generated controllers have correct structure:
```php
public function test_controller_is_invokable(): void
{
    $reflection = new \ReflectionClass(CreateGameController::class);
    $this->assertTrue($reflection->hasMethod('__invoke'));
}

public function test_controller_has_handler_dependency(): void
{
    $constructor = $reflection->getConstructor();
    $params = $constructor->getParameters();
    // Verify handler interface is injected
}
```

### Integration Tests
Verify complex flows work end-to-end:
```php
public function test_complete_game_flow(): void
{
    // Play a complete game
    $moves = [
        ['X', 1, 1], ['O', 2, 1],
        ['X', 1, 2], ['O', 2, 2],
        ['X', 1, 3], // X wins!
    ];

    foreach ($moves as $move) {
        $result = $this->handler->putSquare(...);
        $this->assertInstanceOf(PutSquare200Response::class, $result);
    }

    // Verify game is finished
    $result = $this->handler->putSquare($gameId, 3, 1, new MoveRequest('O'));
    $this->assertInstanceOf(PutSquare409Response::class, $result);
}
```

## Adding a New Project

1. Create directory following naming convention
2. Set up framework skeleton with Docker support
3. Configure composer.json with autoload paths to generated libraries
4. Implement handlers for both APIs (tictactoe + petshop)
5. Create comprehensive test suite covering all categories
6. Add Makefile with standard commands
7. Update this README with project details

## Running Tests

From each project directory:
```bash
make test
```

Or from repository root (if configured):
```bash
make test-laravel-phpunit
make test-symfony-phpunit
```
