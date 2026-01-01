---
code: GENDE-017
status: Implemented
dateCreated: 2026-01-01T14:28:27.894Z
type: Feature Enhancement
priority: Medium
relatedTickets: GENDE-010
---

# Create OOTB Demo Project for php-laravel Default Generator

## 1. Description

### Problem Statement

Following the research guide, each generator option needs its own demo project. For Laravel we have:
- `laravel-api--php-laravel--replaced-tags/` - Custom templates demo
- `laravel-api--laravel-max--integration-tests/` - Custom generator demo

But we're missing the **OOTB baseline demo** that shows default php-laravel output integration.

### Goal

Create demo project using **default php-laravel generated code** (no custom templates) to:
1. Show OOTB integration patterns
2. Reveal OOTB limitations
3. Serve as baseline for comparison with custom templates

### Project Naming

```
projects/laravel-api--php-laravel--default/    # This ticket
projects/laravel-api--php-laravel--custom/     # Rename existing --replaced-tags?
```

## 2. Rationale

- **Consistency** - Match Symfony path (GENDE-013)
- **Baseline** - See what OOTB provides before customization
- **Comparison** - Quantify improvements from custom templates

## 3. Solution Analysis

### Options

**Option A: Create new OOTB project**
- Create `laravel-api--php-laravel--default/`
- Keep existing `--replaced-tags` as custom demo
- Most complete, but more maintenance

**Option B: Document OOTB in existing project**
- Add OOTB branch or documentation
- Less overhead
- Less clear separation

**Recommended: Option A** for consistency with research guide.

## 4. Implementation Specification
### Completed Implementation

**Project created:** `projects/laravel-api--php-laravel--default/`

**Key Discovery:** The `controllerPackage` option is undocumented but works via config file, enabling proper namespace isolation for multiple APIs.

**Components:**
- Fresh Laravel 12 application with Docker (port 8001)
- Both TicTacToe and PetShop APIs generated with proper namespaces
- Config files in `openapi-generator-configs/` with `controllerPackage` setting
- Handler implementations for TicTacToe (4 interfaces)
- Service provider bindings
- Comprehensive README documenting integration pattern

**Config file format (key discovery):**
```json
{
  "invokerPackage": "TicTacToeApi",
  "apiPackage": "TicTacToeApi\\Api",
  "modelPackage": "TicTacToeApi\\Model",
  "controllerPackage": "TicTacToeApi\\Http\\Controllers"
}
```

**Remaining OOTB Limitations:**
1. Per-tag controllers (not per-operation)
2. No security handling
3. Inline validation (no FormRequest)
4. No response DTOs

**Files created:**
- `openapi-generator-configs/*.json` - Config files for proper namespaces
- `app/Api/TicTacToe/*.php` - 4 handler implementations
- `generated/tictactoe/` - TicTacToe API (correct namespaces)
- `generated/petshop/` - PetShop API (correct namespaces)
- Docker, Makefile, README.md
## 5. Acceptance Criteria

- [ ] Project created at `projects/laravel-api--php-laravel--default/`
- [ ] Uses OOTB php-laravel generator (no custom templates)
- [ ] Both TicTacToe and PetShop APIs integrated
- [ ] `make setup && make start` works
- [ ] Integration limitations documented in README