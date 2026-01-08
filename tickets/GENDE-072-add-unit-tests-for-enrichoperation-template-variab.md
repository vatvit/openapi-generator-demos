---
code: GENDE-072
status: Implemented
dateCreated: 2026-01-07T10:50:22.068Z
type: Technical Debt
priority: Medium
relatedTickets: GENDE-062,GENDE-070
---

# Add unit tests for enrichOperation template variables (GENDE-062)

## 1. Description

Add unit tests for the `enrichOperation()` method added in GENDE-062. This method adds template variables to `vendorExtensions` but has no test coverage.

### Target File
`modules/openapi-generator/src/test/java/org/openapitools/codegen/DefaultCodegenTest.java`

## 2. Test Cases

### 2.1 Naming Variations

```java
@Test
public void testEnrichOperation_operationIdPascalCase() {
    CodegenOperation op = new CodegenOperation();
    op.operationId = "createPet";
    codegen.enrichOperation(op);
    assertEquals("CreatePet", op.vendorExtensions.get("operationIdPascalCase"));
}

@Test
public void testEnrichOperation_operationIdCamelCase() {
    // createPet -> createPet (unchanged)
    // create_pet -> createPet
}
```

### 2.2 Parameter Presence Flags

```java
@Test
public void testEnrichOperation_hasPathParams_true() {
    op.pathParams = List.of(new CodegenParameter());
    // hasPathParams = true
}

@Test
public void testEnrichOperation_hasPathParams_false() {
    op.pathParams = Collections.emptyList();
    // hasPathParams = false
}

@Test
public void testEnrichOperation_hasQueryParams() { ... }

@Test
public void testEnrichOperation_hasBodyParam() { ... }

@Test
public void testEnrichOperation_hasFormParams() { ... }

@Test
public void testEnrichOperation_hasHeaderParams() { ... }
```

### 2.3 HTTP Method Flags

```java
@Test
public void testEnrichOperation_isGet() {
    op.httpMethod = "GET";
    // isGet = true, isPost = false, etc.
}

@Test
public void testEnrichOperation_isPost() { ... }

@Test
public void testEnrichOperation_isPut() { ... }

@Test
public void testEnrichOperation_isPatch() { ... }

@Test
public void testEnrichOperation_isDelete() { ... }
```

### 2.4 Edge Cases

```java
@Test
public void testEnrichOperation_nullPathParams() {
    op.pathParams = null;
    // Should not throw NPE, hasPathParams = false
}

@Test
public void testEnrichOperation_caseInsensitiveHttpMethod() {
    op.httpMethod = "get"; // lowercase
    // isGet = true
}
```

## 3. Acceptance Criteria
- [ ] Tests for operationIdPascalCase, operationIdCamelCase
- [ ] Tests for all 5 parameter presence flags
- [ ] Tests for all 5 HTTP method flags
- [ ] Tests for null/empty edge cases
- [ ] All tests pass with `mvn test`

### Completed Tests (21 total)

**Test Infrastructure:**
- Added `TestableDefaultCodegen` inner class to expose protected `enrichOperation()` method
- Added `createMinimalOperation()` helper method to create test fixtures

**Naming Variations Tests (4 tests):**
1. `testEnrichOperation_operationIdPascalCase` - createPet → CreatePet
2. `testEnrichOperation_operationIdPascalCase_snakeCase` - create_pet → CreatePet
3. `testEnrichOperation_operationIdCamelCase` - CreatePet → createPet
4. `testEnrichOperation_operationIdCamelCase_snakeCase` - create_pet → createPet

**Parameter Presence Flag Tests (10 tests):**
5. `testEnrichOperation_hasPathParams_true`
6. `testEnrichOperation_hasPathParams_false`
7. `testEnrichOperation_hasPathParams_null` - null safety test
8. `testEnrichOperation_hasQueryParams_true`
9. `testEnrichOperation_hasQueryParams_false`
10. `testEnrichOperation_hasBodyParam_true`
11. `testEnrichOperation_hasBodyParam_false`
12. `testEnrichOperation_hasFormParams_true`
13. `testEnrichOperation_hasFormParams_false`
14. `testEnrichOperation_hasHeaderParams_true`
15. `testEnrichOperation_hasHeaderParams_false`

**HTTP Method Flag Tests (6 tests):**
16. `testEnrichOperation_isGet` - verifies all 5 flags
17. `testEnrichOperation_isPost` - verifies all 5 flags
18. `testEnrichOperation_isPut` - verifies all 5 flags
19. `testEnrichOperation_isPatch` - verifies all 5 flags
20. `testEnrichOperation_isDelete` - verifies all 5 flags
21. `testEnrichOperation_httpMethodCaseInsensitive` - "get" → isGet=true

### All tests pass:
```
mvn test -Dtest='DefaultCodegenTest' -pl modules/openapi-generator
Tests run: 182, Failures: 0, Errors: 0, Skipped: 0
BUILD SUCCESS
```

### Acceptance Criteria Status
- [x] Tests for operationIdPascalCase, operationIdCamelCase
- [x] Tests for all 5 parameter presence flags (hasPathParams, hasQueryParams, hasBodyParam, hasFormParams, hasHeaderParams)
- [x] Tests for all 5 HTTP method flags (isGet, isPost, isPut, isPatch, isDelete)
- [x] Tests for null/empty edge cases (pathParams null test)
- [x] All tests pass with `mvn test`
## 4. Estimated Effort
~2 hours (15-18 test methods, ~150 lines)

### Functional Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-072-01 | When `enrichOperation()` is called, the system SHALL set `vendorExtensions.operationIdPascalCase` to PascalCase operationId | Must |
| FR-072-02 | When `enrichOperation()` is called, the system SHALL set `vendorExtensions.operationIdCamelCase` to camelCase operationId | Must |
| FR-072-03 | When operation has path parameters, the system SHALL set `vendorExtensions.hasPathParams` to true | Must |
| FR-072-04 | When operation has no path parameters, the system SHALL set `vendorExtensions.hasPathParams` to false | Must |
| FR-072-05 | When operation has query parameters, the system SHALL set `vendorExtensions.hasQueryParams` to true | Must |
| FR-072-06 | When operation has body parameter, the system SHALL set `vendorExtensions.hasBodyParam` to true | Must |
| FR-072-07 | When operation has form parameters, the system SHALL set `vendorExtensions.hasFormParams` to true | Must |
| FR-072-08 | When operation has header parameters, the system SHALL set `vendorExtensions.hasHeaderParams` to true | Must |
| FR-072-09 | When HTTP method is GET, the system SHALL set `vendorExtensions.isGet` to true | Must |
| FR-072-10 | When HTTP method is POST, the system SHALL set `vendorExtensions.isPost` to true | Must |
| FR-072-11 | When HTTP method is PUT, the system SHALL set `vendorExtensions.isPut` to true | Must |
| FR-072-12 | When HTTP method is PATCH, the system SHALL set `vendorExtensions.isPatch` to true | Must |
| FR-072-13 | When HTTP method is DELETE, the system SHALL set `vendorExtensions.isDelete` to true | Must |
| FR-072-14 | When pathParams is null, the system SHALL NOT throw NPE and SHALL set hasPathParams to false | Must |

### Non-Functional Requirements

| ID | Requirement | Metric |
|----|-------------|--------|
| NFR-072-01 | Tests SHALL be independent (no shared state) | Each test self-contained |
| NFR-072-02 | Tests SHALL cover edge cases (null, empty) | 100% branch coverage |
| NFR-072-03 | Test method names SHALL be descriptive | Pattern: `test{Method}_{scenario}_{expected}` |

## 6. Code Fitness Assessment

### Target File Analysis

| Aspect | Assessment | Risk |
|--------|------------|------|
| **File** | `DefaultCodegenTest.java` | - |
| **Current Size** | ~4000 lines | Medium - very large file |
| **Test Framework** | TestNG | Low - familiar |
| **Existing Patterns** | Direct method calls on DefaultCodegen instance | Low |
| **Setup Required** | Create CodegenOperation with various states | Low |

### Code Under Test

| Method | Location | Complexity | Testability |
|--------|----------|------------|-------------|
| `enrichOperation()` | DefaultCodegen:1020-1055 | Low | High - pure function |
| `camelize()` utility | StringUtils | Low | Already tested |

### Method Signature

```java
protected void enrichOperation(CodegenOperation op) {
    // Naming variations
    op.vendorExtensions.put("operationIdPascalCase", camelize(op.operationId));
    op.vendorExtensions.put("operationIdCamelCase", camelize(op.operationId, LOWERCASE_FIRST_LETTER));
    // ... flags
}
```

### Risks

| Risk | Mitigation |
|------|------------|
| Method is protected | Use subclass or reflection, or test via public API |
| Large test file | Group tests by category (naming, params, http methods) |
| Null handling | Explicitly test null scenarios |

## 7. POC Validation
### Uncertain Decisions

| Decision | Options | Validation Approach |
|----------|---------|---------------------|
| Access protected method | Subclass / Reflection / Public API | **Decision: Subclass** - create TestableDefaultCodegen |
| Test organization | Single test class vs multiple | **Decision: Single** - follow existing pattern |
| Null safety testing | Separate tests vs combined | **Decision: Separate** - one test per null scenario |

### POC: Testable Subclass

```java
// In test file
static class TestableDefaultCodegen extends DefaultCodegen {
    @Override
    public void enrichOperation(CodegenOperation op) {
        super.enrichOperation(op);
    }
}
```

**Validation:** Allows direct testing of protected method

### POC: Parameter Flag Test

```java
@Test
public void testEnrichOperation_hasBodyParam_true() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenOperation op = new CodegenOperation();
    op.operationId = "createPet";
    op.httpMethod = "POST";
    op.bodyParam = new CodegenParameter();
    
    codegen.enrichOperation(op);
    
    assertTrue((Boolean) op.vendorExtensions.get("hasBodyParam"));
}

@Test
public void testEnrichOperation_hasBodyParam_false() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenOperation op = new CodegenOperation();
    op.operationId = "listPets";
    op.httpMethod = "GET";
    op.bodyParam = null;
    
    codegen.enrichOperation(op);
    
    assertFalse((Boolean) op.vendorExtensions.get("hasBodyParam"));
}
```

**Validation:** Simple, focused tests

| # | Task | Est. | Lines | Dependencies |
|---|------|------|-------|--------------|
| 1 | Add `TestableDefaultCodegen` inner class to expose protected method | 5m | 8 | - |
| 2 | Add `testEnrichOperation_operationIdPascalCase()` | 5m | 10 | 1 |
| 3 | Add `testEnrichOperation_operationIdCamelCase()` | 5m | 10 | 1 |
| 4 | Add `testEnrichOperation_hasPathParams_true()` | 5m | 10 | 1 |
| 5 | Add `testEnrichOperation_hasPathParams_false()` | 5m | 10 | 1 |
| 6 | Add `testEnrichOperation_hasPathParams_null()` | 5m | 10 | 1 |
| 7 | Add `testEnrichOperation_hasQueryParams_true()` | 5m | 10 | 1 |
| 8 | Add `testEnrichOperation_hasQueryParams_false()` | 5m | 10 | 1 |
| 9 | Add `testEnrichOperation_hasBodyParam_true()` | 5m | 10 | 1 |
| 10 | Add `testEnrichOperation_hasBodyParam_false()` | 5m | 10 | 1 |
| 11 | Add `testEnrichOperation_hasFormParams_true()` | 5m | 10 | 1 |
| 12 | Add `testEnrichOperation_hasHeaderParams_true()` | 5m | 10 | 1 |
| 13 | Add `testEnrichOperation_isGet()` | 5m | 12 | 1 |
| 14 | Add `testEnrichOperation_isPost()` | 5m | 12 | 1 |
| 15 | Add `testEnrichOperation_isPut()` | 5m | 12 | 1 |
| 16 | Add `testEnrichOperation_isPatch()` | 5m | 12 | 1 |
| 17 | Add `testEnrichOperation_isDelete()` | 5m | 12 | 1 |
| 18 | Add `testEnrichOperation_httpMethodCaseInsensitive()` | 5m | 12 | 1 |
| 19 | Run `mvn test -Dtest=DefaultCodegenTest` and fix failures | 10m | - | 2-18 |

**Total: ~1h 40m, ~170 lines**

### Task Details

#### Task 1: Testable Subclass
```java
// Add at the end of DefaultCodegenTest class
static class TestableDefaultCodegen extends DefaultCodegen {
    public void testEnrichOperation(CodegenOperation op) {
        enrichOperation(op);
    }
}
```

#### Tasks 2-3: Naming Variations
```java
@Test
public void testEnrichOperation_operationIdPascalCase() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenOperation op = new CodegenOperation();
    op.operationId = "createPet";
    op.httpMethod = "POST";
    op.pathParams = new ArrayList<>();
    
    codegen.testEnrichOperation(op);
    
    assertEquals("CreatePet", op.vendorExtensions.get("operationIdPascalCase"));
}

@Test
public void testEnrichOperation_operationIdCamelCase() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenOperation op = new CodegenOperation();
    op.operationId = "create_pet";  // snake_case input
    op.httpMethod = "POST";
    op.pathParams = new ArrayList<>();
    
    codegen.testEnrichOperation(op);
    
    assertEquals("createPet", op.vendorExtensions.get("operationIdCamelCase"));
}
```

#### Tasks 13-17: HTTP Method Pattern
```java
@Test
public void testEnrichOperation_isGet() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenOperation op = createMinimalOperation("listPets", "GET");
    
    codegen.testEnrichOperation(op);
    
    assertTrue((Boolean) op.vendorExtensions.get("isGet"));
    assertFalse((Boolean) op.vendorExtensions.get("isPost"));
    assertFalse((Boolean) op.vendorExtensions.get("isPut"));
    assertFalse((Boolean) op.vendorExtensions.get("isPatch"));
    assertFalse((Boolean) op.vendorExtensions.get("isDelete"));
}

// Helper method
private CodegenOperation createMinimalOperation(String operationId, String httpMethod) {
    CodegenOperation op = new CodegenOperation();
    op.operationId = operationId;
    op.httpMethod = httpMethod;
    op.pathParams = new ArrayList<>();
    op.queryParams = new ArrayList<>();
    op.formParams = new ArrayList<>();
    op.headerParams = new ArrayList<>();
    return op;
}