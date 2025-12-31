---
code: GENDE-002
status: Proposed
dateCreated: 2025-12-30T21:54:05.007Z
type: Feature Enhancement
priority: Medium
---

# GENDE-002: Add Flexible Generator Configuration to Minimize Hardcodes

> ⚠️ **STATUS: NEEDS CLARIFICATION** - This ticket is a placeholder. Requirements need to be refined before implementation.

## 1. Description

### Problem Statement
The current generator configuration contains hardcoded values that limit flexibility and require code changes for customization. This creates friction when:
- Adapting generators for different projects
- Changing output paths, namespaces, or naming conventions
- Supporting multiple configuration profiles

### Current State
*To be documented after clarification*

### Desired State
A flexible configuration system that allows users to customize generator behavior without modifying code.

## 2. Rationale

- **Maintainability**: Reduces need to modify generator code for project-specific needs
- **Reusability**: Same generator can serve multiple projects with different configurations
- **Developer Experience**: Easier onboarding and customization
- **Best Practice**: Configuration over hardcoding is a fundamental software engineering principle

## 3. Solution Analysis

### Questions to Clarify

1. **Scope**: Which generators are affected?
   - `laravel-max` custom generator?
   - OpenAPI Generator config files?
   - Makefile variables?
   - All of the above?

2. **Hardcodes to Address**: What specific hardcoded values need flexibility?
   - Output paths?
   - Namespace prefixes?
   - Package names?
   - Template paths?
   - API version prefixes?
   - Other?

3. **Configuration Format**: What format should configuration use?
   - JSON (current approach for OpenAPI Generator)
   - YAML
   - Environment variables
   - .env files
   - Combination?

4. **Configuration Hierarchy**: Should there be layered configuration?
   - Global defaults → Project-specific → Environment overrides?

5. **Validation**: Should configuration be validated?
   - Schema validation?
   - Required vs optional fields?

### Potential Approaches

**Option A: Enhanced JSON Configuration**
- Extend existing `openapi-generator-configs/*.json` files
- Add more configurable options
- Pros: Familiar format, already in use
- Cons: Limited to OpenAPI Generator's supported options

**Option B: External Configuration Layer**
- Create wrapper configuration that preprocesses before generation
- Support variable substitution and templates
- Pros: Full flexibility
- Cons: More complexity

**Option C: Environment-Based Configuration**
- Use environment variables and .env files
- Makefile reads and passes to generators
- Pros: Standard approach, CI/CD friendly
- Cons: Can become unwieldy with many options

*Final approach to be selected after clarification.*

## 4. Implementation Specification

*To be defined after requirements clarification.*

### Preliminary Tasks

1. [ ] Audit current hardcoded values across generators
2. [ ] Document which values need to be configurable
3. [ ] Select configuration approach
4. [ ] Design configuration schema
5. [ ] Implement configuration loading
6. [ ] Update generators to use configuration
7. [ ] Update documentation
8. [ ] Add validation and helpful error messages

## 5. Acceptance Criteria

*To be refined after clarification. Preliminary criteria:*

- [ ] Identified hardcoded values are externalized to configuration
- [ ] Configuration is documented with examples
- [ ] Default values maintain backward compatibility
- [ ] Invalid configuration produces clear error messages
- [ ] At least one generator demonstrates the flexible configuration
- [ ] README/documentation updated with configuration guide