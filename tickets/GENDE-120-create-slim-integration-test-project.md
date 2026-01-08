---
code: GENDE-120
status: Implemented
dateCreated: 2026-01-07T16:42:24.542Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 4: Slim
relatedTickets: GENDE-088,GENDE-119
dependsOn: GENDE-119
---

# Create Slim integration test project

## 1. Description

Create the Slim integration test project.

## 2. Rationale

Test project verifies generated Slim code works.

## 3. Solution Analysis

### Project Structure
```
projects/slim-api--{generator-name}--integration-tests/
├── src/
│   └── Handler/
├── tests/
├── public/
│   └── index.php
├── composer.json
├── phpunit.xml
├── phpstan.neon
└── Makefile
```

## 4. Implementation Specification

### Slim Version
Target: Slim 4.x

### Dependencies
- slim/slim
- slim/psr7
- php-di/php-di
- phpunit/phpunit

## 5. Acceptance Criteria

- [ ] Slim project created
- [ ] Generated libs integrated
- [ ] PHPUnit configured
- [ ] Docker environment ready