---
code: GENDE-007
status: Implemented
dateCreated: 2026-01-01T12:55:34.670Z
type: Documentation
priority: Low
dependsOn: GENDE-003
---

# Map Laravel Concepts to Symfony Equivalents

## 1. Description

### Problem Statement

To generate Symfony libraries with the same quality as `laravel-max`, we need to understand how Laravel concepts map to Symfony equivalents.

### Goal

Document the mapping between Laravel and Symfony components for all GOAL_MAX.md requirements.

### Scope

Create a comprehensive mapping document covering:
- Controllers and routing
- Request validation
- Response handling
- Dependency injection
- Middleware/Event listeners
- Security/Authentication

## 2. Rationale

- **Foundation for implementation** - Clear mapping guides template development
- **Identifies challenges** - Some concepts may not map 1:1
- **Reusable knowledge** - Documents Symfony patterns for future reference

## 3. Solution Analysis

### Component Mapping Table

| Laravel | Symfony | Notes |
|---------|---------|-------|
| Controllers | Controllers | Similar concept |
| Form Requests | Symfony Forms / Validators | Different approach |
| Resources | Serializers / Normalizers | Different API |
| Service Providers | services.yaml / DI config | Configuration-based |
| Middleware | Event Listeners / Subscribers | Different pattern |
| Routes (files) | Routes (attributes/yaml) | Multiple options |
| Eloquent Models | Doctrine Entities | ORM difference |

### Key Differences to Document

1. **Request Validation**: Laravel uses FormRequest, Symfony uses Validator component
2. **Response Transformation**: Laravel Resources vs Symfony Serializer
3. **DI Configuration**: Laravel auto-discovery vs Symfony explicit config
4. **Middleware**: Laravel middleware chain vs Symfony event system

## 4. Implementation Specification

### Deliverable

Create `docs/LARAVEL-SYMFONY-MAPPING.md` with:

1. **Component-by-component mapping**
2. **Code examples** for each mapping
3. **Challenges and gaps** identified
4. **Recommended Symfony patterns** for GOAL_MAX.md requirements

### Structure

```markdown
# Laravel to Symfony Component Mapping

## 1. Controllers
### Laravel Approach
### Symfony Equivalent
### Example Code

## 2. Request Validation
...

## 3. Response Resources
...
```

## 5. Acceptance Criteria
- [x] Mapping document created at `openapi-generator-server-templates/openapi-generator-server-php-symfony-default/LARAVEL-SYMFONY-MAPPING.md`
- [x] All GOAL_MAX.md components mapped to Symfony equivalents
- [x] Code examples provided for each mapping
- [x] Challenges and gaps documented
- [x] Symfony 7.x patterns used (latest version)

## 6. Current State

**Last Updated:** 2026-01-01

### Artifact Location
`openapi-generator-server-templates/openapi-generator-server-php-symfony-default/LARAVEL-SYMFONY-MAPPING.md`

### Key Findings

**Mapping Difficulty by Component:**

| Component | Difficulty | Notes |
|-----------|-----------|-------|
| Routes | Easy | YAML already supported |
| Controllers | Easy | Similar pattern |
| DTOs/Models | Easy | Already generated |
| DI Config | Easy | services.yaml |
| Request Validation | Medium | `#[MapRequestPayload]` + DTOs |
| Response Wrappers | Medium | Custom response classes needed |
| Handler Interfaces | Medium | Union return types |
| Security (Auth) | Hard | Authenticators + firewall |
| Security Validator | Hard | Different paradigm |
| Per-operation middleware | Hard | URL patterns vs routes |

### Conclusion

Creating `symfony-max` is **feasible but requires architectural decisions** due to Symfony's configuration-driven security model vs Laravel's code-driven middleware approach.

**Recommended approach:**
1. Use custom templates for php-symfony generator
2. Focus on: per-operation controllers, response wrappers, typed interfaces
3. Security: Authenticator stubs + security.yaml patterns
4. Accept some patterns will differ from Laravel