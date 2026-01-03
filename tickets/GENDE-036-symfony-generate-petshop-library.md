---
code: GENDE-036
status: Implemented
dateCreated: 2026-01-03T12:45:00.000Z
type: Generation
priority: High
relatedTickets: GENDE-030,GENDE-037
---

# Symfony: Generate Petshop library

## 1. Description

Generate Petshop API library using php-max generator with Symfony templates.

## 2. Tasks

- [ ] Create generation config for petshop-symfony
- [ ] Set correct namespace (`PetshopApi`)
- [ ] Generate to `generated/php-max-symfony/petshop/`
- [ ] Run PHP syntax check
- [ ] Verify directory structure matches tictactoe

## 3. Acceptance Criteria

- [ ] Petshop library generated at `generated/php-max-symfony/petshop/`
- [ ] Correct `PetshopApi` namespace
- [ ] All files pass PHP syntax check
