---
code: GENDE-058
status: Proposed
dateCreated: 2026-01-06T11:40:12.711Z
type: Feature Enhancement
priority: Low
dependsOn: GENDE-011
---

# Create CodeIgniter Template Set for php-max Generator

## 1. Description

### Problem Statement
The php-max generator currently supports Laravel, Symfony, and Slim frameworks. CodeIgniter is a lightweight PHP framework popular for small to medium projects that lacks template support.

### Goal
Create a complete `codeigniter-max` template set for the php-max generator, enabling code generation for CodeIgniter 4-based API applications.

### Target Output
- Controllers with proper CodeIgniter 4 patterns
- Handler interfaces for business logic
- Request/Response DTOs (Entities)
- Model classes
- Route configuration

## 2. Rationale

- CodeIgniter 4 is a lightweight, fast PHP framework
- Popular for smaller projects and rapid development
- Lower priority due to smaller enterprise adoption
- Architecture already proven with 3 frameworks

## 3. Solution Analysis

### Approach
1. Study CodeIgniter 4 patterns and conventions
2. Create `codeigniter-max/` template directory
3. Create `files.json` configuration
4. Implement templates: controller, handler, model, entity
5. Create integration test project
6. Validate with PHPUnit tests

### Reference
- Existing template sets: `laravel-max`, `symfony-max`, `slim-max`
- PhpMaxGenerator.java already supports framework-agnostic generation

## 4. Implementation Specification

### Template Files Required
```
openapi-generator-server-templates/codeigniter-max/
├── files.json
├── controller.mustache
├── handler.mustache
├── model.mustache
├── entity.mustache
├── request.mustache
├── response.mustache
└── supporting/
    └── routes.mustache
```

### Integration Test Project
```
projects/codeigniter-api--php-max--integration-tests/
├── docker-compose.yml
├── Dockerfile
├── composer.json
├── app/
└── tests/
```

## 5. Acceptance Criteria

- [ ] `codeigniter-max/` template set complete
- [ ] `files.json` configuration working
- [ ] Integration test project created
- [ ] All generated code passes PHPUnit tests
- [ ] Documentation updated

## 6. Current State

**Status:** Not Started
**Last Updated:** 2026-01-06

### Next Actions
1. Research CodeIgniter 4 patterns
2. Create template directory structure
3. Implement controller template first