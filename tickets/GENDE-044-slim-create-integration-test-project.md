---
code: GENDE-044
status: Implemented
dateCreated: 2026-01-03T12:45:00.000Z
type: Project Setup
priority: Medium
relatedTickets: GENDE-042,GENDE-043,GENDE-045
blockedBy: GENDE-042,GENDE-043
---

# Slim: Create integration test project

## 1. Description

Create a new integration test project for Slim framework.

## 2. Tasks

- [ ] Create `projects/slim-api--slim-max--integration-tests/`
- [ ] Create `composer.json` with:
  - slim/slim
  - slim/psr7
  - php-di/php-di
  - phpunit/phpunit
- [ ] Configure PSR-4 autoloading for both APIs
- [ ] Create `Makefile` for Docker-based commands
- [ ] Create `phpunit.xml`
- [ ] Create basic directory structure

## 3. Acceptance Criteria

- [ ] Project created with proper structure
- [ ] `composer install` works
- [ ] Both API namespaces autoload
- [ ] PHPUnit configured
