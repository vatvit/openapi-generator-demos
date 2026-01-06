---
code: GENDE-057
status: Proposed
dateCreated: 2026-01-06T11:40:12.632Z
type: Feature Enhancement
priority: Low
dependsOn: GENDE-011
---

# Create Laminas Template Set for php-max Generator

## 1. Description

### Problem Statement
The php-max generator currently supports Laravel, Symfony, and Slim frameworks. Laminas (formerly Zend Framework) is a mature PHP framework used in enterprise applications that lacks template support.

### Goal
Create a complete `laminas-max` template set for the php-max generator, enabling code generation for Laminas-based API applications.

### Target Output
- Controllers with proper Laminas MVC patterns
- Handler interfaces for business logic
- Request/Response DTOs
- Model classes
- Route configuration

## 2. Rationale

- Laminas is used in enterprise PHP applications
- Extends php-max generator to cover more PHP ecosystem
- Lower priority due to smaller market share compared to Laravel/Symfony
- Architecture already proven with 3 frameworks

## 3. Solution Analysis

### Approach
1. Study Laminas MVC patterns and conventions
2. Create `laminas-max/` template directory
3. Create `files.json` configuration
4. Implement templates: controller, handler, model, request, response
5. Create integration test project
6. Validate with PHPUnit tests

### Reference
- Existing template sets: `laravel-max`, `symfony-max`, `slim-max`
- PhpMaxGenerator.java already supports framework-agnostic generation

## 4. Implementation Specification

### Template Files Required
```
openapi-generator-server-templates/laminas-max/
├── files.json
├── controller.mustache
├── handler.mustache
├── model.mustache
├── request.mustache
├── response.mustache
└── supporting/
    ├── routes.mustache
    └── module-config.mustache
```

### Integration Test Project
```
projects/laminas-api--php-max--integration-tests/
├── docker-compose.yml
├── Dockerfile
├── composer.json
├── module/
└── tests/
```

## 5. Acceptance Criteria

- [ ] `laminas-max/` template set complete
- [ ] `files.json` configuration working
- [ ] Integration test project created
- [ ] All generated code passes PHPUnit tests
- [ ] Documentation updated

## 6. Current State

**Status:** Not Started
**Last Updated:** 2026-01-06

### Next Actions
1. Research Laminas MVC patterns
2. Create template directory structure
3. Implement controller template first