---
code: GENDE-011
status: In Progress
dateCreated: 2026-01-01T14:00:30.279Z
type: Architecture
priority: Medium
relatedTickets: GENDE-008
dependsOn: GENDE-001,GENDE-009
---

# Create php-max Combined Generator for Multiple PHP Frameworks

## 1. Description

### Problem Statement

Currently, each PHP framework requires its own custom Java generator:
- `laravel-max` for Laravel
- `symfony-max` for Symfony (future)

This leads to code duplication and maintenance burden. A unified `php-max` generator could share common logic while supporting multiple frameworks.

### Goal

Create a combined `php-max` generator that:
1. Shares common PHP code generation logic
2. Supports multiple frameworks via configuration or sub-generators
3. Reduces maintenance burden
4. Maintains framework-native code quality

### Scope

- Refactor common code from laravel-max
- Design framework selection mechanism
- Support Laravel and Symfony (initially)
- Maintain GOAL_MAX.md compliance for all frameworks

## 2. Rationale

- **DRY principle** - Common PHP patterns (DTOs, typed properties, enums) shouldn't be duplicated
- **Maintainability** - One codebase easier to maintain than N separate generators
- **Consistency** - Shared patterns ensure consistent quality across frameworks
- **Extensibility** - Adding new PHP frameworks becomes easier

## 3. Solution Analysis
### Potential Architectures

**Option A: Single Generator with Framework Flag**
```bash
openapi-generator generate -g php-max --additional-properties=framework=laravel
openapi-generator generate -g php-max --additional-properties=framework=symfony
```
- Pros: Single JAR, simple CLI
- Cons: Complex conditional logic in templates

**Option B: Base Class + Framework Generators** ✅ RECOMMENDED
```
AbstractPhpMaxCodegen (shared logic)
  ├── LaravelMaxCodegen
  └── SymfonyMaxCodegen
```
- Pros: Clean separation, framework-specific customization
- Cons: Multiple JARs, more complex build

**Option C: Template Sets with Shared Partials**
```
php-max/
  ├── common/           # Shared partials (DTOs, enums)
  ├── laravel/          # Laravel-specific templates
  └── symfony/          # Symfony-specific templates
```
- Pros: Template-level reuse, single generator
- Cons: Limited code sharing in Java layer

### Recommended Approach

**Option B (Base Class + Framework Generators)** is recommended.

### Detailed Code Analysis (LaravelMaxGenerator.java - 1961 lines)

Analysis performed on 2026-01-02. Generator located at:
`openapi-generator-generators/laravel-max/src/main/java/org/openapitools/codegen/laravelmax/LaravelMaxGenerator.java`

#### Shared Components (AbstractPhpMaxCodegen)

**1. Enum Handling (~50 lines)**
- `toEnumCaseName()` - Convert enum values to valid PHP case names
- Enum detection in `postProcessAllModels()` - Sets `x-is-php-enum`, `x-enum-cases`
- Store enum models for validation: `enumModels` map

**2. PHP Type Mapping (~80 lines)**
- `getPhpType(CodegenParameter)` - Convert to PHP types with nullability
- Array type fixes: `Type[]` → `array`, `array<T>` → `array`
- Nullable mixed handling: `?mixed` is invalid, special handling
- Variable sorting for PHP parameter ordering (required before optional)

**3. Default Value Formatting (~60 lines)**
- `formatDefaultValue(CodegenParameter)` - Format defaults for PHP
- `decodeHtmlEntities()` - Decode HTML entities from OpenAPI Generator

**4. Namespace Handling (~100 lines)**
- `setModelPackage()` override - Fix double namespace issues
- `setApiPackage()` override - Fix double namespace issues  
- `toModelImport()` - Convert to PHP namespace import
- Namespace prefix stripping in `processOpts()`

**5. Parameter & Character Processing (~40 lines)**
- `postProcessParameter()` - Fix array type hints
- `escapeUnsafeCharacters()` - Character escaping
- `escapeQuotationMark()` - Quote escaping
- `escapeReservedWord()` - Reserved word handling

**6. Security Scheme Extraction (~70 lines)**
- `extractSecuritySchemes()` - Parse OpenAPI securitySchemes
- Build scheme data maps for templates

**7. Configuration Pattern (~200 lines)**
- Configuration properties structure (dir, namespace, pattern per file type)
- `processOpts()` configuration reading pattern
- Final class flags pattern

**Estimated Shared Code: ~600 lines (30%)**

#### Framework-Specific Components (LaravelMaxCodegen)

**1. Laravel Validation Rules (~120 lines)**
- `getLaravelValidationRules()` - Convert OpenAPI constraints to Laravel rules
- Type rules: string, integer, numeric, boolean, array
- Format rules: email, uuid, url, date, ip
- Enum validation: `in:value1,value2,...`

**2. Laravel File Generation (~400 lines)**
- `writeResourceFiles()` - Laravel JsonResource pattern
- `writeControllerFiles()` - Laravel Controller pattern
- `writeFormRequestFiles()` - Laravel FormRequest pattern
- `writeErrorResourceFiles()` - Error response resources
- `writeRoutesFile()` - Laravel routes/api.php

**3. Laravel Security (~150 lines)**
- `writeSecurityInterfaceFiles()` - Security interfaces
- `writeMiddlewareStubFiles()` - Middleware stubs (commented out)
- `writeSecurityValidatorFile()` - Security validation

**4. Laravel-Specific Config (~200 lines)**
- Base classes: `JsonResource`, `FormRequest`
- Directory structure: `app/Http/Controllers`, etc.
- Namespace defaults: `{apiPackage}\Http\Controllers`

**5. Operation Processing (~300 lines)**
- `postProcessOperationsWithModels()` - Laravel-specific enrichment
- Controller task generation
- FormRequest task generation
- Query params DTO generation

**Estimated Framework-Specific Code: ~1170 lines (60%)**

#### Template Infrastructure (~190 lines - 10%)
- Task list management
- File writing helpers
- Constructor setup

### Shared vs Framework-Specific Summary

| Component | Lines | Shared | Laravel | Symfony (Projected) |
|-----------|-------|--------|---------|---------------------|
| Enum handling | ~50 | ✅ | | |
| PHP type mapping | ~80 | ✅ | | |
| Default value formatting | ~60 | ✅ | | |
| Namespace handling | ~100 | ✅ | | |
| Parameter processing | ~40 | ✅ | | |
| Security extraction | ~70 | ✅ | | |
| Config pattern | ~200 | ✅ | | |
| Validation rules | ~120 | | ✅ FormRequest | Symfony Validator |
| File generation | ~400 | | ✅ Resources | Serializer groups |
| Security files | ~150 | | ✅ Middleware | Firewall voters |
| Framework config | ~200 | | ✅ Laravel | Symfony |
| Operation processing | ~300 | | ✅ | |
| Template infra | ~190 | Partial | | |

**Total: ~1960 lines**
- Shared base: ~600 lines (30%)
- Framework-specific: ~1170 lines (60%)
- Template infrastructure: ~190 lines (10%)
## 4. Implementation Specification

### Prerequisites

1. ✅ GENDE-001: laravel-max implemented and proven
2. ⏸️ GENDE-009: symfony-max implemented (currently on hold)

### Implementation Steps

1. **Extract common base class** from laravel-max
   - PHP type mapping
   - DTO generation logic
   - Enum handling
   - File naming conventions

2. **Refactor laravel-max** to extend base
   - Move Laravel-specific logic to subclass
   - Verify tests still pass

3. **Implement symfony-max** extending base
   - Apply learnings from GENDE-007 mapping
   - Reuse shared components

4. **Package and distribute**
   - Consider: single JAR with all generators vs separate JARs
   - Update build scripts

### Deliverables

| Artifact | Location |
|----------|----------|
| Base generator | `openapi-generator-generators/php-max-base/` |
| Laravel generator | `openapi-generator-generators/laravel-max/` (refactored) |
| Symfony generator | `openapi-generator-generators/symfony-max/` |
| Combined JAR | `openapi-generator-generators/php-max.jar` |

## 5. Acceptance Criteria

- [ ] Common PHP generation logic extracted to base class
- [ ] laravel-max refactored to extend base (tests passing)
- [ ] symfony-max implemented extending base (GOAL_MAX.md compliant)
- [ ] Both frameworks generate from same OpenAPI spec
- [ ] Code duplication between generators < 20%
- [ ] Documentation updated for combined usage

## 6. Current State
**Last Updated:** 2026-01-03
**Status:** In Progress - Laravel & Symfony Templates Complete

### Template Structure

```
openapi-generator-server-templates/
├── openapi-generator-server-php-max-default/    ← Complete Laravel (DEFAULT)
├── openapi-generator-server-php-max-symfony/    ← Complete Symfony variant
└── openapi-generator-server-php-max-prototype/  ← Experimental multi-framework
```

### Artifact Locations

| Artifact | Path |
|----------|------|
| Generator JAR | `openapi-generator-generators/php-max/target/php-max-openapi-generator-1.0.0.jar` |
| Default Templates (Laravel) | `openapi-generator-server-templates/openapi-generator-server-php-max-default/` |
| Symfony Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-symfony/` |
| Prototype Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/` |
| Laravel Integration Tests | `projects/laravel-api--laravel-max--integration-tests/` |
| Symfony Integration Tests | `projects/symfony-api--symfony-max--integration-tests/` |

### Template Sets

#### ✅ Default (Laravel) - `php-max-default/`
Complete Laravel template set with files.json configuration:
- `model.mustache` - DTOs and PHP 8.1+ enums
- `api.mustache` - Handler interfaces (per tag)
- `controller.mustache` - Laravel controllers (per operation)
- `formrequest.mustache` - Form Requests with validation rules
- `routes.mustache` - Laravel route definitions
- `provider.mustache` - Service Provider for DI
- `composer.json.mustache` - Package configuration
- `files.json` - Template output configuration

#### ✅ Symfony - `php-max-symfony/`
Complete Symfony template set with files.json configuration:
- `model.mustache` - DTOs with `#[Assert\*]` validation attributes
- `api.mustache` - Service interfaces (per tag)
- `controller.mustache` - Symfony controllers (per operation, injecting per-tag interfaces)
- `routes.yaml.mustache` - Symfony routing
- `services.yaml.mustache` - DI configuration
- `composer.json.mustache` - Package configuration
- `files.json` - Template output configuration

### Architecture

php-max uses a consistent architecture across all frameworks:
- **Per-operation controllers** - One controller class per API operation
- **Per-tag service interfaces** - One interface per API tag containing all operations for that tag
- Controllers inject the appropriate tag's service interface

### Test Results

| Project | Tests | Assertions | Status |
|---------|-------|------------|--------|
| Laravel Integration | 69 | 101 | ✅ PASS |
| Symfony Integration | 34 | 88 | ✅ PASS |

### Recent Fixes (2026-01-03)

1. **Added files.json to Symfony templates** - Enables per-operation controller generation
2. **Fixed controller.mustache** - Now correctly imports per-tag service interfaces (`{{operation.baseName}}ApiServiceInterface`)
3. **Updated tests** - Tests now expect per-tag interfaces and snake_case property names

### Usage

```bash
## Laravel (default)
openapi-generator generate -g php-max \
  -i spec.yaml \
  -o ./generated/my-api \
  -t path/to/openapi-generator-server-php-max-default \
  --additional-properties=invokerPackage=MyApi

## Symfony
openapi-generator generate -g php-max \
  -i spec.yaml \
  -o ./generated/my-api \
  -t path/to/openapi-generator-server-php-max-symfony \
  --additional-properties=invokerPackage=MyApi
```

### Acceptance Criteria Status

- [x] Generator supports multiple frameworks via templates
- [x] Default templates = complete Laravel set
- [x] Symfony templates complete and tested
- [x] files.json configuration for both template sets
- [x] Integration tests passing for both frameworks
- [ ] Additional frameworks (Slim, Laminas, CodeIgniter) - prototype only

### Next Actions

1. **Complete Slim templates** - If needed, finish prototype templates
2. **Documentation** - Add README to Symfony templates
3. **Property naming** - Consider adding camelCase option for model properties
# Laravel (default)
openapi-generator generate -g php-max \
  -i spec.yaml \
  -o ./generated/my-api \
  -t path/to/openapi-generator-server-php-max-default \
  --additional-properties=invokerPackage=MyApi

# Symfony
openapi-generator generate -g php-max \
  -i spec.yaml \
  -o ./generated/my-api \
  -t path/to/openapi-generator-server-php-max-symfony \
  --additional-properties=invokerPackage=MyApi
```

### Acceptance Criteria Status

- [x] Generator supports multiple frameworks via templates
- [x] Default templates = complete Laravel set
- [x] Symfony templates complete and tested
- [x] Comprehensive README documentation
- [x] Integration tests passing for both frameworks
- [ ] Additional frameworks (Slim, Laminas, CodeIgniter) - prototype only

### Next Actions

1. **Enum support** - Add `x-is-php-enum` detection or spec vendor extension support
2. **Slim templates** - Complete from prototype if needed
3. **Laminas templates** - Complete from prototype if needed
4. **CodeIgniter templates** - Complete from prototype if needed
# Laravel generation
openapi-generator generate -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-laravel \
  -i spec.yaml \
  -o output/ \
  --additional-properties=invokerPackage=MyApi
```

### Generated Output (from tictactoe.json)

- 24 Model files (DTOs, Enums)
- 4 Handler interface files
- 10 Controller files (one per operation)
- 2 FormRequest files (conditional on hasBodyParam)
- 1 routes/api.php
- 1 ApiServiceProvider.php
- 1 composer.json

### Generator Features

- ✅ Per-model file generation
- ✅ Per-tag/api file generation
- ✅ Per-operation file generation
- ✅ Supporting files generation
- ✅ files.json configuration from template directory
- ✅ Configurable output folder/suffix per template
- ✅ Conditional generation (hasBodyParam, hasQueryParams, etc.)
- ✅ Security scheme extraction
- ✅ PHP 8.1+ typed properties and enums

### Remaining Work

**Phase 2: Symfony Support (Future)**
- [ ] Create Symfony template set
- [ ] Test with TicTacToe spec

**Phase 3: Other Frameworks (Future)**
- [ ] Slim templates
- [ ] Laminas templates
- [ ] CodeIgniter templates

### Acceptance Criteria Status

- [x] Common PHP generation logic in framework-agnostic generator
- [x] Laravel templates generate complete library
- [ ] Symfony templates (future)
- [x] Code duplication minimized (templates control all framework specifics)
- [x] Documentation in template README.md
# Default templates
openapi-generator generate -g php-max -o output/

# Laravel templates  
openapi-generator generate -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-laravel \
  -o output/
```

### Artifact Locations
| Artifact | Path |
|----------|------|
| Generator | `openapi-generator-generators/php-max/` |
| Default Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-default/` |
| Laravel Templates | `openapi-generator-server-templates/openapi-generator-server-php-max-laravel/` |

### Build Status
- ✅ PhpMaxGenerator.java compiles (framework-agnostic)
- ✅ Default templates generate valid PHP
- ✅ Namespace imports correct (`\` separator)
- ✅ Model properties output correctly
- ✅ PHP 8.1 enums work
- ✅ Array types use `array` (not invalid `Type[][]`)

### Next Actions

1. **Complete Laravel templates** (GENDE-023)
   - Add FormRequest, Controller, Resource templates
   - Requires per-operation file generation support

2. **Create Symfony templates** (GENDE-023)

3. **Create Slim templates** (GENDE-023)

4. **Document template variables** - Already started in README.md
# Base generation (minimal)
openapi-generator generate -g php-max -o output/

# Laravel generation
openapi-generator generate -g php-max -t laravel-max -o output/

# Symfony generation
openapi-generator generate -g php-max -t symfony-max -o output/

# Slim generation  
openapi-generator generate -g php-max -t slim-max -o output/
```

### Next Actions

1. **Fix base templates** - namespace separator issue (`\` not `.`)
2. **Update framework templates** for new architecture
   - Remove any Java-dependent logic from templates
   - Ensure templates use raw constraint data
3. **Test all frameworks** - verify generation produces correct output
4. **Migrate existing projects** to use new generator

### Known Issues

1. Base model.mustache not outputting properties (vars) correctly
2. API template using `.` instead of `\` for namespace separator
3. Framework templates (laravel-max, symfony-max, slim-max) still reference old generator classes
# Same generator, different templates
openapi-generator generate -g php-max -t templates/laravel ...
openapi-generator generate -g php-max -t templates/symfony ...
openapi-generator generate -g php-max -t templates/slim ...
```

### Artifact Locations

| Artifact | Location |
|----------|----------|
| Stable Laravel generator | `openapi-generator-generators/laravel-max/` |
| Multi-framework generator | `openapi-generator-generators/php-max/` |
| Template prototypes | `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/` |
| GENDE-022 Analysis | `.../php-max-prototype/PROOF-OF-CONCEPT.md` |

### Completed Work

✅ **GENDE-022 Investigation complete** - 5 frameworks validated
- Laravel, Symfony, Slim, Laminas, CodeIgniter
- Prototype templates created for all 5
- Template variable mapping documented

✅ **php-max generator created** (from laravel-max)
- AbstractPhpMaxCodegen base class (~500 lines)
- LaravelMaxGenerator extending base
- Build and generation tested

✅ **Prototype templates created** (from GENDE-022)
```
php-max-prototype/
├── laravel/      (validation_rules, controller)
├── symfony/      (validation_attrs, controller)
├── slim/         (validation_respect, handler, routes)
├── laminas/      (input_filter, handler, routes)
└── codeigniter/  (validation_rules, controller, routes)
```

### Build Status

- ✅ php-max generator compiles
- ✅ Laravel generation works
- ⏳ Template sets incomplete (prototypes only)
- ⏳ Other frameworks not yet integrated

### Next Actions

**Phase 1: Complete Laravel Templates**
1. [ ] Migrate prototype templates to php-max generator
2. [ ] Complete full Laravel template set (FormRequest, Resource, etc.)
3. [ ] Test with TicTacToe spec

**Phase 2: Add Symfony Support**
4. [ ] Create SymfonyMaxGenerator (or pure template approach)
5. [ ] Complete Symfony template set
6. [ ] Test with TicTacToe spec

**Phase 3: Add Remaining Frameworks**
7. [ ] Add Slim support
8. [ ] Add Laminas support
9. [ ] Add CodeIgniter support

**Phase 4: Documentation**
10. [ ] Create template authoring guide
11. [ ] Update README with multi-framework usage

### Effort Estimate (from GENDE-022)

| Task | Days |
|------|------|
| Base generator refinement | 2-3 |
| Laravel templates (complete) | 3-4 |
| Symfony templates (complete) | 3-4 |
| Slim templates (complete) | 2-3 |
| Laminas templates (complete) | 3-4 |
| CodeIgniter templates (complete) | 2-3 |
| Testing & documentation | 3-4 |
| **Total** | **18-25** |