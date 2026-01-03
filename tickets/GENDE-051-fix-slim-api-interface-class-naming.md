---
code: GENDE-051
status: Proposed
dateCreated: 2026-01-04T18:00:00.000Z
type: Bug Fix
priority: Medium
relatedTickets: GENDE-043,GENDE-044,GENDE-050
---

# Fix Slim API interface class naming for PSR-4 compliance

## 1. Description

The Slim api.mustache template generates interface classes with names that don't match the file names, violating PSR-4 autoloading standards.

**Example:**
- File: `PetsApi.php`
- Class inside: `PetsApiInterface`

This causes composer autoload warnings:
```
Class PetshopApi\Api\PetsApiInterface located in .../PetsApi.php does not comply with psr-4 autoloading standard
```

## 2. Rationale

The `api.mustache` template uses `{{classname}}Interface` for the interface name, but the file is named `{{classname}}.php` (without the Interface suffix).

## 3. Solution Analysis

**Options:**
1. Change class name to match file: Use `{{classname}}` instead of `{{classname}}Interface`
2. Change file naming: Update generator to output `{{classname}}Interface.php`
3. Separate interface template: Create dedicated interface template with proper naming

**Recommended:** Option 2 - Change file naming to match class name

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/slim-max/api.mustache`
- **Affected files:** All `generated/php-max-slim/*/lib/Api/*.php`

## 5. Acceptance Criteria

- [ ] Class names match file names per PSR-4 standard
- [ ] No composer autoload warnings
- [ ] All tests pass
