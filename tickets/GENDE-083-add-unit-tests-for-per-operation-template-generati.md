---
code: GENDE-083
status: Proposed
dateCreated: 2026-01-07T16:06:26.418Z
type: Technical Debt
priority: High
phaseEpic: Phase 3: Requirements
relatedTickets: GENDE-078,GENDE-082,GENDE-071,GENDE-072,GENDE-073,GENDE-074
dependsOn: GENDE-082
---

# Add unit tests for per-operation template generation

## 1. Description

Add comprehensive unit tests for the per-operation template generation feature as required by CONTRIBUTING.md.

## 2. Rationale

Per CONTRIBUTING.md:
> "Add test cases: Add a test file in `modules/openapi-generator/src/test/java/org/openapitools/codegen`"

Tests are required for PR acceptance.

## 3. Solution Analysis

### Test Coverage Needed

| Component | Test File | Priority |
|-----------|-----------|----------|
| TemplateFileType.Operation enum | `TemplateFileTypeTest.java` | High |
| Per-operation loop in DefaultGenerator | `DefaultGeneratorTest.java` | High |
| enrichOperation template variables | `DefaultCodegenTest.java` | Medium |
| Empty file cleanup | `DefaultGeneratorTest.java` | Medium |
| Property constraint flags | `DefaultCodegenTest.java` | Medium |

### Related Tickets (Unit Test Details)
- GENDE-071: Per-operation processing loop tests
- GENDE-072: enrichOperation template variables tests
- GENDE-073: Empty file cleanup tests
- GENDE-074: Property constraint flags tests

## 4. Implementation Specification

### Test Location
```
modules/openapi-generator/src/test/java/org/openapitools/codegen/
├── TemplateFileTypeTest.java      (new or extend)
├── DefaultGeneratorTest.java      (extend)
└── DefaultCodegenTest.java        (extend)
```

### Test Cases

#### TemplateFileType Tests
```java
@Test
public void testOperationTemplateType() {
    assertEquals("Operation", TemplateFileType.Operation.name());
}
```

#### Per-Operation Generation Tests
```java
@Test
public void testPerOperationFileGeneration() {
    // Configure template with templateType: Operation
    // Generate code
    // Verify one file per operation created
}
```

## 5. Acceptance Criteria

- [ ] TemplateFileType.Operation has tests
- [ ] Per-operation loop logic has tests
- [ ] Template variable enrichment has tests
- [ ] Empty file cleanup has tests
- [ ] All tests pass: `mvn test -pl modules/openapi-generator`