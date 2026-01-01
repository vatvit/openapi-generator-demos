---
code: GENDE-010
status: Implemented
dateCreated: 2026-01-01T13:59:46.436Z
type: Architecture
priority: Medium
relatedTickets: GENDE-001,GENDE-004
---

# Investigate php-laravel Generator OOTB Capabilities and Limitations

## 1. Description

### Problem Statement

Before creating a custom generator (laravel-max), we needed to understand what the built-in `php-laravel` generator could and couldn't do out-of-the-box (OOTB).

### Goal

Document the capabilities and limitations of OpenAPI Generator's built-in `php-laravel` generator against GOAL_MAX.md requirements.

### Scope

- Extract and analyze default php-laravel templates
- Generate sample output and analyze structure
- Document what's achievable with template customization only
- Identify fundamental limitations requiring custom Java generator

## 2. Rationale

- **Baseline understanding** - Know what OOTB provides before building custom solution
- **Justified investment** - Custom generator (laravel-max) is significant effort; must prove OOTB insufficient
- **Template vs Generator** - Distinguish what templates can solve vs what requires Java code

## 3. Solution Analysis

### Key Questions Investigated

1. **Can php-laravel generate one file per operation?**
   - Finding: No - templates iterate per-tag, not per-operation
   - Template limitation, not solvable without Java generator

2. **Can php-laravel generate per-response Resources?**
   - Finding: No - no per-response loop available in templates
   - Requires custom Java generator to expose response iteration

3. **Can php-laravel compute union return types?**
   - Finding: No - Mustache is logic-less, cannot compute dynamically
   - Requires Java code to pre-compute union types

4. **What CAN be achieved with template customization?**
   - Models/DTOs with typed properties
   - Basic validation rules
   - Route generation
   - Single controller per tag (not per operation)

### Findings Summary

| GOAL_MAX.md Requirement | php-laravel OOTB | With Templates | Verdict |
|------------------------|------------------|----------------|----------|
| One controller per operation | ❌ Per-tag | ❌ Cannot change | Requires Java |
| Per-response Resources | ❌ Not generated | ❌ No loop available | Requires Java |
| Union return types | ❌ Not computed | ❌ Mustache limitation | Requires Java |
| Security interfaces | ❌ Not generated | ⚠️ Partial via templates | Better in Java |
| Typed DTOs | ✅ Generated | ✅ Customizable | Template OK |
| Validation rules | ⚠️ Basic | ✅ Customizable | Template OK |
| Routes | ✅ Generated | ✅ Customizable | Template OK |

## 4. Implementation Specification

### Artifacts Created

1. **Default templates extracted** to `openapi-generator-server-templates/openapi-generator-server-php-laravel-default/`
2. **GENERATOR-ANALYSIS.md** with capability scoring
3. **Sample generated output** for analysis

### Evidence Location

- Templates: `openapi-generator-server-templates/openapi-generator-server-php-laravel-default/`
- Analysis: `openapi-generator-server-templates/openapi-generator-server-php-laravel-default/GENERATOR-ANALYSIS.md`
- Detailed comparison: `docs/GENERATOR-COMPARISON.md` (GENDE-004)

## 5. Acceptance Criteria

- [x] Default php-laravel templates extracted
- [x] GENERATOR-ANALYSIS.md created (85% score documented)
- [x] Capabilities scored against GOAL_MAX.md
- [x] Fundamental limitations identified and documented
- [x] Justification for custom generator (laravel-max) established

## 6. Current State

**Status:** Implemented (retroactively documented)

**Key Finding:** php-laravel generator scores ~85% but has fundamental limitations:
- Cannot generate per-operation files (templates iterate per-tag)
- Cannot generate per-response Resources
- Cannot compute union return types

These limitations justified the creation of laravel-max custom Java generator (GENDE-001).

**Note:** This ticket was created retroactively to document work that was done as part of the initial investigation before GENDE-001.