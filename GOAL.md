# Project Goal

## Main Objective

**Create a PHP library generator** that produces **high-quality, contract-enforced API libraries** from OpenAPI specifications using OpenAPI Generator with custom templates.

**Current Target Framework:** Laravel

---

## The Problem

Developers need to implement APIs defined in OpenAPI specifications. Manual implementation leads to:
- ❌ API contract violations (breaking the spec)
- ❌ Inconsistent implementations
- ❌ Boilerplate code duplication
- ❌ Type safety issues
- ❌ Difficult integration and maintenance

## The Solution

Generate a **complete PHP library** from the OpenAPI spec that:
1. **Enforces the API contract** through type safety and interfaces
2. **Provides all necessary components** (routes, controllers, DTOs, validation)
3. **Makes it impossible (or highly difficult) to break the API contract**
4. **Follows industry best practices** (SOLID, DRY, KISS, PSR-4, Laravel conventions)

---

## Success Definition

**The library generator is successful when:**

1. ✅ Developer installs via `composer require vendor/api-library`
2. ✅ Developer integrates library (routes, DI bindings) with full control over structure
3. ✅ Developer implements business logic interfaces (no generated code modification)
4. ✅ **Breaking the API contract causes compile-time or runtime errors** (not silent failures)
5. ✅ IDE provides full autocomplete and type checking
6. ✅ Generated code follows SOLID, DRY, KISS, PSR-4, Laravel best practices
7. ✅ Tests pass demonstrating contract enforcement
8. ✅ Documentation is clear and examples are provided

**Most Critical Success Criteria:**
> **The developer cannot accidentally break the API contract.** Type safety, interfaces, and validation enforce the OpenAPI specification automatically.

---

## Reference Implementation

**📌 `examples/laravel-max/`** - **THE ETALON (Standard)**

This directory contains the **ideal reference implementation** - a hand-crafted example showing exactly what we want generators to produce:

- ✅ All patterns from `GOAL_MAX.md` correctly implemented
- ✅ Complete library/application separation
- ✅ One controller per operation pattern
- ✅ Authentication middleware (interface + stub + validator)
- ✅ Comprehensive documentation and tests
- ✅ **Use this as the benchmark when evaluating generators**

See `examples/laravel-max/README.md` for complete documentation.

---

## Generator Approaches

This project pursues **two parallel generator approaches** to achieve the goal. Both aim to produce the same quality output (as defined in GOAL_MAX.md), but use different implementation strategies:

### 1. php-max Generator (PoC - Custom Java Generator)

| Attribute | Value |
|-----------|-------|
| **Base** | OpenAPI Generator v7.18.0 |
| **Type** | Custom Java generator with embedded per-operation logic |
| **Location** | `openapi-generator-generators/php-max/` |
| **Templates** | Laravel (default), Symfony, Slim (external) |
| **Status** | Working PoC, validated with 166 integration tests |
| **Epic** | N/A (original development, various GENDE-0xx tickets) |

**How it works:** The per-operation generation logic is implemented directly in the Java generator class (`PhpMaxGenerator.java`). The generator itself handles the loop over operations.

### 2. New Generator (Production - Extended Core)

| Attribute | Value |
|-----------|-------|
| **Base** | OpenAPI Generator fork with extended core engine |
| **Type** | Standard generator using core's `operationTemplateFiles()` API |
| **Location** | TBD (will be created in GENDE-089) |
| **Templates** | Laravel (default/embedded), Symfony, Slim (external) |
| **Status** | Planned |
| **Epic** | GENDE-088 (36 tickets) |

**How it works:** The per-operation generation is handled by the core engine (via `TemplateFileType.Operation`). The generator just configures which templates to use via `operationTemplateFiles()` map.

### Why Two Approaches?

| Aspect | php-max (PoC) | New Generator (Production) |
|--------|---------------|---------------------------|
| **Purpose** | Prove the concept works | Production-ready solution |
| **Core changes** | Embedded in generator | In core engine (shareable) |
| **Upstream contribution** | Not possible (custom code) | Possible (GENDE-078 epic) |
| **Maintenance** | Self-contained | Benefits from upstream updates |
| **Flexibility** | Full control | Follows core conventions |

**Both approaches are valid and maintained.** They serve different purposes:
- **php-max**: Quick iteration, full control, proven working
- **New generator**: Clean architecture, upstream compatibility, long-term maintainability

### Related Epics

- **GENDE-078**: Contribute per-operation templates to upstream OpenAPI Generator
- **GENDE-088**: Create production generator based on extended OpenAPI Generator core

---

## Program Maximum

For detailed specifications of the ideal Laravel-focused solution, including:
- Library integration patterns
- Routes, controllers, and middleware
- Security middleware components (Interface + Stub + Validator)
- Request/response handling
- Data structures and validation
- Complete component list

**See:** [GOAL_MAX.md](GOAL_MAX.md)
