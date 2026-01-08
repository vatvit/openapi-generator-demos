---
code: GENDE-074
status: Implemented
dateCreated: 2026-01-07T10:50:22.967Z
type: Technical Debt
priority: Medium
relatedTickets: GENDE-064,GENDE-070
---

# Add unit tests for property constraint flags (GENDE-064)

## 1. Description

Add unit tests for the `enrichPropertyConstraints()` method added in GENDE-064. This method adds constraint presence flags to model properties but has no test coverage.

### Target File
`modules/openapi-generator/src/test/java/org/openapitools/codegen/DefaultCodegenTest.java`

## 2. Test Cases

### 2.1 Length Constraints

```java
@Test
public void testEnrichPropertyConstraints_hasMinLength() {
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = 5;
    codegen.enrichPropertyConstraints(prop);
    assertTrue((Boolean) prop.vendorExtensions.get("hasMinLength"));
}

@Test
public void testEnrichPropertyConstraints_hasMinLength_zero() {
    prop.minLength = 0; // 0 is a valid constraint
    // hasMinLength = true
}

@Test
public void testEnrichPropertyConstraints_hasMinLength_null() {
    prop.minLength = null;
    // hasMinLength = false
}

@Test
public void testEnrichPropertyConstraints_hasMaxLength() { ... }
```

### 2.2 Numeric Constraints

```java
@Test
public void testEnrichPropertyConstraints_hasMinimum() {
    prop.minimum = "0";
    // hasMinimum = true
}

@Test
public void testEnrichPropertyConstraints_hasMaximum() { ... }
```

### 2.3 Pattern Constraint

```java
@Test
public void testEnrichPropertyConstraints_hasPattern() {
    prop.pattern = "^[a-z]+$";
    // hasPattern = true
}

@Test
public void testEnrichPropertyConstraints_hasPattern_empty() {
    prop.pattern = "";
    // hasPattern = false (empty string is not a pattern)
}

@Test
public void testEnrichPropertyConstraints_hasPattern_null() {
    prop.pattern = null;
    // hasPattern = false
}
```

### 2.4 Array Constraints

```java
@Test
public void testEnrichPropertyConstraints_hasMinItems() { ... }

@Test
public void testEnrichPropertyConstraints_hasMaxItems() { ... }
```

### 2.5 Format Flags

```java
@Test
public void testEnrichPropertyConstraints_isUrl_url() {
    prop.dataFormat = "url";
    assertTrue((Boolean) prop.vendorExtensions.get("isUrl"));
}

@Test
public void testEnrichPropertyConstraints_isUrl_uri() {
    prop.dataFormat = "uri";
    assertTrue((Boolean) prop.vendorExtensions.get("isUrl"));
}

@Test
public void testEnrichPropertyConstraints_isDate() {
    prop.dataFormat = "date";
    // isDate = true
}

@Test
public void testEnrichPropertyConstraints_isDateTime() {
    prop.dataFormat = "date-time";
    // isDateTime = true
}

@Test
public void testEnrichPropertyConstraints_isEmail() {
    prop.dataFormat = "email";
    // isEmail = true
}

@Test
public void testEnrichPropertyConstraints_isUuid() {
    prop.dataFormat = "uuid";
    // isUuid = true
}
```

## 3. Acceptance Criteria
- [ ] Tests for hasMinLength, hasMaxLength (including 0 and null)
- [ ] Tests for hasMinimum, hasMaximum
- [ ] Tests for hasPattern (including empty string)
- [ ] Tests for hasMinItems, hasMaxItems
- [ ] Tests for all format flags (isUrl, isDate, isDateTime, isEmail, isUuid)
- [ ] All tests pass with `mvn test`

### Completed Tests (27 total)

**Test Infrastructure:**
- Extended `TestableDefaultCodegen` to expose `enrichPropertyConstraints()` method
- Added `createMinimalProperty()` helper method

**Length Constraint Tests (5 tests):**
1. `testEnrichPropertyConstraints_hasMinLength_withValue` - minLength=5
2. `testEnrichPropertyConstraints_hasMinLength_zero` - minLength=0 (valid constraint!)
3. `testEnrichPropertyConstraints_hasMinLength_null`
4. `testEnrichPropertyConstraints_hasMaxLength_withValue`
5. `testEnrichPropertyConstraints_hasMaxLength_null`

**Numeric Constraint Tests (4 tests):**
6. `testEnrichPropertyConstraints_hasMinimum_withValue`
7. `testEnrichPropertyConstraints_hasMinimum_null`
8. `testEnrichPropertyConstraints_hasMaximum_withValue`
9. `testEnrichPropertyConstraints_hasMaximum_null`

**Pattern Constraint Tests (3 tests):**
10. `testEnrichPropertyConstraints_hasPattern_withValue`
11. `testEnrichPropertyConstraints_hasPattern_empty` - empty string not valid
12. `testEnrichPropertyConstraints_hasPattern_null`

**Array Constraint Tests (5 tests):**
13. `testEnrichPropertyConstraints_hasMinItems_withValue`
14. `testEnrichPropertyConstraints_hasMinItems_zero` - minItems=0 (valid constraint!)
15. `testEnrichPropertyConstraints_hasMinItems_null`
16. `testEnrichPropertyConstraints_hasMaxItems_withValue`
17. `testEnrichPropertyConstraints_hasMaxItems_null`

**Format Flag Tests (10 tests via DataProvider):**
18-26. `testEnrichPropertyConstraints_formatFlags` (9 via DataProvider: url, uri, date, date-time, email, uuid, + 3 negative cases)
27. `testEnrichPropertyConstraints_nullFormat` - all flags false

### All tests pass:
```
mvn test -Dtest='DefaultCodegenTest' -pl modules/openapi-generator
Tests run: 222, Failures: 0, Errors: 0, Skipped: 0
BUILD SUCCESS
```

### Acceptance Criteria Status
- [x] Tests for hasMinLength, hasMaxLength (including 0 and null)
- [x] Tests for hasMinimum, hasMaximum
- [x] Tests for hasPattern (including empty string)
- [x] Tests for hasMinItems, hasMaxItems
- [x] Tests for all format flags (isUrl, isDate, isDateTime, isEmail, isUuid)
- [x] All tests pass with `mvn test`
## 4. Estimated Effort
~2 hours (18-22 test methods, ~180 lines)

### Functional Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-074-01 | When property has minLength set, the system SHALL set `vendorExtensions.hasMinLength` to true | Must |
| FR-074-02 | When property has minLength=0, the system SHALL set `vendorExtensions.hasMinLength` to true | Must |
| FR-074-03 | When property has minLength=null, the system SHALL set `vendorExtensions.hasMinLength` to false | Must |
| FR-074-04 | When property has maxLength set, the system SHALL set `vendorExtensions.hasMaxLength` to true | Must |
| FR-074-05 | When property has minimum set, the system SHALL set `vendorExtensions.hasMinimum` to true | Must |
| FR-074-06 | When property has maximum set, the system SHALL set `vendorExtensions.hasMaximum` to true | Must |
| FR-074-07 | When property has non-empty pattern, the system SHALL set `vendorExtensions.hasPattern` to true | Must |
| FR-074-08 | When property has empty pattern, the system SHALL set `vendorExtensions.hasPattern` to false | Must |
| FR-074-09 | When property has minItems set, the system SHALL set `vendorExtensions.hasMinItems` to true | Must |
| FR-074-10 | When property has maxItems set, the system SHALL set `vendorExtensions.hasMaxItems` to true | Must |
| FR-074-11 | When property format is "url" or "uri", the system SHALL set `vendorExtensions.isUrl` to true | Must |
| FR-074-12 | When property format is "date", the system SHALL set `vendorExtensions.isDate` to true | Must |
| FR-074-13 | When property format is "date-time", the system SHALL set `vendorExtensions.isDateTime` to true | Must |
| FR-074-14 | When property format is "email", the system SHALL set `vendorExtensions.isEmail` to true | Must |
| FR-074-15 | When property format is "uuid", the system SHALL set `vendorExtensions.isUuid` to true | Must |

### Non-Functional Requirements

| ID | Requirement | Metric |
|----|-------------|--------|
| NFR-074-01 | Tests SHALL cover boundary values (0, null, empty) | 100% boundary coverage |
| NFR-074-02 | Tests SHALL be grouped by constraint type | Logical test organization |
| NFR-074-03 | Test names SHALL indicate constraint and scenario | Self-documenting |

## 6. Code Fitness Assessment

### Target File Analysis

| Aspect | Assessment | Risk |
|--------|------------|------|
| **File** | `DefaultCodegenTest.java` | - |
| **Current Size** | ~4000 lines | Medium |
| **Test Framework** | TestNG | Low |
| **Existing Patterns** | Property-based tests exist | Low |
| **Setup Required** | Create CodegenProperty with various constraints | Low |

### Code Under Test

| Method | Location | Complexity | Testability |
|--------|----------|------------|-------------|
| `enrichPropertyConstraints()` | DefaultCodegen:794-830 | Low | High - pure function |

### Method Logic

```java
protected void enrichPropertyConstraints(CodegenProperty prop) {
    // Constraint presence flags
    prop.vendorExtensions.put("hasMinLength", prop.minLength != null);
    prop.vendorExtensions.put("hasMaxLength", prop.maxLength != null);
    prop.vendorExtensions.put("hasMinimum", prop.minimum != null);
    prop.vendorExtensions.put("hasMaximum", prop.maximum != null);
    prop.vendorExtensions.put("hasPattern", prop.pattern != null && !prop.pattern.isEmpty());
    prop.vendorExtensions.put("hasMinItems", prop.minItems != null);
    prop.vendorExtensions.put("hasMaxItems", prop.maxItems != null);

    // Format-based flags
    String fmt = prop.dataFormat;
    prop.vendorExtensions.put("isUrl", "url".equals(fmt) || "uri".equals(fmt));
    prop.vendorExtensions.put("isDate", "date".equals(fmt));
    prop.vendorExtensions.put("isDateTime", "date-time".equals(fmt));
    prop.vendorExtensions.put("isEmail", "email".equals(fmt));
    prop.vendorExtensions.put("isUuid", "uuid".equals(fmt));
}
```

### Risks

| Risk | Mitigation |
|------|------------|
| Many test cases | Use @DataProvider for format flags |
| Method is protected | Use subclass (same as GENDE-072) |
| Boundary value testing | Explicit tests for 0, null, empty string |

## 7. POC Validation
### Uncertain Decisions

| Decision | Options | Validation Approach |
|----------|---------|---------------------|
| Test organization | By constraint type vs alphabetical | **Decision: By type** - length, numeric, pattern, array, format |
| Data provider usage | Individual tests vs parameterized | **Decision: Both** - individual for constraints, parameterized for formats |
| Zero value handling | Test separately vs with other values | **Decision: Separate** - zero is special case (valid constraint) |

### POC: Constraint Flag Tests

```java
@Test
public void testEnrichPropertyConstraints_hasMinLength_withValue() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = 5;
    
    codegen.enrichPropertyConstraints(prop);
    
    assertTrue((Boolean) prop.vendorExtensions.get("hasMinLength"));
}

@Test
public void testEnrichPropertyConstraints_hasMinLength_zero() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = 0;  // Zero is valid constraint!
    
    codegen.enrichPropertyConstraints(prop);
    
    assertTrue((Boolean) prop.vendorExtensions.get("hasMinLength"),
        "minLength=0 is a valid constraint");
}

@Test
public void testEnrichPropertyConstraints_hasMinLength_null() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = null;
    
    codegen.enrichPropertyConstraints(prop);
    
    assertFalse((Boolean) prop.vendorExtensions.get("hasMinLength"));
}
```

**Validation:** Clear boundary value testing

### POC: Format Flags with DataProvider

```java
@DataProvider(name = "formatFlags")
public Object[][] formatFlags() {
    return new Object[][] {
        { "url", "isUrl", true },
        { "uri", "isUrl", true },
        { "date", "isDate", true },
        { "date-time", "isDateTime", true },
        { "email", "isEmail", true },
        { "uuid", "isUuid", true },
        { "unknown", "isUrl", false },
        { null, "isEmail", false },
    };
}

@Test(dataProvider = "formatFlags")
public void testEnrichPropertyConstraints_formatFlags(String format, String flag, boolean expected) {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.dataFormat = format;
    
    codegen.enrichPropertyConstraints(prop);
    
    assertEquals(expected, prop.vendorExtensions.get(flag));
}
```

**Validation:** Data-driven testing for format flags

| # | Task | Est. | Lines | Dependencies |
|---|------|------|-------|--------------|
| 1 | Reuse `TestableDefaultCodegen` from GENDE-072 (or add if not present) | 2m | 0-8 | GENDE-072 |
| 2 | Add `testEnrichPropertyConstraints_hasMinLength_withValue()` | 5m | 10 | 1 |
| 3 | Add `testEnrichPropertyConstraints_hasMinLength_zero()` | 5m | 10 | 1 |
| 4 | Add `testEnrichPropertyConstraints_hasMinLength_null()` | 5m | 10 | 1 |
| 5 | Add `testEnrichPropertyConstraints_hasMaxLength()` tests (3 variants) | 10m | 25 | 1 |
| 6 | Add `testEnrichPropertyConstraints_hasMinimum()` tests | 8m | 20 | 1 |
| 7 | Add `testEnrichPropertyConstraints_hasMaximum()` tests | 8m | 20 | 1 |
| 8 | Add `testEnrichPropertyConstraints_hasPattern_withValue()` | 5m | 10 | 1 |
| 9 | Add `testEnrichPropertyConstraints_hasPattern_empty()` | 5m | 10 | 1 |
| 10 | Add `testEnrichPropertyConstraints_hasPattern_null()` | 5m | 10 | 1 |
| 11 | Add `testEnrichPropertyConstraints_hasMinItems()` tests | 8m | 20 | 1 |
| 12 | Add `testEnrichPropertyConstraints_hasMaxItems()` tests | 8m | 20 | 1 |
| 13 | Add `@DataProvider` for format flags | 5m | 15 | - |
| 14 | Add `testEnrichPropertyConstraints_formatFlags()` parameterized test | 10m | 20 | 13 |
| 15 | Add `testEnrichPropertyConstraints_unknownFormat()` | 5m | 12 | 1 |
| 16 | Add `testEnrichPropertyConstraints_nullFormat()` | 5m | 12 | 1 |
| 17 | Run `mvn test -Dtest=DefaultCodegenTest` and fix failures | 10m | - | 2-16 |

**Total: ~1h 50m, ~220 lines**

### Task Details

#### Task 1: TestableDefaultCodegen Extension
```java
// Extend the class from GENDE-072 to also expose enrichPropertyConstraints
static class TestableDefaultCodegen extends DefaultCodegen {
    public void testEnrichOperation(CodegenOperation op) {
        enrichOperation(op);
    }
    
    public void testEnrichPropertyConstraints(CodegenProperty prop) {
        enrichPropertyConstraints(prop);
    }
}
```

#### Tasks 2-4: MinLength Boundary Tests
```java
@Test
public void testEnrichPropertyConstraints_hasMinLength_withValue() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = 5;
    
    codegen.testEnrichPropertyConstraints(prop);
    
    assertTrue((Boolean) prop.vendorExtensions.get("hasMinLength"));
}

@Test
public void testEnrichPropertyConstraints_hasMinLength_zero() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = 0;  // Zero is a VALID constraint!
    
    codegen.testEnrichPropertyConstraints(prop);
    
    assertTrue((Boolean) prop.vendorExtensions.get("hasMinLength"),
        "minLength=0 is a valid constraint and should set hasMinLength=true");
}

@Test
public void testEnrichPropertyConstraints_hasMinLength_null() {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.minLength = null;
    
    codegen.testEnrichPropertyConstraints(prop);
    
    assertFalse((Boolean) prop.vendorExtensions.get("hasMinLength"));
}
```

#### Task 13: Format Flags DataProvider
```java
@DataProvider(name = "formatFlags")
public Object[][] formatFlags() {
    return new Object[][] {
        // format, flag, expected
        { "url", "isUrl", true },
        { "uri", "isUrl", true },
        { "date", "isDate", true },
        { "date-time", "isDateTime", true },
        { "email", "isEmail", true },
        { "uuid", "isUuid", true },
        // Negative cases
        { "string", "isUrl", false },
        { "int32", "isDate", false },
    };
}
```

#### Task 14: Parameterized Format Test
```java
@Test(dataProvider = "formatFlags")
public void testEnrichPropertyConstraints_formatFlags(String format, String flag, boolean expected) {
    TestableDefaultCodegen codegen = new TestableDefaultCodegen();
    CodegenProperty prop = new CodegenProperty();
    prop.dataFormat = format;
    
    codegen.testEnrichPropertyConstraints(prop);
    
    assertEquals(expected, prop.vendorExtensions.get(flag),
        String.format("Format '%s' should set %s=%s", format, flag, expected));
}