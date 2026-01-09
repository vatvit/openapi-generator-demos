# Slim php-max Integration Tests

Integration test project for validating `php-max` generated Slim Framework libraries.

## Overview

This project demonstrates integration of `php-max` generated code into a Slim 4 application, with comprehensive tests for both TicTacToe and Petshop APIs.

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
├── public/
│   └── index.php              # Application entry point
├── phpstan.neon               # PHPStan configuration (level 6)
└── composer.json              # Dependencies + PSR-4 autoload
```

## Generated Libraries

Libraries are located in `../../generated/php-max-slim/`:

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
make generate-max-slim
```

## Test Coverage

- Handler interface compliance
- Request validation
- Response structure validation
- Model serialization
- Route registration
- DI container configuration
