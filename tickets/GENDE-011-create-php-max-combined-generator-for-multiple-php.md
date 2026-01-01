---
code: GENDE-011
status: Proposed
dateCreated: 2026-01-01T14:00:30.279Z
type: Architecture
priority: Low
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

**Option B: Base Class + Framework Generators**
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

**Option B (Base Class + Framework Generators)** is recommended:
- Maximum flexibility for framework-specific patterns
- Clean inheritance model
- Each framework can evolve independently
- Shared base handles: PHP types, DTOs, enums, common options

### Shared vs Framework-Specific

| Component | Shared (php-max-base) | Framework-Specific |
|-----------|----------------------|--------------------|
| PHP type mapping | ✅ | |
| DTO generation | ✅ | |
| Enum generation | ✅ | |
| DateTime handling | ✅ | |
| fromArray/toArray | ✅ | |
| Controllers | | ✅ Different patterns |
| Request validation | | ✅ FormRequest vs Validator |
| Response handling | | ✅ Resources vs Serializer |
| Routes | | ✅ PHP vs YAML |
| Security | | ✅ Middleware vs Firewall |
| DI configuration | | ✅ ServiceProvider vs services.yaml |

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

**Status:** Future (blocked by GENDE-009)

**Prerequisites:**
- ✅ GENDE-001: laravel-max complete
- ⏸️ GENDE-009: symfony-max on hold (per GENDE-008 decision)

**Next Steps:**
1. Wait for decision to proceed with Symfony support
2. If proceeding, implement symfony-max first (GENDE-009)
3. Then refactor to php-max combined architecture

**Note:** This ticket documents the long-term vision. Implementation depends on Symfony support decision (GENDE-008).