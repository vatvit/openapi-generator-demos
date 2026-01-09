---
code: GENDE-077
status: Implemented
dateCreated: 2026-01-07T15:57:10.287Z
type: Feature Enhancement
priority: Low
relatedTickets: GENDE-070
---

# Add make generate-max-all command for regenerating all php-max libraries

## 1. Description

Add a unified `make generate-max-all` command to the root Makefile that regenerates all php-max libraries for all three frameworks (Laravel, Symfony, Slim) with both specs (TicTacToe, Petshop).

## 2. Rationale

Currently there's no single command to regenerate all libraries. This makes it harder to verify template changes work across all frameworks.

## 3. Solution Analysis

Add make targets that delegate to each framework's generation commands.

## 4. Implementation Specification

### New Makefile Targets
```makefile
generate-max-all: generate-max-laravel generate-max-symfony generate-max-slim

generate-max-laravel:
	# Generate both specs with Laravel templates

generate-max-symfony:
	# Generate both specs with Symfony templates

generate-max-slim:
	# Generate both specs with Slim templates
```

### Output Directories
- `generated/php-max-laravel/tictactoe/`
- `generated/php-max-laravel/petshop/`
- `generated/php-max-symfony/tictactoe/`
- `generated/php-max-symfony/petshop/`
- `generated/php-max-slim/tictactoe/`
- `generated/php-max-slim/petshop/`

## 5. Acceptance Criteria

- [x] `make generate-max-all` regenerates all 6 libraries
- [x] `make generate-max-laravel` regenerates Laravel libraries only
- [x] `make generate-max-symfony` regenerates Symfony libraries only
- [x] `make generate-max-slim` regenerates Slim libraries only
- [x] Help section updated with new commands

## 6. Implementation Notes

**Implemented:** 2026-01-09

Added to root Makefile:
- `generate-max-all` - Regenerates all 6 libraries
- `generate-max-laravel` - Regenerates tictactoe + petshop for Laravel
- `generate-max-symfony` - Regenerates tictactoe + petshop for Symfony
- `generate-max-slim` - Regenerates tictactoe + petshop for Slim

Also added PHPStan analysis targets:
- `phpstan-max-all` - Run PHPStan on all frameworks
- `phpstan-max-laravel/symfony/slim` - Framework-specific PHPStan