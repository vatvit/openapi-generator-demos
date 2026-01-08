---
code: GENDE-073
status: Implemented
dateCreated: 2026-01-07T10:50:22.466Z
type: Technical Debt
priority: Medium
relatedTickets: GENDE-063,GENDE-070
---

# Add unit tests for empty file cleanup in postProcessFile (GENDE-063)

## 1. Description

Add unit tests for the empty file cleanup logic added to `postProcessFile()` in GENDE-063. This feature deletes files containing only whitespace.

### Target File
`modules/openapi-generator/src/test/java/org/openapitools/codegen/DefaultCodegenTest.java`

## 2. Test Cases

### 2.1 Empty File Deletion

```java
@Test
public void testPostProcessFile_deletesEmptyFile() throws IOException {
    File tempFile = File.createTempFile("test", ".php");
    Files.writeString(tempFile.toPath(), "");
    
    codegen.postProcessFile(tempFile, "operation");
    
    assertFalse(tempFile.exists(), "Empty file should be deleted");
}

@Test
public void testPostProcessFile_deletesWhitespaceOnlyFile() throws IOException {
    File tempFile = File.createTempFile("test", ".php");
    Files.writeString(tempFile.toPath(), "   \n\t\n   ");
    
    codegen.postProcessFile(tempFile, "operation");
    
    assertFalse(tempFile.exists(), "Whitespace-only file should be deleted");
}
```

### 2.2 Non-Empty File Preservation

```java
@Test
public void testPostProcessFile_preservesNonEmptyFile() throws IOException {
    File tempFile = File.createTempFile("test", ".php");
    Files.writeString(tempFile.toPath(), "<?php\nclass Foo {}");
    
    codegen.postProcessFile(tempFile, "operation");
    
    assertTrue(tempFile.exists(), "Non-empty file should be preserved");
}

@Test
public void testPostProcessFile_preservesFileWithOnlyComment() throws IOException {
    File tempFile = File.createTempFile("test", ".php");
    Files.writeString(tempFile.toPath(), "// comment");
    
    codegen.postProcessFile(tempFile, "operation");
    
    assertTrue(tempFile.exists(), "File with comment should be preserved");
}
```

### 2.3 Edge Cases

```java
@Test
public void testPostProcessFile_nullFile() {
    // Should not throw exception
    codegen.postProcessFile(null, "operation");
}

@Test
public void testPostProcessFile_nonExistentFile() {
    File nonExistent = new File("/tmp/does-not-exist-12345.php");
    // Should not throw exception
    codegen.postProcessFile(nonExistent, "operation");
}
```

## 3. Acceptance Criteria
- [ ] Test empty file (0 bytes) is deleted
- [ ] Test whitespace-only file is deleted
- [ ] Test non-empty file is preserved
- [ ] Test null file handling (no exception)
- [ ] Test non-existent file handling (no exception)
- [ ] All tests pass with `mvn test`

### Completed Tests (13 total)

**DataProvider for Whitespace Variations:**
- 7 test cases: empty, single space, multiple spaces, newline, tab, windows newline, mixed whitespace

**Empty File Deletion Tests (8 tests):**
1. `testPostProcessFile_deletesEmptyFile` - 0 bytes file
2-8. `testPostProcessFile_deletesWhitespaceOnly` (7 via DataProvider) - all whitespace variations

**Non-Empty File Preservation Tests (3 tests):**
9. `testPostProcessFile_preservesNonEmptyFile` - PHP class content
10. `testPostProcessFile_preservesFileWithComment` - single comment line
11. `testPostProcessFile_preservesFileWithOnlyNonWhitespaceChar` - single character "a"

**Edge Case Tests (2 tests):**
12. `testPostProcessFile_nullFile` - null safety
13. `testPostProcessFile_nonExistentFile` - non-existent file handling

### All tests pass:
```
mvn test -Dtest='DefaultCodegenTest' -pl modules/openapi-generator
Tests run: 195, Failures: 0, Errors: 0, Skipped: 0
BUILD SUCCESS
```

### Acceptance Criteria Status
- [x] Test empty file (0 bytes) is deleted
- [x] Test whitespace-only file is deleted (7 variations)
- [x] Test non-empty file is preserved
- [x] Test null file handling (no exception)
- [x] Test non-existent file handling (no exception)
- [x] All tests pass with `mvn test`
## 4. Estimated Effort
~1 hour (6-8 test methods, ~80 lines)

### Functional Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-073-01 | When file content is empty (0 bytes), the system SHALL delete the file | Must |
| FR-073-02 | When file content is whitespace only (spaces, tabs, newlines), the system SHALL delete the file | Must |
| FR-073-03 | When file content has any non-whitespace character, the system SHALL preserve the file | Must |
| FR-073-04 | When file parameter is null, the system SHALL NOT throw exception | Must |
| FR-073-05 | When file does not exist, the system SHALL NOT throw exception | Must |
| FR-073-06 | When file deletion fails, the system SHALL log warning and continue | Should |

### Non-Functional Requirements

| ID | Requirement | Metric |
|----|-------------|--------|
| NFR-073-01 | Tests SHALL clean up temp files after execution | No orphan files |
| NFR-073-02 | Tests SHALL not depend on filesystem state | Isolated temp directories |
| NFR-073-03 | Tests SHALL work on all platforms (Linux, macOS, Windows) | CI green on all |

## 6. Code Fitness Assessment

### Target File Analysis

| Aspect | Assessment | Risk |
|--------|------------|------|
| **File** | `DefaultCodegenTest.java` | - |
| **Current Size** | ~4000 lines | Medium |
| **Test Framework** | TestNG | Low |
| **Existing Patterns** | File I/O tests exist | Low - follow existing |
| **Setup Required** | Create temp files with various contents | Low |

### Code Under Test

| Method | Location | Complexity | Testability |
|--------|----------|------------|-------------|
| `postProcessFile()` | DefaultCodegen:8408-8427 | Low | High |

### Method Logic

```java
public void postProcessFile(File file, String fileType) {
    if (file == null || !file.exists()) return;
    
    try {
        String content = Files.readString(file.toPath());
        if (content.trim().isEmpty()) {
            file.delete();
            LOGGER.info("Deleted empty file: {}", file.getPath());
        }
    } catch (IOException e) {
        LOGGER.warn("Could not check file: {}", file.getPath());
    }
}
```

### Risks

| Risk | Mitigation |
|------|------------|
| Temp file cleanup | Use `@AfterMethod` with try-finally |
| Platform differences | Use `File.createTempFile()` for portability |
| File permissions | Skip permission tests (platform-specific) |

## 7. POC Validation
### Uncertain Decisions

| Decision | Options | Validation Approach |
|----------|---------|---------------------|
| Temp file location | System temp vs project temp | **Decision: System temp** - `File.createTempFile()` |
| Cleanup strategy | Manual vs @AfterMethod | **Decision: Both** - delete in test + @AfterMethod safety net |
| Test file permissions failure | Test vs skip | **Decision: Skip** - too platform-specific |

### POC: Empty File Test

```java
@Test
public void testPostProcessFile_deletesEmptyFile() throws IOException {
    DefaultCodegen codegen = new DefaultCodegen();
    File tempFile = File.createTempFile("test-empty", ".php");
    try {
        // Write empty content
        Files.writeString(tempFile.toPath(), "");
        assertTrue(tempFile.exists(), "Precondition: file exists");
        
        // Act
        codegen.postProcessFile(tempFile, "operation");
        
        // Assert
        assertFalse(tempFile.exists(), "Empty file should be deleted");
    } finally {
        // Cleanup safety net
        if (tempFile.exists()) tempFile.delete();
    }
}
```

**Validation:** Works on all platforms, proper cleanup

### POC: Whitespace Variations

```java
@DataProvider(name = "whitespaceContent")
public Object[][] whitespaceContent() {
    return new Object[][] {
        { "" },           // empty
        { " " },          // single space
        { "   " },        // multiple spaces
        { "\n" },         // newline
        { "\t" },         // tab
        { "  \n\t\n  " }, // mixed
    };
}

@Test(dataProvider = "whitespaceContent")
public void testPostProcessFile_deletesWhitespaceOnly(String content) throws IOException {
    // ... test with each whitespace variation
}
```

**Validation:** Data-driven testing covers all whitespace cases

| # | Task | Est. | Lines | Dependencies |
|---|------|------|-------|--------------|
| 1 | Add `@DataProvider` for whitespace variations | 5m | 12 | - |
| 2 | Add `testPostProcessFile_deletesEmptyFile()` | 10m | 15 | - |
| 3 | Add `testPostProcessFile_deletesWhitespaceOnly()` with DataProvider | 10m | 15 | 1 |
| 4 | Add `testPostProcessFile_preservesNonEmptyFile()` | 10m | 15 | - |
| 5 | Add `testPostProcessFile_preservesFileWithComment()` | 5m | 12 | - |
| 6 | Add `testPostProcessFile_preservesFileWithCode()` | 5m | 12 | - |
| 7 | Add `testPostProcessFile_nullFile()` | 5m | 8 | - |
| 8 | Add `testPostProcessFile_nonExistentFile()` | 5m | 10 | - |
| 9 | Run `mvn test -Dtest=DefaultCodegenTest` and fix failures | 10m | - | 2-8 |

**Total: ~1h 5m, ~100 lines**

### Task Details

#### Task 1: DataProvider for Whitespace
```java
@DataProvider(name = "whitespaceContent")
public Object[][] whitespaceContent() {
    return new Object[][] {
        { "" },              // empty
        { " " },             // single space
        { "   " },           // multiple spaces
        { "\n" },            // newline only
        { "\t" },            // tab only
        { "\r\n" },          // windows newline
        { "  \n\t\n  " },    // mixed whitespace
    };
}
```

#### Task 2: Empty File Test
```java
@Test
public void testPostProcessFile_deletesEmptyFile() throws IOException {
    DefaultCodegen codegen = new DefaultCodegen();
    File tempFile = File.createTempFile("test-empty-", ".php");
    try {
        Files.writeString(tempFile.toPath(), "");
        assertTrue(tempFile.exists(), "Precondition: file should exist");
        
        codegen.postProcessFile(tempFile, "operation");
        
        assertFalse(tempFile.exists(), "Empty file should be deleted");
    } finally {
        if (tempFile.exists()) tempFile.delete();
    }
}
```

#### Task 3: Whitespace Parameterized Test
```java
@Test(dataProvider = "whitespaceContent")
public void testPostProcessFile_deletesWhitespaceOnly(String content) throws IOException {
    DefaultCodegen codegen = new DefaultCodegen();
    File tempFile = File.createTempFile("test-ws-", ".php");
    try {
        Files.writeString(tempFile.toPath(), content);
        assertTrue(tempFile.exists(), "Precondition: file should exist");
        
        codegen.postProcessFile(tempFile, "operation");
        
        assertFalse(tempFile.exists(), 
            "File with only whitespace '" + content.replace("\n", "
").replace("\t", "\\t") + "' should be deleted");
    } finally {
        if (tempFile.exists()) tempFile.delete();
    }
}
```

#### Task 4: Non-Empty File Preservation
```java
@Test
public void testPostProcessFile_preservesNonEmptyFile() throws IOException {
    DefaultCodegen codegen = new DefaultCodegen();
    File tempFile = File.createTempFile("test-nonempty-", ".php");
    try {
        Files.writeString(tempFile.toPath(), "<?php\nclass Foo {}\n");
        
        codegen.postProcessFile(tempFile, "operation");
        
        assertTrue(tempFile.exists(), "Non-empty file should be preserved");
        assertEquals("<?php\nclass Foo {}\n", Files.readString(tempFile.toPath()));
    } finally {
        if (tempFile.exists()) tempFile.delete();
    }
}