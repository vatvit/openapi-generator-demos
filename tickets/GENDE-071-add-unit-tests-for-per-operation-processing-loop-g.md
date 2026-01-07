---
code: GENDE-071
status: Proposed
dateCreated: 2026-01-07T10:50:21.592Z
type: Technical Debt
priority: Medium
relatedTickets: GENDE-061,GENDE-070
---

# Add unit tests for per-operation processing loop (GENDE-061)

## 1. Description

Add unit tests for the per-operation processing loop added in GENDE-061. The implementation in `DefaultGenerator.java` currently has no test coverage.

### Target File
`modules/openapi-generator/src/test/java/org/openapitools/codegen/DefaultGeneratorTest.java`

## 2. Test Cases

### 2.1 operationTemplateFiles Registration

```java
@Test
public void testOperationTemplateFilesRegistration() {
    // Verify Operation type in files config registers to operationTemplateFiles map
}
```

### 2.2 Per-Operation File Generation

```java
@Test
public void testPerOperationFileGeneration() {
    // Given: spec with 3 operations, template with templateType: Operation
    // When: generate()
    // Then: 3 files created (one per operation)
}
```

### 2.3 Filename Variable Resolution

```java
@Test
public void testResolveOperationFilename_operationId() {
    // {{operationId}} -> createPet
}

@Test
public void testResolveOperationFilename_operationIdPascalCase() {
    // {{operationIdPascalCase}} -> CreatePet
}

@Test
public void testResolveOperationFilename_httpMethod() {
    // {{httpMethod}} -> POST, {{httpMethodLower}} -> post
}
```

### 2.4 Empty operationTemplateFiles

```java
@Test
public void testEmptyOperationTemplateFiles_noFilesGenerated() {
    // When operationTemplateFiles is empty, loop should not execute
}
```

## 3. Acceptance Criteria

- [ ] Test for Operation type registration in switch statement
- [ ] Test for per-operation loop generating correct number of files
- [ ] Tests for each filename variable (operationId, operationIdPascalCase, etc.)
- [ ] Test for empty operationTemplateFiles (no-op)
- [ ] All tests pass with `mvn test`

## 4. Estimated Effort
~2 hours (6-8 test methods, ~100 lines)

### Functional Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-071-01 | When `templateType: Operation` is specified in files config, the system SHALL register the template in `operationTemplateFiles` map | Must |
| FR-071-02 | When `operationTemplateFiles` is not empty, the system SHALL generate one file per operation in the spec | Must |
| FR-071-03 | When `{{operationId}}` is used in destinationFilename, the system SHALL replace it with the operation's operationId | Must |
| FR-071-04 | When `{{operationIdPascalCase}}` is used in destinationFilename, the system SHALL replace it with PascalCase operationId | Must |
| FR-071-05 | When `{{httpMethod}}` is used in destinationFilename, the system SHALL replace it with uppercase HTTP method | Must |
| FR-071-06 | When `{{httpMethodLower}}` is used in destinationFilename, the system SHALL replace it with lowercase HTTP method | Must |
| FR-071-07 | When `operationTemplateFiles` is empty, the system SHALL NOT execute the per-operation loop | Must |

### Non-Functional Requirements

| ID | Requirement | Metric |
|----|-------------|--------|
| NFR-071-01 | Tests SHALL complete within Maven test timeout | < 60s per test |
| NFR-071-02 | Tests SHALL be deterministic (no flaky tests) | 100% reproducible |
| NFR-071-03 | Tests SHALL follow existing OpenAPI Generator test patterns | Code review pass |

## 6. Code Fitness Assessment

### Target File Analysis

| Aspect | Assessment | Risk |
|--------|------------|------|
| **File** | `DefaultGeneratorTest.java` | - |
| **Current Size** | ~2500 lines | Medium - large file |
| **Test Framework** | TestNG | Low - familiar |
| **Existing Patterns** | Uses `CodegenConfigurator`, temp directories | Low - follow existing |
| **Dependencies** | Need mock spec with multiple operations | Low |

### Code Under Test

| Method | Location | Complexity | Testability |
|--------|----------|------------|-------------|
| `resolveOperationFilename()` | DefaultGenerator:1466 | Low | High - pure function |
| Per-operation loop | DefaultGenerator:819-856 | Medium | Medium - needs integration test |
| Switch case `Operation` | DefaultGenerator:1439-1441 | Low | High - unit testable |

### Risks

| Risk | Mitigation |
|------|------------|
| Large test file | Add tests in logical grouping with clear naming |
| Integration test complexity | Use minimal spec with 2-3 operations |
| Temp file cleanup | Use `@AfterMethod` cleanup |

## 7. POC Validation
### Uncertain Decisions

| Decision | Options | Validation Approach |
|----------|---------|---------------------|
| Test isolation | Unit vs Integration | **Decision: Both** - unit for `resolveOperationFilename()`, integration for full loop |
| Mock spec creation | Inline YAML vs file | **Decision: File** - use existing test resources pattern |
| Assertion style | Count files vs verify names | **Decision: Both** - count AND verify specific filenames |

### POC: Minimal Test Spec

```yaml

| # | Task | Est. | Lines | Dependencies |
|---|------|------|-------|--------------|
| 1 | Create test spec file `src/test/resources/3_0/per-operation-test.yaml` with 3 operations | 10m | 25 | - |
| 2 | Add `testResolveOperationFilename_operationId()` unit test | 10m | 15 | - |
| 3 | Add `testResolveOperationFilename_operationIdPascalCase()` unit test | 5m | 12 | - |
| 4 | Add `testResolveOperationFilename_httpMethod()` unit test | 5m | 12 | - |
| 5 | Add `testResolveOperationFilename_httpMethodLower()` unit test | 5m | 12 | - |
| 6 | Add `testOperationTemplateFilesRegistration()` - verify switch case | 15m | 20 | 1 |
| 7 | Add `testPerOperationFileGeneration()` - integration test with 3 ops → 3 files | 25m | 40 | 1 |
| 8 | Add `testEmptyOperationTemplateFiles_noFilesGenerated()` | 10m | 15 | - |
| 9 | Run `mvn test -Dtest=DefaultGeneratorTest` and fix any failures | 15m | - | 2-8 |

**Total: ~1h 40m, ~150 lines**

### Task Details

#### Task 1: Create Test Spec
```yaml
# src/test/resources/3_0/per-operation-test.yaml
openapi: "3.0.0"
info:
  title: Per-Operation Test
  version: "1.0"
paths:
  /pets:
    get:
      operationId: listPets
      responses: { '200': { description: OK } }
    post:
      operationId: createPet
      responses: { '201': { description: Created } }
  /pets/{id}:
    delete:
      operationId: deletePet
      parameters:
        - name: id
          in: path
          required: true
          schema: { type: string }
      responses: { '204': { description: Deleted } }
```

#### Task 7: Integration Test Structure
```java
@Test
public void testPerOperationFileGeneration() throws IOException {
    // Setup
    File output = Files.createTempDirectory("per-op-test").toFile();
    CodegenConfigurator configurator = new CodegenConfigurator()
        .setGeneratorName("java")
        .setInputSpec("src/test/resources/3_0/per-operation-test.yaml")
        .setOutputDir(output.getAbsolutePath());
    // Add operation template config...
    
    // Generate
    List<File> files = new DefaultGenerator()
        .opts(configurator.toClientOptInput())
        .generate();
    
    // Assert: 3 operations → 3 controller files
    List<File> controllers = files.stream()
        .filter(f -> f.getName().endsWith("Controller.java"))
        .collect(Collectors.toList());
    assertEquals(3, controllers.size());
    assertTrue(controllers.stream().anyMatch(f -> f.getName().equals("ListPetsController.java")));
    assertTrue(controllers.stream().anyMatch(f -> f.getName().equals("CreatePetController.java")));
    assertTrue(controllers.stream().anyMatch(f -> f.getName().equals("DeletePetController.java")));
}
# src/test/resources/3_0/per-operation-test.yaml
openapi: "3.0.0"
info:
  title: Per-Operation Test
  version: "1.0"
paths:
  /pets:
    get:
      operationId: listPets
      responses:
        '200':
          description: OK
    post:
      operationId: createPet
      responses:
        '201':
          description: Created
  /pets/{id}:
    delete:
      operationId: deletePet
      responses:
        '204':
          description: Deleted
```

**Validation:** 3 operations → 3 files generated

### POC: resolveOperationFilename Unit Test

```java
@Test
public void testResolveOperationFilename_allVariables() {
    CodegenOperation op = new CodegenOperation();
    op.operationId = "createPet";
    op.httpMethod = "POST";
    
    String result = generator.resolveOperationFilename(
        "controller.mustache",
        "{{operationIdPascalCase}}Controller.php",
        op,
        "/output"
    );
    
    assertEquals("/output/CreatePetController.php", result);
}
```

**Validation:** Pure function, easy to test in isolation