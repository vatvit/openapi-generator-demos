---
code: GENDE-008
status: Implemented
dateCreated: 2026-01-01T12:55:56.543Z
type: Architecture
priority: Low
dependsOn: GENDE-003,GENDE-007
---

# Symfony Generator Feasibility Assessment and Approach Decision

## 1. Description

### Problem Statement

After analyzing the `php-symfony` generator (GENDE-003) and mapping Laravel concepts to Symfony (GENDE-007), we need to decide:
1. Is Symfony library generation feasible?
2. What approach should we take?
3. What is the estimated effort?

### Goal

Make a go/no-go decision on Symfony support and select implementation approach.

### Scope

- Review findings from GENDE-003 and GENDE-007
- Evaluate implementation approaches
- Estimate effort for each approach
- Make recommendation

## 2. Rationale

- **Informed decision** - Based on research, not assumptions
- **Clear direction** - Defines path forward (or decision to not proceed)
- **Resource planning** - Effort estimates guide prioritization

## 3. Solution Analysis

### Potential Approaches

**Option 1: Customize `php-symfony` Generator Templates**
- Use existing OpenAPI Generator php-symfony
- Create custom templates (like php-laravel approach)
- Pros: Less work, proven base
- Cons: Limited by generator's architecture

**Option 2: Create `symfony-max` Custom Generator**
- Fork/extend laravel-max generator for Symfony
- Full control over output
- Pros: Maximum quality, consistent with laravel-max
- Cons: Significant effort, maintenance burden

**Option 3: Framework-Agnostic Core + Adapters**
- Refactor to generate framework-agnostic DTOs/interfaces
- Create thin framework-specific adapters
- Pros: DRY, supports multiple frameworks
- Cons: Complex architecture, may compromise framework-native feel

**Option 4: No Symfony Support**
- Focus on Laravel only
- Document why Symfony was not pursued
- Pros: Focus resources
- Cons: Limited framework coverage

### Evaluation Criteria

| Criteria | Weight |
|----------|--------|
| Meets GOAL_MAX.md quality | High |
| Implementation effort | Medium |
| Maintenance burden | Medium |
| Framework-native feel | Medium |
| Code reuse from laravel-max | Low |

## 4. Implementation Specification
### Research Summary

**GENDE-003 Findings (php-symfony Generator Analysis):**
- Overall score: **54%** against GOAL_MAX.md
- Strengths: Routes (90%), DTOs (85%), Validators (85%)
- Critical gaps:
  - Controllers: 60% (per-tag, not per-operation)
  - Response DTOs: 20% (not generated)
  - Response Factories: 0% (not generated)
  - Middleware: 20% (no middleware concept)
  - Security: 30% (method-based, not middleware)
- **Key limitation:** Cannot generate per-operation files without custom Java generator

**GENDE-007 Findings (Laravel-Symfony Mapping):**

| Component | Mapping Difficulty |
|-----------|-------------------|
| Routes, Controllers, DTOs, DI | Easy |
| Request Validation, Response Wrappers | Medium |
| Security, Middleware | **Hard** |

**Critical architectural difference:**
- Laravel: Code-driven middleware (per-route/per-operation)
- Symfony: Configuration-driven firewall (URL patterns)

---

### Approach Evaluation

| Criteria (Weight) | Option 1: Custom Templates | Option 2: symfony-max | Option 3: Agnostic Core | Option 4: No Symfony |
|-------------------|---------------------------|----------------------|------------------------|---------------------|
| **GOAL_MAX Quality (High)** | ⚠️ 60% max | ✅ 95%+ possible | ⚠️ 70% compromise | ❌ N/A |
| **Implementation Effort (Med)** | ✅ Low-Medium | ❌ High | ❌ Very High | ✅ None |
| **Maintenance Burden (Med)** | ✅ Low | ⚠️ Medium | ❌ High | ✅ None |
| **Framework-Native (Med)** | ⚠️ Partial | ✅ Full | ❌ Generic | ❌ N/A |
| **Reuse laravel-max (Low)** | ❌ Limited | ✅ High | ⚠️ Medium | ❌ None |

---

### Effort Estimates

**Option 1: Custom Templates for php-symfony**
- Effort: 1-2 weeks
- Max achievable: ~60-65% GOAL_MAX compliance
- Limitations: Cannot achieve per-operation files, response factories
- Not recommended: Cannot meet quality bar

**Option 2: symfony-max Custom Java Generator**
- Effort: 3-4 weeks (based on laravel-max experience)
- Achievable: 90%+ GOAL_MAX compliance
- Pros: Full control, consistent quality with laravel-max
- Cons: Maintenance of second custom generator

**Option 3: Framework-Agnostic Core**
- Effort: 6-8 weeks (significant refactoring)
- Achievable: ~70% (compromises framework-native patterns)
- Not recommended: Over-engineered for 2 frameworks

**Option 4: No Symfony Support**
- Effort: None
- Document decision and rationale
- Focus resources on Laravel improvements

---

### Recommendation

**Recommended: Option 4 (No Symfony Support) for now, with Option 2 as future consideration**

**Rationale:**

1. **Quality bar cannot be met with Option 1**: Custom templates alone cannot achieve GOAL_MAX compliance due to per-operation file limitation.

2. **Option 2 requires significant effort**: 3-4 weeks is substantial investment. Should be prioritized only if there's clear demand for Symfony support.

3. **Laravel focus is justified**: Laravel has larger market share in API development. Better to have one excellent solution than two mediocre ones.

4. **Security mapping is fundamentally different**: Symfony's configuration-driven security doesn't map cleanly to laravel-max patterns. Would require different approach documentation.

5. **Keep door open**: Document findings thoroughly so Option 2 can be pursued later if demand justifies it.

---

### Decision

**GO/NO-GO: Defer (Conditional NO-GO)**

- **Do not proceed** with Symfony implementation at this time
- **Document findings** in GENDE-003 and GENDE-007 for future reference
- **Revisit decision** if:
  - Clear user demand for Symfony support emerges
  - Resources available for 3-4 week symfony-max development
  - Symfony adoption in target market increases

---

### Next Steps

1. ✅ Close GENDE-003, GENDE-007, GENDE-008 as Implemented
2. ⏸️ Put GENDE-009 on hold (or close as Won't Do)
3. 📝 Update project documentation to reflect Laravel-only focus
4. 🔮 Add "Symfony Support" to future considerations backlog
## 5. Acceptance Criteria
- [x] All approaches evaluated against criteria
- [x] Effort estimates provided for viable approaches
- [x] Clear recommendation made: **Defer (Conditional NO-GO)**
- [x] Rationale documented
- [x] Next steps defined: Close GENDE-009 as Won't Do, document findings

## 6. Decision Summary
| Question | Answer |
|----------|--------|
| Is Symfony feasible? | Yes, but only with custom Java generator (Option 2) |
| Is it worth the effort? | Not at this time |
| What's the recommendation? | Focus on Laravel, defer Symfony |
| When to revisit? | When clear demand emerges |
| Estimated effort if pursued? | 3-4 weeks for symfony-max |

## 7. Investigation Roadmap

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    PHP Framework Generator Roadmap                       │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  LARAVEL PATH                           SYMFONY PATH                    │
│  ════════════                           ════════════                    │
│                                                                         │
│  ┌──────────────────┐                  ┌──────────────────┐            │
│  │ GENDE-010        │                  │ GENDE-003        │            │
│  │ php-laravel      │                  │ php-symfony      │            │
│  │ OOTB Analysis    │                  │ OOTB Analysis    │            │
│  │ ✅ Implemented    │                  │ ✅ Implemented    │            │
│  └────────┬─────────┘                  └────────┬─────────┘            │
│           │                                     │                       │
│           ▼                                     ▼                       │
│  ┌──────────────────┐                  ┌──────────────────┐            │
│  │ Custom Templates │                  │ GENDE-012        │            │
│  │ + Demo Project   │                  │ Custom Templates │            │
│  │ ✅ Exists         │                  │ 📋 Proposed       │            │
│  └────────┬─────────┘                  └────────┬─────────┘            │
│           │                                     │                       │
│           ▼                                     ▼                       │
│  ┌──────────────────┐                  ┌──────────────────┐            │
│  │ GENDE-001        │                  │ GENDE-013        │            │
│  │ laravel-max      │                  │ Demo Project     │            │
│  │ Custom Generator │                  │ 📋 Proposed       │            │
│  │ ✅ Implemented    │                  └────────┬─────────┘            │
│  └────────┬─────────┘                           │                       │
│           │                                     ▼                       │
│           │                            ┌──────────────────┐            │
│           │                            │ GENDE-014        │            │
│           │                            │ Integration Tests│            │
│           │                            │ 📋 Proposed       │            │
│           │                            └────────┬─────────┘            │
│           │                                     │                       │
│           │                                     ▼                       │
│           │                            ┌──────────────────┐            │
│           │                            │ GENDE-009        │            │
│           │                            │ symfony-max      │            │
│           │                            │ ⏸️ On Hold       │            │
│           │                            └────────┬─────────┘            │
│           │                                     │                       │
│           └──────────────┬──────────────────────┘                       │
│                          │                                              │
│                          ▼                                              │
│                 ┌──────────────────┐                                   │
│                 │ GENDE-011        │                                   │
│                 │ php-max          │                                   │
│                 │ Combined Gen     │                                   │
│                 │ 📋 Future         │                                   │
│                 └──────────────────┘                                   │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Artifact Parity Matrix

| Artifact | Laravel Path | Symfony Path |
|----------|-------------|--------------|
| **OOTB Analysis** | GENDE-010 ✅ | GENDE-003 ✅ |
| **Default Templates** | `php-laravel-default/` ✅ | `php-symfony-default/` ✅ |
| **GENERATOR-ANALYSIS.md** | ✅ (85%) | ✅ (54%) |
| **Custom Templates** | `php-laravel/` ✅ | GENDE-012 📋 |
| **Generated TicTacToe** | ✅ | ✅ |
| **Generated PetShop** | ✅ | GENDE-012 📋 |
| **Demo Project** | `laravel-api--php-laravel--*` ✅ | GENDE-013 📋 |
| **Integration Tests** | ✅ | GENDE-014 📋 |
| **Custom Java Generator** | GENDE-001 ✅ (laravel-max) | GENDE-009 ⏸️ |
| **Max Generated Output** | `generated/laravel-max/` ✅ | On Hold |

### Related Tickets

| Category | Tickets |
|----------|---------|
| OOTB Analysis | GENDE-010 (Laravel), GENDE-003 (Symfony) |
| Mapping/Comparison | GENDE-004, GENDE-007 |
| Custom Templates | GENDE-012 (Symfony) |
| Demo Projects | GENDE-013 (Symfony) |
| Integration Tests | GENDE-014 (Symfony) |
| Custom Generators | GENDE-001 (laravel-max), GENDE-009 (symfony-max) |
| Combined Generator | GENDE-011 (php-max) |
| Other | GENDE-002, GENDE-005, GENDE-006 |