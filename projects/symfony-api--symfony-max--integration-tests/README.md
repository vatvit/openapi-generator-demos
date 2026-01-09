# Symfony php-max Integration Tests

Integration test project for validating `php-max` generated Symfony libraries.

## Overview

This project demonstrates integration of `php-max` generated code into a Symfony application, with comprehensive tests for both TicTacToe and Petshop APIs.

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
├── src/
│   └── Handler/               # Handler implementations
│       ├── Tictactoe/         # TicTacToe API handlers
│       └── Petshop/           # Petshop API handlers
├── tests/
│   └── Integration/           # Integration tests
│       ├── Tictactoe/         # TicTacToe API tests
│       └── Petshop/           # Petshop API tests
├── config/
│   ├── routes.yaml            # Route imports
│   └── services.yaml          # Service configuration
├── phpstan.neon               # PHPStan configuration (level 6)
└── composer.json              # Dependencies + PSR-4 autoload
```

## Generated Libraries

Libraries are located in `../../generated/php-max-symfony/`:

| Library | Spec | Namespace |
|---------|------|-----------|
| tictactoe | `openapi-generator-specs/tictactoe/` | `TictactoeApi` |
| petshop | `openapi-generator-specs/petshop/` | `PetshopApi` |

## Running Tests

```bash
# All tests
make test

# PHPStan static analysis
make phpstan
```

## Regenerating Libraries

```bash
# From repo root
make generate-max-symfony
```

## Test Coverage

- Handler interface compliance
- Request validation
- Response structure validation
- Model serialization
- Route registration
- Service container wiring
