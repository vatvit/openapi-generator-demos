---
code: GENDE-111
status: Implemented
dateCreated: 2026-01-07T16:41:33.936Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 3: Symfony
relatedTickets: GENDE-088,GENDE-110
dependsOn: GENDE-110
---

# Create Symfony routes and services templates

## 1. Description

Create Symfony routes.yaml and services.yaml templates.

## 2. Rationale

Symfony configuration:
- routes.yaml for route definitions (if not using attributes)
- services.yaml for DI configuration

## 3. Solution Analysis

### routes.yaml Pattern
```yaml
api_create_pet:
    path: /pets
    controller: App\Controller\CreatePetController
    methods: [POST]
```

### services.yaml Pattern
```yaml
services:
    App\Handler\PetHandler:
        autowire: true
    
    App\Api\PetApiHandlerInterface:
        alias: App\Handler\PetHandler
```

## 4. Implementation Specification

### Templates
- `routes.yaml.mustache` - Route definitions
- `services.yaml.mustache` - DI configuration

## 5. Acceptance Criteria

- [ ] Valid YAML syntax
- [ ] All routes defined
- [ ] Handler interfaces autowired
- [ ] Symfony bundle loadable