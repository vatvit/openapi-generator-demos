---
code: GENDE-020
status: Implemented
dateCreated: 2026-01-01T16:23:54.192Z
type: Technical Debt
priority: Medium
---

# GENDE-020: Add PHPStan to All Projects for Static Analysis and Naming Convention Enforcement

> ⚠️ **STATUS: NEEDS CLARIFICATION** - PHPStan level and additional rules need confirmation.

## 1. Description

### Problem Statement
Generated code and integration projects lack static analysis tooling. This allows issues to slip through:
- **Naming convention violations**: `snake_case` used instead of `camelCase`
- Type errors not caught until runtime
- Potential bugs in generated code
- Inconsistent code style

### Specific Issue: snake_case vs camelCase
The generator or templates may produce variable/method names in `snake_case` when PHP/Laravel convention expects `camelCase`. Without automated checks, these violations go unnoticed.

### Implementation Details
**Completed: 2026-01-01**

PHPStan (Level 6) and PHP_CodeSniffer (PSR-12) have been successfully added to the `laravel-api--laravel-max--integration-tests` project.

### Configuration

**PHPStan (Level 6 with Larastan):**
- `phpstan.neon` - Analyzes `app/`, `tests/`, and `../../generated/laravel-max/tictactoe/app/`
- Uses Larastan extension for Laravel-specific analysis
- Excludes petshop (has incorrect namespace)

**PHP_CodeSniffer (PSR-12):**
- `phpcs.xml` - PSR-12 standard with test method naming exception
- Line length limit increased to 180 chars for auto-generated code
- Uses PHPCBF for auto-fixing

### Dependencies Added

```json
"require-dev": {
    "phpstan/phpstan": "^2.0",
    "larastan/larastan": "^3.0",
    "squizlabs/php_codesniffer": "^3.11"
}
```

### Make Commands

- `make phpstan` - Run PHPStan analysis
- `make phpcs` - Run PHP_CodeSniffer
- `make phpcbf` - Auto-fix PHPCS violations
- `make analyse` - Run both PHPStan and PHPCS
- `make lint` - Alias for analyse

### Template Fixes Made

To achieve 0 PHPStan errors and 0 PHPCS violations, the following mustache templates were updated:

1. **model.mustache**: Added `@var` and `@param` annotations for array types, fixed nullsafe operator usage
2. **resource.mustache**: Fixed `withResponse()` parameter type (`JsonResponse` instead of `Response`)
3. **error-resource.mustache**: Fixed `withResponse()` type, changed `new static()` to `new self()`, conditional `@param` for optional code
4. **All templates**: Fixed PSR-12 file header order (`<?php`, blank line, `declare(strict_types=1);`, blank line, namespace)

### Test Results

- **PHPStan**: 0 errors at Level 6
- **PHPCS**: 0 errors, 0 warnings
- **PHPUnit**: 52 tests, 80 assertions - all passing

### Files Modified

**Integration Tests Project:**
- `composer.json` - Added dev dependencies
- `phpstan.neon` - PHPStan configuration
- `phpcs.xml` - PHPCS configuration  
- `Makefile` - Added analyse commands

**Handler Implementations:**
- `app/Handlers/GameplayHandler.php` - Fixed array type annotations
- `app/Handlers/StatisticsHandler.php` - Fixed array type annotations
- `app/Handlers/GameManagementHandler.php` - Fixed header type casting

**Test Files:**
- `tests/Feature/Tictactoe/CreateGameControllerTest.php` - Added ReflectionNamedType assertions
- `tests/Feature/Tictactoe/CreateGameFormRequestTest.php` - Fixed redundant array assertions
- `tests/Feature/Tictactoe/PutSquareFormRequestTest.php` - Fixed redundant array assertions

**Generator Templates (laravel-max):**
- `model.mustache` - Array type annotations, PSR-12 header
- `resource.mustache` - withResponse type, PSR-12 header
- `error-resource.mustache` - withResponse type, new self(), PSR-12 header
- `resource-collection.mustache` - PSR-12 header
- `controller.mustache` - PSR-12 header
- `form-request.mustache` - PSR-12 header
- `api-interface.mustache` - PSR-12 header
- `security-validator.mustache` - PSR-12 header
- `security-interface.mustache` - PSR-12 header
- `middleware-stub.mustache` - PSR-12 header
- `routes.mustache` - PSR-12 header
- `query-params.mustache` - PSR-12 header
### Desired State
- PHPStan configured in all PHP projects
- CI/CD fails on naming convention violations
- Consistent camelCase for variables, methods, parameters
- Type safety verified at static analysis time

## 2. Rationale

- **Early Detection**: Catch issues before runtime
- **Convention Enforcement**: Automated naming checks
- **Code Quality**: PHPStan finds bugs, type issues, dead code
- **Laravel Standards**: Laravel uses camelCase consistently
- **Generator Validation**: Ensures templates produce correct output

## 3. Solution Analysis

### Questions to Clarify

1. **PHPStan Level**: Start with level 5? Or go higher (6-9)?
2. **Naming Rules**: Use phpstan-strict-rules? Or custom rules?
3. **Baseline**: Create baseline for existing violations or fix all first?
4. **CI Integration**: Add to GitHub Actions? Or local only initially?
5. **Additional Tools**: Also add PHP_CodeSniffer for PSR-12?

### Projects to Configure

| Project | Location | Priority |
|---------|----------|----------|
| laravel-max library | `examples/laravel-max/` | High |
| Integration project | `projects/laravel-api--example--laravel-max/` | High |
| php-laravel generated | `generated/php-laravel/` | Medium |
| php-lumen generated | `generated/php-lumen/` | Medium |

### PHPStan Configuration Options

**Level Selection:**
- Level 0-4: Basic checks
- Level 5: Missing typehints detected (recommended start)
- Level 6-8: Stricter type checks
- Level 9: Maximum strictness

**Naming Convention Enforcement Options:**

1. **phpstan-strict-rules** - General strict rules
2. **Custom PHPStan rules** - Write rule for naming
3. **PHP_CodeSniffer + PSR-12** - Complementary tool
4. **Slevomat Coding Standard** - Includes naming rules

### Recommended Tools Stack

```json
{
  "require-dev": {
    "phpstan/phpstan": "^1.10",
    "phpstan/phpstan-strict-rules": "^1.5",
    "nunomaduro/larastan": "^2.0",
    "slevomat/coding-standard": "^8.0"
  }
}
```

**Larastan** - PHPStan wrapper for Laravel with Laravel-specific rules.

## 4. Implementation Specification

### Phase 1: Setup PHPStan in laravel-max

1. [ ] Add PHPStan + Larastan to `composer.json`
2. [ ] Create `phpstan.neon` configuration:
   ```neon
   includes:
     - vendor/nunomaduro/larastan/extension.neon
   
   parameters:
     level: 5
     paths:
       - app
       - src
     excludePaths:
       - vendor
   ```
3. [ ] Run initial analysis, document violations
4. [ ] Create baseline or fix issues
5. [ ] Add `make phpstan` command

### Phase 2: Add Naming Convention Rules

1. [ ] Evaluate options:
   - Slevomat `SlevomatCodingStandard.NamingConventions.*`
   - Custom PHPStan rule
   - PHP_CodeSniffer sniff
2. [ ] Configure chosen solution
3. [ ] Test against known snake_case violations
4. [ ] Document expected naming patterns

### Phase 3: Apply to All Projects

1. [ ] Copy configuration to other projects
2. [ ] Adjust paths per project
3. [ ] Run and fix/baseline violations
4. [ ] Update Makefiles with phpstan commands

### Phase 4: Generator Integration

1. [ ] Run PHPStan as part of generation validation
2. [ ] Fail generation if PHPStan errors (optional)
3. [ ] Update `make test-complete` to include PHPStan

### Phase 5: CI/CD (Future)

1. [ ] Add PHPStan to GitHub Actions workflow
2. [ ] Fail PR on violations
3. [ ] Report annotations on changed files

## 5. Acceptance Criteria

- [ ] PHPStan configured in `examples/laravel-max/`
- [ ] PHPStan configured in integration project
- [ ] Naming convention rule catches `snake_case` violations
- [ ] `make phpstan` command available in all projects
- [ ] All projects pass PHPStan at configured level (or baseline created)
- [ ] Documentation updated with PHPStan usage
- [ ] Generator output validated with PHPStan