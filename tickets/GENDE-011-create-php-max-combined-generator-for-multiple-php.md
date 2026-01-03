---
code: GENDE-011
status: In Progress
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

### Completed

**Generator:**
- ✅ PhpMaxGenerator.java - framework-agnostic
- ✅ files.json configuration system
- ✅ Per-operation file generation
- ✅ Empty template = no file (GENDE-029)
- ✅ Security scheme extraction
- ✅ PHP 8.1+ enums support

**Laravel Templates (php-max-default):**
- ✅ model.mustache - DTOs and enums
- ✅ api.mustache - Handler interfaces (per tag)
- ✅ controller.mustache - Controllers (per operation)
- ✅ formrequest.mustache - Validation
- ✅ routes.mustache - Route definitions
- ✅ provider.mustache - Service Provider
- ✅ files.json configuration
- ✅ Integration tests: 69 tests, 101 assertions

**Symfony Templates (php-max-symfony):**
- ✅ model.mustache - DTOs with Assert attributes
- ✅ api.mustache - Service interfaces (per tag)
- ✅ controller.mustache - Controllers (per operation)
- ✅ routes.yaml.mustache - Routing
- ✅ services.yaml.mustache - DI config
- ✅ files.json configuration
- ✅ Integration tests: 34 tests, 88 assertions

**Slim Templates (php-max-slim):**
- ✅ model.mustache - DTOs with PHP 8.1+ enums
- ✅ api.mustache - Service interfaces (per tag)
- ✅ controller.mustache - PSR-15 handlers (per operation)
- ✅ routes.mustache - Slim route definitions
- ✅ dependencies.mustache - PHP-DI container config
- ✅ composer.json.mustache - Package dependencies
- ✅ files.json configuration
- ✅ All generated PHP files pass syntax validation
- [ ] Integration tests (TODO)

### In Progress

**Laminas Templates (php-max-laminas):**
- ⏳ Prototype exists in php-max-prototype/laminas/
- [ ] Complete template set
- [ ] Integration tests

**CodeIgniter Templates (php-max-codeigniter):**
- ⏳ Prototype exists in php-max-prototype/codeigniter/
- [ ] Complete template set
- [ ] Integration tests

## 5. Artifact Locations

| Artifact | Path |
|----------|------|
| Generator JAR | `openapi-generator-generators/php-max/target/php-max-openapi-generator-1.0.0.jar` |
| Laravel Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-default/` |
| Symfony Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-symfony/` |
| Slim Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-slim/` |
| Prototype Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/` |
| Template Variables Doc | `openapi-generator-server-templates/TEMPLATE-VARIABLES.md` |
| Laravel Tests | `projects/laravel-api--laravel-max--integration-tests/` |
| Symfony Tests | `projects/symfony-api--symfony-max--integration-tests/` |

## 6. Acceptance Criteria

- [x] Framework-agnostic generator in Java
- [x] Laravel templates complete and tested
- [x] Symfony templates complete and tested
- [x] Slim templates complete (integration tests TODO)
- [ ] Laminas templates complete and tested
- [ ] CodeIgniter templates complete and tested
- [x] Template variable documentation (TEMPLATE-VARIABLES.md)

## 7. Next Actions

1. ~~**Complete Slim templates** - Start from prototype, add full template set~~ ✅ Done
2. **Create Slim integration tests** - Validate generated code with PHPUnit
3. **Complete Laminas templates** - Start from prototype
4. **Complete CodeIgniter templates** - Start from prototype
5. ~~**Document template variables** - List all available vars for template authors~~ ✅ Done (TEMPLATE-VARIABLES.md)
