---
code: GENDE-001
status: Proposed
dateCreated: 2025-12-28T19:03:00.758Z
type: Architecture
priority: Medium
phaseEpic: Phase A - Foundation
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

**What We Have**:
- ✅ OpenAPI specifications for testing
- ✅ Reference implementation (`laravel-max/`) showing ideal output
- ✅ Experience with OpenAPI Generator template customization (php-laravel, php-lumen)
- ✅ Understanding of project goals (see `GOAL.md`, `GOAL_MAX.md`)

**What We Don't Have**:
- ❌ Custom generator implementation (only customized templates)
- ❌ Understanding of generator creation/customization process
- ❌ Knowledge of generator limitations and capabilities
- ❌ Framework-agnostic template abstractions

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

**Critical Technical Uncertainties** (require investigation before architecture):

1. **Generator Creation & Customization**:
   - How to create a custom generator in OpenAPI Generator ecosystem?
   - What's the generator lifecycle and extension points?
   - What are generator limitations vs. template limitations?
   - Can generators be distributed separately from core OpenAPI Generator?

2. **Template Engine Capabilities**:
   - What can Mustache template engine do/not do?
   - How to implement complex logic (conditionals, loops, transformations)?
   - How to share template partials across frameworks?
   - What are workarounds for Mustache limitations?

3. **Framework-Specific Abstractions**:
   - How to make templates reusable across Laravel, Symfony, Express?
   - Where to draw the line between generator logic and template logic?
   - How to handle framework-specific conventions (routing, DI, validation)?

**Recommendation**: Run `/mdt:poc GENDE-001` to validate uncertainties #1 and #2 before architecture.

**✅ PoC COMPLETE** - See `tickets/GENDE-001/poc/PHASE_2_STATUS.md` for findings

## 4. Requirements

**Based on PoC validation (Phase 2), the following requirements are established:**

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

- [ ] **AC-1**: Developer can create a custom OpenAPI Generator implementation
- [ ] **AC-2**: Generator produces code that enforces API contracts (type safety, validation)
- [ ] **AC-3**: Template system supports multiple frameworks (Laravel, Symfony, Express)
- [ ] **AC-4**: Generated code matches `laravel-max/` quality benchmark
- [ ] **AC-5**: Template authoring is documented with examples
- [ ] **AC-6**: No modifications to official OpenAPI Generator library required
- [ ] **AC-7**: Other developers can create templates using provided documentation

## 5. Verification

### Verification Strategy

**Phase 1: PoC Validation** (before architecture):
- Hands-on experimentation with generator creation
- Document findings in `tickets/GENDE-001/poc.md`
- Answer open questions #1 and #2

**Phase 2: Architecture Review**:
- Architecture design reviewed against `laravel-max/` reference
- Template system design reviewed for maintainability
- Multi-framework support validated

**Phase 3: Implementation Verification**:
- Generate code from sample OpenAPI spec
- Compare output quality to `laravel-max/` benchmark
- Verify contract enforcement (breaking changes cause errors)
- Validate template authoring experience with test template

**Phase 4: Documentation Review**:
- Template authoring guide is clear and complete
- Examples demonstrate all key capabilities
- Other developers can follow guide successfully

### Success Metrics

**Quality Metrics**:
- Generated code passes same quality standards as `laravel-max/`
- Contract violations cause compile-time or runtime errors (not silent failures)
- Template complexity score ≤ reasonable threshold (TBD in architecture)

**Usability Metrics**:
- Template author can create basic template in ≤ 1 day (with docs)
- Documentation clarity validated by peer review