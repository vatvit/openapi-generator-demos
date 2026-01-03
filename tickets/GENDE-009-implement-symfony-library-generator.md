---
code: GENDE-009
status: Won't Do
dateCreated: 2026-01-01T12:56:16.706Z
type: Feature Enhancement
priority: Medium
dependsOn: GENDE-008
closedReason: OOTB php-symfony generator doesn't match requirements - it generates full Symfony projects/bundles, not reusable libraries. Symfony library generation achieved via php-max generator with Symfony templates (GENDE-011, GENDE-027).
---

# Implement Symfony Library Generator

## 1. Description

### Problem Statement

After research (GENDE-003), mapping (GENDE-007), and feasibility assessment (GENDE-008), implement Symfony library generation following the chosen approach.

### Goal

Create a Symfony library generator that meets GOAL_MAX.md quality standards.

### Scope

*To be defined based on GENDE-008 decision.*

Potential scope:
- Custom templates for php-symfony generator, OR
- New symfony-max custom generator, OR
- Framework-agnostic refactoring

## 2. Rationale

- **Broader adoption** - Symfony is a major PHP framework
- **Proven patterns** - Apply learnings from laravel-max
- **Project goal** - Support multiple PHP frameworks (GOAL.md)

## 3. Solution Analysis

*Approach selected in GENDE-008.*

### Target Symfony Version

Symfony 7.x (latest stable)

### Quality Requirements

Same as GOAL_MAX.md, adapted for Symfony:
- Contract enforcement via interfaces
- Type-safe request/response handling
- Validation from OpenAPI schema
- Security middleware support
- One controller per operation (or equivalent pattern)

## 4. Implementation Specification

*To be detailed after GENDE-008 decision.*

### Potential Phases

**Phase 1: Core Generation**
- Controllers and routing
- Request DTOs with validation
- Response handling

**Phase 2: Advanced Features**
- Security middleware
- Full GOAL_MAX.md compliance
- Documentation and examples

**Phase 3: Integration Testing**
- Demo Symfony project
- Test coverage
- Comparison with laravel-max quality

## 5. Acceptance Criteria

*To be defined after GENDE-008 decision.*

General criteria:
- [ ] Symfony library generator implemented
- [ ] Meets GOAL_MAX.md quality standards (adapted for Symfony)
- [ ] Demo project validates generated code
- [ ] Documentation complete
- [ ] Tests pass

## 6. Current State

**Status:** Blocked - Waiting for GENDE-008 decision

### Dependencies

| Ticket | Status | Blocker |
|--------|--------|---------||
| GENDE-003 | Proposed | Must complete first |
| GENDE-007 | Proposed | Must complete first |
| GENDE-008 | Proposed | Decision required |