---
code: GENDE-020
status: Proposed
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

### Current State
- No PHPStan configuration in projects
- No automated naming convention checks
- Manual review only catches obvious issues

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