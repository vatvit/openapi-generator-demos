---
code: GENDE-119
status: Proposed
dateCreated: 2026-01-07T16:42:24.376Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 4: Slim
relatedTickets: GENDE-088,GENDE-118
dependsOn: GENDE-118
---

# Create Slim routes and dependencies templates

## 1. Description

Create Slim routes.php and dependencies.php (PHP-DI) templates.

## 2. Rationale

Slim configuration:
- routes.php for route definitions
- dependencies.php for PHP-DI container

## 3. Solution Analysis

### routes.php Pattern
```php
use Slim\App;

return function (App $app) {
    $app->post('/pets', CreatePetAction::class);
    $app->get('/pets', FindPetsAction::class);
    $app->get('/pets/{petId}', GetPetByIdAction::class);
};
```

### dependencies.php Pattern
```php
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        PetApiHandlerInterface::class => autowire(PetHandler::class),
    ]);
};
```

## 4. Implementation Specification

### Templates
- `routes.mustache` - Slim route definitions
- `dependencies.mustache` - PHP-DI configuration

## 5. Acceptance Criteria

- [ ] Valid PHP syntax
- [ ] All routes defined
- [ ] PHP-DI autowiring works
- [ ] Slim app boots correctly