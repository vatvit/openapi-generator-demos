---
code: GENDE-039
status: Implemented
dateCreated: 2026-01-03T12:45:00.000Z
type: Template Development
priority: Medium
relatedTickets: GENDE-040,GENDE-041
implementationDate: 2026-01-03
---

# Slim: Complete controller template

## 1. Description

Complete the Slim controller template for php-max generator.

## 2. Requirements

- Single-action invokable controllers
- PSR-7 Request/Response objects
- Constructor injection for handler
- Route attribute or configuration

## 3. Tasks

- [ ] Review existing `controller.mustache` template
- [ ] Implement invokable `__invoke` method
- [ ] Add PSR-7 request parameter handling
- [ ] Add response serialization
- [ ] Test template rendering

## 4. Acceptance Criteria

- [ ] Controller template generates valid PHP
- [ ] Controllers are invokable
- [ ] Proper PSR-7 integration
