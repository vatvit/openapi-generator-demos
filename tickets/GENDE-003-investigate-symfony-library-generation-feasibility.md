---
code: GENDE-003
status: Implemented
dateCreated: 2025-12-30T21:56:04.186Z
type: Architecture
priority: Low
---

# GENDE-003: Investigate Symfony Library Generation Feasibility

> ⚠️ **STATUS: NEEDS CLARIFICATION** - This is a research/investigation ticket. Scope and goals need refinement.

## 1. Description
### Problem Statement

The project goal is to find solutions for generating **high-quality, contract-enforced API libraries** for different PHP frameworks (see GOAL.md). Currently, only Laravel is supported via `laravel-max` generator.

OpenAPI Generator includes a `php-symfony` generator that may serve as a foundation for Symfony framework support.

### Goal

Extract and analyze the default `php-symfony` generator to understand:
1. What it generates out of the box
2. How it compares to GOAL_MAX.md quality requirements
3. Capabilities and limitations

### Scope

- Extract default templates from OpenAPI Generator's `php-symfony`
- Create `GENERATOR-ANALYSIS.md` documenting capabilities
- Score against GOAL_MAX.md criteria
- Identify gaps and limitations

### Out of Scope

- Laravel-to-Symfony mapping (GENDE-007)
- Feasibility assessment and approach decision (GENDE-008)
- Implementation (GENDE-009)
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
### Steps

1. **Extract default php-symfony templates**
   ```bash
   docker run --rm -v "$(pwd):/local" openapitools/openapi-generator-cli:v7.12.0 \
     author template -g php-symfony -o /local/openapi-generator-server-php-symfony-default
   ```

2. **Generate sample output** using TicTacToe spec
   ```bash
   docker run --rm -v "$(pwd):/local" openapitools/openapi-generator-cli:v7.12.0 generate \
     -g php-symfony -i /local/specs/tictactoe.json -o /local/output
   ```

3. **Analyze generated code** against GOAL_MAX.md:
   - Routes/Controllers structure
   - Request validation
   - Response handling
   - DTOs/Models
   - Security middleware support
   - Type safety

4. **Create GENERATOR-ANALYSIS.md** with:
   - Overview of generated structure
   - Scoring table (like php-laravel analysis)
   - Identified gaps
   - Raw capabilities summary
## 5. Acceptance Criteria
- [x] Default `php-symfony` templates extracted to `openapi-generator-server-templates/openapi-generator-server-php-symfony-default/`
- [x] `GENERATOR-ANALYSIS.md` created for php-symfony generator
- [x] Capabilities scored against GOAL_MAX.md requirements (Overall: 54%)
- [x] Gaps and limitations documented

## 6. Current State

**Last Updated:** 2026-01-01

### Artifact Locations
- Templates: `openapi-generator-server-templates/openapi-generator-server-php-symfony-default/`
- Generated sample: `generated/php-symfony/tictactoe/`
- Analysis: `openapi-generator-server-templates/openapi-generator-server-php-symfony-default/GENERATOR-ANALYSIS.md`

### Key Findings

**Overall Score: 54%** against GOAL_MAX.md

**Strengths:**
- Routes (YAML config): 90%
- Validators (Symfony Assert): 85%
- DTOs/Models: 85%
- Documentation: 80%
- API Interfaces: 70%

**Major Gaps:**
- Controllers: 60% - One per tag, not per operation
- Middleware: 20% - No middleware concept
- Security: 30% - Method-based, not middleware
- Response Classes: 20% - No response DTOs
- Response Factories: 0% - Not generated

**Critical Limitations for GOAL_MAX.md:**
1. Cannot generate per-operation files (requires custom Java generator)
2. Return type `array|object|null` provides no contract enforcement
3. Response code/headers by reference (awkward pattern)
4. Security via method injection, not proper middleware
5. Uses JMS Serializer (legacy) instead of Symfony Serializer

### Conclusion

The `php-symfony` generator has similar fundamental limitations as `php-laravel` - it cannot generate per-operation files without a custom Java generator. For Symfony support matching laravel-max quality, a `symfony-max` custom generator would likely be needed.