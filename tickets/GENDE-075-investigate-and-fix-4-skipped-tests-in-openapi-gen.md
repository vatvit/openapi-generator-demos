---
code: GENDE-075
status: Implemented
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

### Investigation Results

**Root Cause Identified:**
The 4 skipped tests were all in `KotlinModelCodegenTest.java`, caused by:

1. **Bug Fixed:** `modelMutable()` test was declared as `private` instead of `public` (line 46)
   - TestNG silently skips private test methods
   - With 4 generators in DataProvider, this caused 4 skipped test runs
   - **Fixed:** Changed `private void modelMutable` to `public void modelMutable`

2. **Intentional Skips (Not Fixed - By Design):**
   - `xFieldExtraAnnotation()` uses `assumeThat(codegen.getSupportedVendorExtensions().contains(X_FIELD_EXTRA_ANNOTATION)).isTrue()`
   - `xClassExtraAnnotation()` uses `assumeThat(codegen.getSupportedVendorExtensions().contains(X_CLASS_EXTRA_ANNOTATION)).isTrue()`
   - These skip tests for generators that don't support these vendor extensions (intentional behavior)

### Other @Ignore Annotations Found (Pre-existing from Upstream)

1. `DefaultCodegenTest.testComposedPropertyTypes()` - @Ignore, no reason documented
2. `SpringCodegenTest.testMultipartCloud()` - @Ignore, no reason documented
3. `JetbrainsHttpClientClientCodegenTest.testBasicGenerationMultipleRequests()` - @Ignore with comment "For some reason this test fails during Docker image generation. Investigate one day."

These are pre-existing upstream issues, not related to our fork changes.

### Fix Applied
```java
// Before (line 46):
private void modelMutable(AbstractKotlinCodegen codegen) throws IOException {

// After:
public void modelMutable(AbstractKotlinCodegen codegen) throws IOException {
```

### Verification
```
mvn test -Dtest='KotlinModelCodegenTest#modelMutable' -pl modules/openapi-generator
Tests run: 4, Failures: 0, Errors: 0, Skipped: 0
```

### Status
- [x] Bug fixed: `modelMutable` test visibility changed from private to public
- [x] 4 intentional assumeThat skips documented (not bugs)
- [x] 3 pre-existing @Ignore annotations documented (upstream issues)