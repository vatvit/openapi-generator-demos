---
code: GENDE-075
status: Proposed
dateCreated: 2026-01-07T15:37:11.741Z
type: Technical Debt
priority: Low
relatedTickets: GENDE-070
---

# Investigate and fix 4 skipped tests in OpenAPI Generator fork

## 1. Description

During fork validation (GENDE-070 Phase 1), 4 tests were skipped in the openapi-generator module. These should be investigated and either fixed or documented why they are intentionally skipped.

### Test Results
| Module | Tests | Failures | Errors | Skipped |
|--------|-------|----------|--------|--------|
| openapi-generator-core | 22 | 0 | 0 | 0 |
| openapi-generator | 3606 | 0 | 0 | **4** |

### Fork Details
- Commit: `9df587cd7c6`
- Version: 7.19.0-SNAPSHOT

## 2. Rationale

Skipped tests may indicate:
- Incomplete functionality
- Platform-specific issues
- Intentionally disabled tests (with reason)
- Flaky tests that need stabilization

For a clean fork that we may contribute upstream, all tests should either pass or have documented reasons for being skipped.

## 3. Solution Analysis

### Approach
1. Identify which 4 tests are skipped
2. Determine why they are skipped (annotation, condition, etc.)
3. Either:
   - Fix the underlying issue and enable the tests
   - Document why they should remain skipped
   - Remove if obsolete

### Commands to Investigate
```bash
# Run tests with verbose output to identify skipped tests
mvn test -pl modules/openapi-generator -Dsurefire.printSummary=true 2>&1 | grep -i skip

# Or check for @Ignore, @Disabled annotations
grep -r "@Ignore\|@Disabled" modules/openapi-generator/src/test/
```

## 4. Implementation Specification

1. Run tests with verbose output to identify skipped test names
2. Locate test classes and find skip annotations/conditions
3. Analyze each skipped test:
   - Is it related to our changes? 
   - Is it a pre-existing skip from upstream?
   - Can it be fixed?
4. Take appropriate action per test

## 5. Acceptance Criteria

- [ ] All 4 skipped tests identified by name
- [ ] Root cause documented for each
- [ ] Tests either fixed or skip reason documented
- [ ] If upstream issue, link to upstream ticket/PR