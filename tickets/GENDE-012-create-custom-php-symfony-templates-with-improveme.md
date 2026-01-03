---
code: GENDE-012
status: Implemented
dateCreated: 2026-01-01T14:07:32.499Z
type: Feature Enhancement
priority: High
relatedTickets: GENDE-007
dependsOn: GENDE-013
implementationNotes: Custom templates come AFTER OOTB demo project to compare improvements
---

# Create Custom php-symfony Templates with Improvements

## 1. Description

### Problem Statement

We have extracted default php-symfony templates and analyzed their capabilities (GENDE-003, score 54%). To match Laravel path parity, we need custom templates with improvements.

### Goal

Create custom php-symfony templates that:
1. Improve upon default templates where possible (within template limitations)
2. Apply learnings from GENDE-007 (Laravel-Symfony mapping)
3. Serve as foundation for future symfony-max generator
4. Generate both TicTacToe and PetShop APIs

### Scope

- Copy default templates to custom location
- Apply template-level improvements (no Java changes)
- Generate both OpenAPI specs (TicTacToe + PetShop)
- Document improvements made

## 2. Rationale

- **Parity with Laravel** - Laravel has custom templates, Symfony should too
- **Foundation for symfony-max** - When we build custom generator, templates will be ready
- **Incremental improvement** - Get as close to GOAL_MAX.md as templates allow
- **Reference material** - Documented improvements help future work

## 3. Solution Analysis

### Improvements Possible via Templates

Based on GENDE-003 and GENDE-007 analysis:

| Improvement | Template Achievable | Notes |
|-------------|--------------------|---------|
| Better typed properties | ✅ Yes | PHP 8.1+ types |
| Improved validation attributes | ✅ Yes | Symfony Assert |
| Better PHPDoc comments | ✅ Yes | Documentation |
| Cleaner controller structure | ✅ Yes | Code organization |
| Response handling | ⚠️ Partial | Limited by generator |
| Per-operation controllers | ❌ No | Requires Java generator |
| Union return types | ❌ No | Requires Java generator |
| Security middleware | ❌ No | Requires Java generator |

### Template Location

```
openapi-generator-server-templates/
├── openapi-generator-server-php-symfony-default/    # Default (reference)
│   ├── GENERATOR-ANALYSIS.md
│   └── LARAVEL-SYMFONY-MAPPING.md
└── openapi-generator-server-php-symfony/            # Custom (NEW)
    ├── README.md                                    # Improvements documented
    └── [modified templates]
```

## 4. Implementation Specification

### Steps

1. **Copy default templates**
   ```bash
   cp -r openapi-generator-server-php-symfony-default openapi-generator-server-php-symfony
   ```

2. **Review and improve templates**
   - Model templates: Better typing, validation
   - Controller templates: Cleaner structure
   - Service templates: Improved DI patterns
   - Config templates: Modern Symfony 7.x patterns

3. **Generate both specs**
   ```bash
   # TicTacToe
   docker run --rm -v "$(pwd):/local" openapitools/openapi-generator-cli:v7.12.0 generate \
     -g php-symfony \
     -i /local/openapi-generator-specs/tictactoe/tictactoe.json \
     -o /local/generated/php-symfony/tictactoe \
     -t /local/openapi-generator-server-templates/openapi-generator-server-php-symfony
   
   # PetShop
   docker run --rm -v "$(pwd):/local" openapitools/openapi-generator-cli:v7.12.0 generate \
     -g php-symfony \
     -i /local/openapi-generator-specs/petshop/petshop.json \
     -o /local/generated/php-symfony/petshop \
     -t /local/openapi-generator-server-templates/openapi-generator-server-php-symfony
   ```

4. **Document improvements** in README.md

### Deliverables

| Artifact | Location |
|----------|----------|
| Custom templates | `openapi-generator-server-templates/openapi-generator-server-php-symfony/` |
| Generated TicTacToe | `generated/php-symfony/tictactoe/` |
| Generated PetShop | `generated/php-symfony/petshop/` |
| Improvements doc | `openapi-generator-server-templates/openapi-generator-server-php-symfony/README.md` |

## 5. Acceptance Criteria
- [x] Custom templates created at specified location
- [x] TicTacToe API generated successfully
- [x] PetShop API generated successfully
- [x] Improvements documented in README.md
- [x] Templates use Symfony 7.x patterns where applicable
- [x] Generated code has `declare(strict_types=1)`

## Current State

**Completed: 2026-01-01**

### Artifact Locations

| Artifact | Location |
|----------|----------|
| Custom templates | `openapi-generator-server-templates/openapi-generator-server-php-symfony/` |
| Generated TicTacToe | `generated/php-symfony/tictactoe/` |
| Generated PetShop | `generated/php-symfony/petshop/` |
| Documentation | `openapi-generator-server-templates/openapi-generator-server-php-symfony/README.md` |

### Templates Modified

9 templates improved for PSR-12 compliance and cleaner code:

1. `model.mustache` - PSR-12 header, clean docblock, sorted imports
2. `model_generic.mustache` - Array type annotation for constructor
3. `Controller.mustache` - PSR-12 header, clean docblock
4. `api_controller.mustache` - PSR-12 header, clean docblock
5. `api.mustache` - PSR-12 header, clean docblock (interface)
6. `ApiServer.mustache` - PSR-12 header, array type annotation
7. `Bundle.mustache` - PSR-12 header, sorted imports
8. `Extension.mustache` - PSR-12 header, clean docblock
9. `ApiPass.mustache` - PSR-12 header, clean docblock

### Key Improvements

1. **PSR-12 Compliance**: All files have `declare(strict_types=1)`
2. **Clean Docblocks**: Removed verbose outdated headers
3. **PHPStan Types**: Added `array<string, mixed>` annotations
4. **Sorted Imports**: Alphabetically sorted per PSR-12