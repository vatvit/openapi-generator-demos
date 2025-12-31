---
code: GENDE-003
status: Proposed
dateCreated: 2025-12-30T21:56:04.186Z
type: Architecture
priority: Low
---

# GENDE-003: Investigate Symfony Library Generation Feasibility

> ⚠️ **STATUS: NEEDS CLARIFICATION** - This is a research/investigation ticket. Scope and goals need refinement.

## 1. Description

### Problem Statement
Currently, the project focuses on Laravel library generation. There may be demand or benefit in supporting Symfony framework as well, leveraging the existing generator infrastructure.

### Research Question
Is it possible to adjust the existing generator (laravel-max or OpenAPI Generator templates) to generate Symfony-compatible libraries that follow the same quality standards?

### Current State
- `laravel-max` generator produces high-quality Laravel libraries
- OpenAPI Generator has a `php-symfony` generator available (not yet evaluated)
- No Symfony-specific templates or generators in this project

### Desired Outcome
Clear understanding of:
1. Feasibility of Symfony library generation
2. Effort required
3. Recommended approach (if feasible)

## 2. Rationale

- **Broader Adoption**: Symfony is a major PHP framework with significant market share
- **Code Reuse**: May be able to reuse patterns from laravel-max
- **Completeness**: Supporting both major PHP frameworks increases project value
- **Learning**: Understanding Symfony generation informs overall architecture

## 3. Solution Analysis

### Questions to Clarify

1. **Priority**: How important is Symfony support vs other improvements?
2. **Target Symfony Version**: Symfony 6.x? 7.x?
3. **Quality Bar**: Same standards as `laravel-max` (GOAL_MAX.md)?
4. **Scope**: Full library or subset of features first?

### Investigation Areas

#### A. Evaluate Existing `php-symfony` Generator
- [ ] Extract default templates from OpenAPI Generator's `php-symfony`
- [ ] Analyze capabilities (similar to GENERATOR-ANALYSIS.md for php-laravel)
- [ ] Compare against GOAL_MAX.md requirements
- [ ] Document gaps and limitations

#### B. Assess Adaptation of `laravel-max` Approach
- [ ] Identify Laravel-specific vs framework-agnostic patterns
- [ ] Map Laravel concepts to Symfony equivalents:
  | Laravel | Symfony |
  |---------|--------|
  | Controllers | Controllers |
  | Form Requests | Symfony Forms / Validators |
  | Resources | Serializers / Normalizers |
  | Service Providers | Dependency Injection Config |
  | Middleware | Event Listeners / Subscribers |
  | Routes (files) | Routes (annotations/attributes/yaml) |
- [ ] Estimate effort to create Symfony templates

#### C. Evaluate Custom Generator Approach
- [ ] Could `laravel-max` Java generator be extended for Symfony?
- [ ] Or better to create separate `symfony-max` generator?
- [ ] Shared base class possibility?

### Potential Approaches

**Option 1: Customize `php-symfony` Generator Templates**
- Use existing OpenAPI Generator php-symfony
- Create custom templates like we did for php-laravel
- Pros: Less work, proven base
- Cons: Limited by generator's architecture

**Option 2: Create `symfony-max` Custom Generator**
- Fork/extend laravel-max generator for Symfony
- Full control over output
- Pros: Maximum quality, consistent with laravel-max
- Cons: Significant effort, maintenance burden

**Option 3: Framework-Agnostic Core + Framework Adapters**
- Refactor to generate framework-agnostic DTOs/interfaces
- Create thin framework-specific adapters
- Pros: DRY, supports multiple frameworks
- Cons: Complex architecture, may compromise framework-native feel

*Approach to be selected after investigation.*

## 4. Implementation Specification

### Phase 1: Research (This Ticket)

1. **Extract and Analyze php-symfony Generator**
   ```bash
   make extract-symfony-templates  # To be created
   ```
   - Create `GENERATOR-ANALYSIS.md` for php-symfony
   - Score against GOAL_MAX.md criteria

2. **Document Symfony Equivalents**
   - Map all laravel-max components to Symfony patterns
   - Identify gaps and challenges

3. **Effort Estimation**
   - Estimate for each approach
   - Recommend go/no-go decision

4. **Deliverable: Investigation Report**
   - Feasibility assessment
   - Recommended approach (if feasible)
   - Rough implementation plan

### Phase 2: Implementation (Future Ticket)
*To be created if investigation shows feasibility and there's interest.*

## 5. Acceptance Criteria

- [ ] `php-symfony` default templates extracted to `openapi-generator-server-templates/openapi-generator-server-php-symfony-default/`
- [ ] `GENERATOR-ANALYSIS.md` created for php-symfony generator
- [ ] Laravel-to-Symfony component mapping documented
- [ ] Feasibility assessment completed with clear recommendation
- [ ] Effort estimate provided for recommended approach
- [ ] Go/no-go decision documented with rationale