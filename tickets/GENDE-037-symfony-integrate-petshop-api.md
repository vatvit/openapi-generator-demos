---
code: GENDE-037
status: Implemented
dateCreated: 2026-01-03T12:45:00.000Z
type: Integration
priority: High
relatedTickets: GENDE-036,GENDE-038
blockedBy: GENDE-036
---

# Symfony: Integrate Petshop API into project

## 1. Description

Add Petshop API to the existing Symfony integration test project.

## 2. Tasks

- [ ] Add Petshop namespace mappings to `composer.json`:
  ```json
  "PetshopApi\\Model\\": "../../generated/php-max-symfony/petshop/src/Model/",
  "PetshopApi\\Api\\Controller\\": "../../generated/php-max-symfony/petshop/src/Controller/",
  "PetshopApi\\Api\\Handler\\": "../../generated/php-max-symfony/petshop/src/Handler/",
  "PetshopApi\\Api\\Dto\\": "../../generated/php-max-symfony/petshop/src/Dto/",
  "PetshopApi\\Api\\Response\\": "../../generated/php-max-symfony/petshop/src/Response/"
  ```
- [ ] Run `composer dump-autoload`
- [ ] Verify no PSR-4 warnings

## 3. Acceptance Criteria

- [ ] Petshop classes autoload correctly
- [ ] No autoloader warnings
- [ ] Existing TicTacToe tests still pass
