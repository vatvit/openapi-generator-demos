---
code: GENDE-069
status: Implemented
dateCreated: 2026-01-07T10:32:05.034Z
type: Technical Debt
priority: Low
---

# Fix PHPStan level 6 warnings in php-max generated code

## 1. Description

PHPStan analysis at level 6 reports 10 minor warnings in the php-max generated code and integration tests. These are type hint improvements, not functional issues.

**Current State:**
- All 92 integration tests pass
- Generated code is valid PHP 8.1+
- PHPStan reports warnings about missing array type specifications

**Desired State:**
- PHPStan level 6 passes with 0 errors
- All array parameters have proper type hints (`array<string>` instead of `array`)

## 2. Rationale

- Improves code quality and IDE autocompletion
- Makes generated code more maintainable
- Follows PHP static analysis best practices
- Low priority since code is functionally correct

## 3. Solution Analysis

### Warnings to Fix

| Location | Issue | Fix |
|----------|-------|-----|
| Handler interfaces | `$tags` param missing array type | Add `@param array<string> $tags` |
| FindPetsQueryParams | `$tags` constructor param | Add typed array annotation |
| Test files | `ReflectionType::getName()` | Use `instanceof ReflectionNamedType` check |
| Test assertion | Already narrowed type | Remove redundant assertion |

### Approach

**Option A: Fix in templates** (Recommended)
- Update mustache templates to generate proper PHPDoc annotations
- Regenerate code
- One-time fix that applies to all future generations

**Option B: Fix in generated code**
- Manual fixes in generated files
- Would be overwritten on next generation
- Not recommended

## 4. Implementation Specification

### Template Changes

1. Update `api-interface.mustache` to include array type hints:
   ```php
   /** @param array<string> ${{paramName}} */
   ```

2. Update `query-params.mustache` for typed array properties

3. Fix test files manually (not generated)

### Files to Modify

- `src/main/resources/php-max/api-interface.mustache`
- `src/main/resources/php-max/query-params.mustache`
- `tests/Feature/Petshop/FindPetByIdControllerTest.php`
- `tests/Feature/Petshop/PetModelTest.php`

## 5. Acceptance Criteria

- [ ] PHPStan level 6 reports 0 errors
- [ ] All 92 integration tests still pass
- [ ] Generated code has proper array type annotations
- [ ] Test code handles ReflectionType correctly