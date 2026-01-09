# Laravel php-max Integration Tests

Integration test project for validating `php-max` generated Laravel libraries.

## Overview

This project demonstrates integration of `php-max` generated code into a Laravel application, with comprehensive tests for both TicTacToe and Petshop APIs.

## Quick Start

```bash
# Install dependencies
make setup

# Run tests
make test

# Run PHPStan
make phpstan
```

## Project Structure

```
├── app/
│   └── Handlers/              # Handler implementations
│       ├── Tictactoe/         # TicTacToe API handlers
│       └── Petshop/           # Petshop API handlers
├── tests/
│   └── Feature/               # Integration tests
│       ├── Tictactoe/         # TicTacToe API tests
│       └── Petshop/           # Petshop API tests
├── phpstan.neon               # PHPStan configuration (level 6)
└── composer.json              # Dependencies + PSR-4 autoload
```

## Generated Libraries

Libraries are located in `../../generated/php-max-laravel/`:

| Library | Spec | Namespace |
|---------|------|-----------|
| tictactoe | `openapi-generator-specs/tictactoe/` | `TictactoeApi` |
| petshop | `openapi-generator-specs/petshop/` | `PetshopApi` |

## Running Tests

```bash
# All tests
make test

# Specific test file
docker-compose exec app php artisan test tests/Feature/Tictactoe/

# PHPStan static analysis
make phpstan
```

## Regenerating Libraries

```bash
# From repo root
make generate-max-laravel
```

## Test Coverage

- Handler interface compliance
- Request validation
- Response structure validation
- Model serialization
- Route registration
