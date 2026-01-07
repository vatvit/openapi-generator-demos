---
code: GENDE-100
status: Implemented
dateCreated: 2026-01-07T16:40:39.173Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-099
dependsOn: GENDE-099
---

# Create Laravel integration test project

## 1. Description

Create the Laravel integration test project structure that will consume generated libraries.

## 2. Rationale

Integration project:
- Proves generated code works
- Provides real-world testing
- Documents usage patterns

## 3. Solution Analysis

### Project Structure
```
projects/laravel-api--{generator-name}--integration-tests/
├── app/
│   └── Handlers/           # Handler implementations
├── tests/
│   ├── Feature/
│   │   ├── Tictactoe/
│   │   └── Petshop/
│   └── Unit/
├── composer.json           # References generated libs
├── phpunit.xml
├── phpstan.neon
├── docker-compose.yml
└── Makefile
```

## 4. Implementation Specification

### composer.json
```json
{
  "repositories": [
    {"type": "path", "url": "../../generated/{generator}/tictactoe"},
    {"type": "path", "url": "../../generated/{generator}/petshop"}
  ]
}
```

## 5. Acceptance Criteria
- [x] Project structure created (`projects/laravel-api--php-adaptive--integration-tests/`)
- [x] composer.json configured for path repositories to generated libs
- [x] Docker environment configured (uses php:8.4-cli and composer:latest)
- [x] PHPUnit configured (11.x, runs 6 tests successfully)
- [x] PHPStan configured (level 6)
- [x] Makefile with test commands

### Project Structure
```
projects/laravel-api--php-adaptive--integration-tests/
├── app/
│   ├── Handlers/           # Handler implementations (placeholder)
│   └── Providers/          # AppServiceProvider with DI bindings
├── bootstrap/
│   └── app.php            # Laravel bootstrap
├── routes/
│   └── api.php            # API routes
├── tests/
│   └── Feature/
│       └── Tictactoe/     # TicTacToe feature tests
├── composer.json          # References ../../generated/php-adaptive/*
├── phpunit.xml
├── phpstan.neon
├── phpcs.xml
└── Makefile
```

### Verified Working
- `make install` - Composer update succeeds
- `make test` - 6 tests, 17 assertions pass
- `make lint` - All generated PHP files have valid syntax

### Autoload Mapping
```json
{
    "TicTacToeApi\\": "../../generated/php-adaptive/tictactoe/lib/",
    "PetshopApi\\": "../../generated/php-adaptive/petshop/lib/"
}
```