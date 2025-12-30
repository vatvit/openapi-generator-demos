---
code: GENDE-001
status: Implemented
dateCreated: 2025-12-28T19:03:00.758Z
type: Architecture
priority: Medium
phaseEpic: Phase A - Foundation
implementationDate: 2025-12-30
implementationNotes: |
  Full implementation completed across 8 phases.

  **Phase 1-7:** Generator scaffolding, template variables, controllers, resources, FormRequests, routes, API interfaces.

  **Phase 8:** Security middleware stubs, SecurityValidator, conditional middleware routes, query parameter DTOs, error resources, DateTime handling, ResourceCollection.

  **Test Results:** 18/18 tests passing (42 assertions)

  **Generated Output:** 21 models, 10 controllers, 33 resources, 2 FormRequests, 2 query DTOs, 5 security interfaces, 5 security middleware, 4 API interfaces.
---

# Custom OpenAPI Generator Implementation with Template-Based Framework Support

## 1. Description

### Problem Statement

Developers need to generate high-quality, contract-enforced API libraries from OpenAPI specifications for multiple frameworks (Laravel, Symfony, Node.js Express) with custom "best practices" vision. Current OpenAPI Generator templates are inflexible and don't match the desired code quality standards demonstrated in the `laravel-max/` reference implementation.

**Key Issues**:
- OpenAPI Generator's built-in templates (php-laravel, php-lumen) don't produce desired code patterns
- Template customization explored, but **generator-level customization** (not just templates) is unexplored
- Need to support multiple frameworks with different architectural patterns
- Must enforce API contracts through type safety, validation, and interfaces

### Affected Areas

- **Generator Engine**: Custom generator implementation extending OpenAPI Generator
- **Template System**: Flexible template architecture supporting multiple frameworks
- **Contract Enforcement**: Type safety, validation, and interface generation
- **Reference Implementation**: `generated-examples/laravel-max/` serves as quality benchmark

### Current State

**Last Updated:** 2025-12-30 (Session 3 - Complete)

#### Artifact Locations

| Artifact | Path |
|----------|------|
| Generator (Java) | `tickets/GENDE-001/poc/laravel-max-generator/` |
| Templates (Mustache) | `tickets/GENDE-001/poc/laravel-max-generator/src/main/resources/laravel-max/` |
| Generated Library | `tickets/GENDE-001/generated/tictactoe/` |
| Test Project | `tickets/GENDE-001/poc/test-integration/` |
| Generation Config | `tickets/GENDE-001/poc/generate-tictactoe-pom.xml` |
| Reference Implementation | `generated-examples/laravel-max/` |
| OpenAPI Spec | `openapi-generator-specs/tictactoe/tictactoe.json` |

#### Build Commands

```bash
# Rebuild generator JAR
docker run --rm -v /path/to/poc/laravel-max-generator:/workspace -w /workspace maven:3.9-eclipse-temurin-17 mvn clean package -DskipTests

# Regenerate tictactoe library
docker run --rm -v /path/to/tickets/GENDE-001:/workspace -w /workspace/poc maven:3.9-eclipse-temurin-17 mvn generate-sources -f generate-tictactoe-pom.xml

# Run tests
docker run --rm -v /path/to/tickets/GENDE-001:/workspace -w /workspace/poc/test-integration php:8.4-cli ./vendor/bin/phpunit
```

#### Build Status

- **Generator JAR:** ✅ Built (`target/laravel-max-openapi-generator-1.0.0.jar`)
- **Generated Library:** ✅ Generated (Dec 30, 2025)
- **Tests:** ✅ **18/18 passing** (42 assertions)

#### Completed Phases

- ✅ Phase 1: Generator scaffolding and basic setup
- ✅ Phase 2: Template variable population
- ✅ Phase 3: Controller generation (one per operation)
- ✅ Phase 4: Resource generation with HTTP status codes
- ✅ Phase 5: FormRequest validation generation
- ✅ Phase 6: Petshop extended API testing
- ✅ Phase 7: Namespace and route bug fixes
- ✅ **Phase 8: GOAL_MAX.md Feature Parity (COMPLETE)**

#### Gap Analysis vs GOAL_MAX.md

**✅ All Features Implemented:**

| Component | Status | Notes |
|-----------|--------|-------|
| Models/DTOs | ✅ | `fromArray()`, `toArray()`, typed properties, DateTime handling |
| Controllers | ✅ | One invokable controller per operation |
| FormRequests | ✅ | Validation rules from OpenAPI schema |
| Resources | ✅ | HTTP status codes hardcoded per response |
| ResourceCollection | ✅ | For array responses with pagination headers |
| API Interfaces | ✅ | Union return types for type-safe handlers |
| Routes | ✅ | Conditional middleware with `hasMiddlewareGroup()` |
| Security Interfaces | ✅ | One interface per security scheme (5 generated) |
| Security Middleware Stubs | ✅ | Example implementations with TODOs (5 generated) |
| SecurityValidator | ✅ | Validates middleware implements interfaces |
| Query Parameter DTOs | ✅ | Typed DTOs for GET operations |
| Error Resources | ✅ | Separate Resource per error code (7 generated) |
| DateTime Handling | ✅ | ISO8601 parsing/formatting in DTOs |

#### Files Generated Per Run

| Category | Count | Examples |
|----------|-------|----------|
| Controllers | 10 | `CreateGameController.php`, `ListGamesController.php` |
| Resources | 33 | `CreateGame201Resource.php`, `ListGames200Resource.php`, `BadRequestErrorResource.php` |
| FormRequests | 2 | `CreateGameFormRequest.php`, `PutSquareFormRequest.php` |
| Query Params DTOs | 2 | `ListGamesQueryParams.php`, `GetLeaderboardQueryParams.php` |
| Security Interfaces | 5 | `BearerHttpAuthenticationInterface.php` |
| Security Middleware | 5 | `AuthenticateBearerHttpAuthentication.php` |
| API Interfaces | 4 | `GameManagementApiApi.php` |
| Models | 21 | `Game.php`, `Move.php`, `Player.php`, enums |

### Scope

**In Scope**:
- Core generator engine architecture
- Template system design and organization
- Contract enforcement mechanisms (types, validation, interfaces)
- Multi-framework support foundation

**Out of Scope** (Deferred):
- Complete Laravel/Symfony/Express template implementations
- IDE integration or tooling
- Standalone CLI tool for end users
- Dedicated documentation website

## 2. Desired Outcome

### Success Conditions

The generator implementation is successful when:

1. **Custom Template Creation**: Developer can create and maintain custom templates with clear documentation
2. **API Contract Enforcement**: Generated code uses type safety, validation, and interfaces to prevent contract violations
3. **Multi-Framework Support**: Architecture supports Laravel, Symfony, and Express with framework-specific patterns
4. **Official OpenAPI Generator Compatible**: Works with official OpenAPI Generator library without forking/modification
5. **Template Maintainability**: Other developers can understand and write templates (low learning curve)
6. **Quality Benchmark**: Generated code matches or exceeds `laravel-max/` reference implementation quality

### Constraints

**Technical Constraints**:
- Must use official OpenAPI Generator library (no forks or core modifications)
- Template complexity must be manageable (not spaghetti code)
- Template authoring must have reasonable learning curve

**Project Constraints**:
- Focus on generator engine, not complete framework templates
- Align with project goals (`GOAL.md`, `GOAL_MAX.md`)
- Reference implementation (`laravel-max/`) is the quality standard

### Non-Goals

**Explicitly Out of Scope**:
- ❌ Complete framework template implementations (Phase B)
- ❌ IDE plugins or integrations (VS Code, PHPStorm)
- ❌ Standalone CLI tool for end-user distribution
- ❌ Dedicated documentation website (README sufficient for Phase A)

## 3. Open Questions

**Status: ✅ ALL RESOLVED** (via PoC Phases 1-8)

~~1. **Generator Creation & Customization**~~ → ANSWERED
   - Custom generator created via `openapi-generator-cli meta` command
   - Extends `AbstractPhpCodegen` for PHP type mapping
   - Distributed as standalone JAR file
   - See: `poc/laravel-max-generator/`

~~2. **Template Engine Capabilities**~~ → ANSWERED
   - Mustache templates support conditionals, loops, partials
   - Complex logic moved to Java generator code (not templates)
   - See: `poc/laravel-max-generator/src/main/resources/laravel-max/`

~~3. **Framework-Specific Abstractions**~~ → ANSWERED
   - Each framework gets its own generator extending language base class
   - Generator handles file structure, template handles code patterns
   - See: `poc/PHASE_2_COMPLETE.md`, `poc/PHASE_3_COMPLETE.md`

## 4. Requirements

**Based on PoC validation (Phases 1-8), the following requirements are established:**

### 4.1 Functional Requirements

**FR-1: Generator Creation**
- **FR-1.1**: The system SHALL support custom generator creation via OpenAPI Generator's `meta` command
- **FR-1.2**: The system SHALL build custom generators using Maven and Docker (no local Java/Maven required)
- **FR-1.3**: Custom generators SHALL extend appropriate language base classes (`AbstractPhpCodegen`, `AbstractTypeScriptCodegen`, etc.)
- **FR-1.4**: Custom generators SHALL be distributable as standalone JAR files

**FR-2: Template System**
- **FR-2.1**: The system SHALL support Mustache template engine for code generation
- **FR-2.2**: Templates SHALL be organized by framework (e.g., `laravel-max/`, `symfony-max/`, `express-max/`)
- **FR-2.3**: The system SHALL support at least 6 template types: models, controllers, resources, API interfaces, form requests, and routes
- **FR-2.4**: Templates SHALL support partial inclusion for code reuse (e.g., `{{>licenseInfo}}`)

**FR-3: File Generation Control**
- **FR-3.1**: The system SHALL generate one Resource file per operation+response combination (not per schema)
- **FR-3.2**: The system SHALL support customizable file output paths (Models/, Http/Controllers/, Http/Resources/)
- **FR-3.3**: The system SHALL generate invokable controllers (one class per operation)
- **FR-3.4**: The system SHALL generate API interface files with union return types

**FR-4: Multi-Framework Support**
- **FR-4.1**: The architecture SHALL support multiple target frameworks through separate generators
- **FR-4.2**: Each framework generator SHALL inherit from appropriate language base class
- **FR-4.3**: Generators SHALL NOT require modifications to OpenAPI Generator core library

**FR-5: Contract Enforcement**
- **FR-5.1**: Generated API interfaces SHALL use union return types for compile-time response type safety
- **FR-5.2**: Generated Resources SHALL hardcode HTTP status codes (compile-time, not runtime)
- **FR-5.3**: Generated Resources SHALL validate required headers at runtime
- **FR-5.4**: Generated routes SHALL include security middleware based on OpenAPI security schemes

### 4.2 Non-Functional Requirements

**NFR-1: Development Workflow**
- **NFR-1.1**: Generator build and test SHALL work entirely in Docker containers
- **NFR-1.2**: Build time SHALL be ≤ 2 minutes for clean builds
- **NFR-1.3**: Generation time SHALL be ≤ 10 seconds for typical API specs (10-20 endpoints)

**NFR-2: Code Quality**
- **NFR-2.1**: Generated code SHALL use strict typing (`declare(strict_types=1)` for PHP)
- **NFR-2.2**: Generated code SHALL include auto-generation warnings in file headers
- **NFR-2.3**: Generated code SHALL follow PSR-4 autoloading standards (PHP)
- **NFR-2.4**: Generated code quality SHALL match or exceed `laravel-max/` reference implementation

**NFR-3: Maintainability**
- **NFR-3.1**: Template syntax SHALL be readable and maintainable by developers with basic Mustache knowledge
- **NFR-3.2**: Generator Java code SHALL be well-documented with inline comments
- **NFR-3.3**: Template variables SHALL have clear, predictable naming conventions

**NFR-4: Compatibility**
- **NFR-4.1**: The system SHALL work with OpenAPI Generator version 7.10.0 (stable release)
- **NFR-4.2**: The system SHALL support OpenAPI 3.0 and 3.1 specifications
- **NFR-4.3**: Generated code SHALL be compatible with Laravel 10+, Symfony 6+, Node.js 18+ (respective frameworks)

### 4.3 Constraints

**CON-1: No OpenAPI Generator Modifications**
- The system SHALL NOT require forking or modifying OpenAPI Generator core library

**CON-2: Language Base Classes**
- PHP generators SHALL extend `AbstractPhpCodegen`
- TypeScript/JavaScript generators SHALL extend `AbstractTypeScriptCodegen` or `AbstractJavaScriptCodegen`
- Each language SHALL use its appropriate base class for type mapping

**CON-3: Template Engine**
- The system SHALL use Mustache template engine (OpenAPI Generator standard)
- Complex logic SHALL be implemented in Java generator code, not templates

### 4.4 Assumptions

**ASM-1**: Developers have Docker installed for build/test workflow
**ASM-2**: OpenAPI specifications are valid and well-formed
**ASM-3**: Reference implementation (`laravel-max/`) represents desired quality standard
**ASM-4**: Variable population issue identified in PoC is solvable through proper AbstractPhpCodegen integration

## 5. Acceptance Criteria

**Outcome-Focused Criteria** (measurable, testable):

- [x] **AC-1**: Developer can create a custom OpenAPI Generator implementation
  - ✅ `laravel-max` generator created, builds to JAR
- [x] **AC-2**: Generator produces code that enforces API contracts (type safety, validation)
  - ✅ FormRequests, typed DTOs, Resources with hardcoded HTTP codes
- [x] **AC-3**: Template system supports multiple frameworks (Laravel, Symfony, Express)
  - ✅ Laravel fully working, architecture supports others
- [x] **AC-4**: Generated code matches `laravel-max/` quality benchmark
  - ✅ All GOAL_MAX.md features implemented
- [ ] **AC-5**: Template authoring is documented with examples
  - ⏳ Documentation pending
- [x] **AC-6**: No modifications to official OpenAPI Generator library required
  - ✅ Uses official 7.10.0 JAR as dependency
- [ ] **AC-7**: Other developers can create templates using provided documentation
  - ⏳ Blocked by AC-5

## 6. Verification

### Phase Progress

| Phase | Status | Details |
|-------|--------|---------|
| Phase 1: PoC Validation | ✅ COMPLETE | Generator scaffolding working |
| Phase 2: Template Variables | ✅ COMPLETE | All variables populated |
| Phase 3: Controllers | ✅ COMPLETE | One controller per operation |
| Phase 4: Resources | ✅ COMPLETE | HTTP status codes hardcoded |
| Phase 5: FormRequests | ✅ COMPLETE | Validation from OpenAPI schema |
| Phase 6: Extended Testing | ✅ COMPLETE | Petshop API tested |
| Phase 7: Bug Fixes | ✅ COMPLETE | Namespace and route fixes |
| Phase 8: Feature Parity | ✅ COMPLETE | All GOAL_MAX.md features |

### Current Test Results

```
Location: poc/test-integration/tests/Feature/
Tests: 18 total
Passing: 18
Assertions: 42
Status: ✅ ALL PASSING
```

### Success Metrics

**Quality Metrics**:
- ✅ Generated code passes same quality standards as `laravel-max/`
- ✅ Contract violations cause compile-time or runtime errors (not silent failures)

**Usability Metrics**:
- Template author can create basic template in ≤ 1 day (with docs) - pending documentation
- Documentation clarity validated by peer review - pending
