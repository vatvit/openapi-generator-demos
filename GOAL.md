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

## Program Maximum

For detailed specifications of the ideal Laravel-focused solution, including:
- Library integration patterns
- Routes, controllers, and middleware
- Security middleware components (Interface + Stub + Validator)
- Request/response handling
- Data structures and validation
- Complete component list

**See:** [GOAL_MAX.md](GOAL_MAX.md)
