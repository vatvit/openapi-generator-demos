---
code: GENDE-115
status: Proposed
dateCreated: 2026-01-07T16:41:34.594Z
type: Technical Debt
priority: Medium
phaseEpic: Phase 3: Symfony
relatedTickets: GENDE-088,GENDE-114
dependsOn: GENDE-114
---

# Verify Symfony PHPStan level 6 compliance

## 1. Description

Run PHPStan level 6 on all generated Symfony code and fix issues.

## 2. Rationale

Static analysis ensures type safety.

## 3. Solution Analysis

### Commands
```bash
make phpstan
```

## 4. Implementation Specification

Same approach as Laravel - fix templates or project code as needed.

## 5. Acceptance Criteria

- [ ] PHPStan level 6: 0 errors
- [ ] Generated code type-safe
- [ ] Test project type-safe