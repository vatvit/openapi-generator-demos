---
code: GENDE-011
status: Implemented
dateCreated: 2026-01-01T14:00:30.279Z
type: Architecture
priority: Medium
relatedTickets: GENDE-008,GENDE-029
---

# Create php-max Combined Generator for Multiple PHP Frameworks

## 1. Description

### Problem Statement

Each PHP framework has different patterns for controllers, validation, routing, etc. Rather than creating separate Java generators for each framework, we need a single `php-max` generator that supports multiple frameworks via templates.

### Goal

Create a combined `php-max` generator that:
1. Shares common PHP code generation logic in Java
2. Supports multiple frameworks via external template sets
3. Validates template flexibility across 5+ frameworks
4. Maintains GOAL_MAX.md compliance for all frameworks

### Target Frameworks

| Framework | Priority | Status |
|-----------|----------|--------|
| Laravel | High | ✅ Complete |
| Symfony | High | ✅ Complete |
| Slim | Medium | ✅ Complete |
| Laminas | Medium | ⏳ Prototype |
| CodeIgniter | Low | ⏳ Prototype |

## 2. Rationale

- **DRY principle** - Common PHP patterns shared in Java generator
- **Template flexibility** - Framework differences handled in templates
- **Validation** - Multiple frameworks prove template vars are sufficient
- **Extensibility** - Adding new PHP frameworks = just new templates

## 3. Architecture

### Generator Design

```
PhpMaxGenerator.java (framework-agnostic)
    ↓
Template Sets (framework-specific)
    ├── php-max-default/     (Laravel) ✅
    ├── php-max-symfony/     (Symfony) ✅
    ├── php-max-slim/        (Slim) ✅
    ├── php-max-laminas/     (Laminas) - TODO
    └── php-max-codeigniter/ (CodeIgniter) - TODO
```

### Generation Pattern

All frameworks use consistent architecture:
- **Per-operation controllers** - One controller class per API operation
- **Per-tag service interfaces** - One interface per API tag
- **Controllers inject tag interfaces** - DI wiring handled by framework

### Usage

```bash
# Laravel (default templates)
openapi-generator generate -g php-max \
  -i spec.yaml -o ./output \
  -t path/to/php-max-default

# Symfony
openapi-generator generate -g php-max \
  -i spec.yaml -o ./output \
  -t path/to/php-max-symfony

# Slim (future)
openapi-generator generate -g php-max \
  -i spec.yaml -o ./output \
  -t path/to/php-max-slim
```

## 4. Implementation Status
### ✅ COMPLETE - Core Architecture Validated

The php-max generator architecture has been validated with 3 major PHP frameworks, proving that a single Java generator can support multiple frameworks via external template sets.

**Generator (PhpMaxGenerator.java):**
- ✅ Framework-agnostic code generation
- ✅ files.json configuration system for template control
- ✅ Per-operation file generation (controllers, handlers, requests)
- ✅ Per-tag file generation (API interfaces)
- ✅ Empty template = skip file generation
- ✅ Security scheme extraction
- ✅ PHP 8.1+ enums with SCREAMING_SNAKE_CASE
- ✅ Constructor parameter ordering (required before optional)
- ✅ PSR-4 compliant class/file naming

**Laravel Templates (laravel-max):**
- ✅ Full template set (models, controllers, handlers, requests, resources, routes)
- ✅ Integration tests: **92 tests, 157 assertions**

**Symfony Templates (symfony-max):**
- ✅ Full template set (models, controllers, handlers, API interfaces)
- ✅ Symfony Assert validation attributes
- ✅ Final controller classes
- ✅ Integration tests: **61 tests, 126 assertions**

**Slim Templates (slim-max):**
- ✅ Full template set (models, handlers, API interfaces)
- ✅ PSR-15 compatible handlers
- ✅ Integration tests: **13 tests, 22 assertions**

### Deferred (Low Priority)

**Laminas & CodeIgniter:**
- Prototypes exist in `openapi-generator-server-php-max-prototype/`
- Not needed for MVP - can be added later if requested
- Architecture is proven, adding new frameworks = create new template set

### Total Test Coverage
- **166 tests, 305 assertions** across 3 frameworks
- All tests passing with no deprecation warnings
## 5. Artifact Locations
| Artifact | Path |
|----------|------|
| Generator Source | `openapi-generator-generators/php-max/src/main/java/` |
| Generator JAR | `openapi-generator-generators/php-max/target/php-max-openapi-generator-1.0.0.jar` |
| Laravel Templates | `openapi-generator-generators/php-max/src/main/resources/laravel-max/` |
| Symfony Templates | `openapi-generator-generators/php-max/src/main/resources/symfony-max/` |
| Slim Templates | `openapi-generator-generators/php-max/src/main/resources/slim-max/` |
| Prototype Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/` |
| Template Variables Doc | `openapi-generator-server-templates/TEMPLATE-VARIABLES.md` |
| Laravel Generated | `generated/php-max-laravel/` |
| Symfony Generated | `generated/php-max-symfony/` |
| Slim Generated | `generated/php-max-slim/` |
| Laravel Tests | `projects/laravel-api--laravel-max--integration-tests/` |
| Symfony Tests | `projects/symfony-api--symfony-max--integration-tests/` |
| Slim Tests | `projects/slim-api--slim-max--integration-tests/` |
## 6. Acceptance Criteria
**Core Objectives (COMPLETE):**
- [x] Framework-agnostic generator in Java (`PhpMaxGenerator.java`)
- [x] Laravel templates complete and tested (92 tests, 157 assertions)
- [x] Symfony templates complete and tested (61 tests, 126 assertions)
- [x] Slim templates complete and tested (13 tests, 22 assertions)
- [x] Template variable documentation (TEMPLATE-VARIABLES.md)
- [x] Per-operation file generation pattern working across all 3 frameworks
- [x] files.json configuration system for template customization

**Deferred (Low Priority):**
- [ ] Laminas templates complete and tested
- [ ] CodeIgniter templates complete and tested

**Summary:** Core architecture validated with 166 tests across 3 major PHP frameworks.
## 7. Next Actions
**Completed:**
1. ~~Complete Laravel templates~~ ✅ 92 tests passing
2. ~~Complete Symfony templates~~ ✅ 61 tests passing
3. ~~Complete Slim templates~~ ✅ 13 tests passing
4. ~~Create integration tests for all 3 frameworks~~ ✅ 166 total tests
5. ~~Document template variables~~ ✅ TEMPLATE-VARIABLES.md

**Future Work (Low Priority):**
1. **Laminas templates** - Start from prototype when needed
2. **CodeIgniter templates** - Start from prototype when needed
3. **Performance optimization** - Consider caching strategies for production

**Status:** Core architecture complete and production-ready. Laminas/CodeIgniter deferred due to low market demand.