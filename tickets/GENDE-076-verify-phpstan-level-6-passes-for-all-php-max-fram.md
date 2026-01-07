---
code: GENDE-076
status: Proposed
dateCreated: 2026-01-07T15:57:10.171Z
type: Technical Debt
priority: Medium
relatedTickets: GENDE-070
---

# Verify PHPStan level 6 passes for all php-max frameworks

## 1. Description

Verify that PHPStan level 6 static analysis passes for all three php-max framework integration test projects. Fix any issues found.

## 2. Rationale

PHPStan level 6 ensures type safety and catches potential bugs before runtime. This was part of GENDE-070 acceptance criteria but split out for focused work.

## 3. Solution Analysis

Run PHPStan on each project and fix any errors:
- Laravel: `projects/laravel-api--laravel-max--integration-tests/`
- Symfony: `projects/symfony-api--symfony-max--integration-tests/`
- Slim: `projects/slim-api--slim-max--integration-tests/`

## 4. Implementation Specification

### Tasks
1. Run `make phpstan` in each project
2. Document any errors found
3. Fix errors (either in generated code templates or test project code)
4. Add `make phpstan-all` command to root Makefile

### Commands
```bash
cd projects/laravel-api--laravel-max--integration-tests && make phpstan
cd projects/symfony-api--symfony-max--integration-tests && make phpstan
cd projects/slim-api--slim-max--integration-tests && make phpstan
```

## 5. Acceptance Criteria

- [ ] Laravel PHPStan level 6: 0 errors
- [ ] Symfony PHPStan level 6: 0 errors
- [ ] Slim PHPStan level 6: 0 errors
- [ ] `make phpstan-all` command added to root Makefile