---
code: GENDE-063
status: Implemented
dateCreated: 2026-01-06T13:01:28.752Z
type: Feature Enhancement
priority: Medium
dependsOn: GENDE-061
---

# Add empty file cleanup in postProcessFile

## 1. Description

Add empty file cleanup in `postProcessFile()` to support template-driven conditional generation. When a template outputs only whitespace (due to Mustache conditionals), the file should be deleted.

### Target File
`modules/openapi-generator/src/main/java/org/openapitools/codegen/DefaultCodegen.java`

## 2. Implementation

```java
@Override
public void postProcessFile(File file, String fileType) {
    if (file == null || !file.exists()) {
        return;
    }
    
    // Delete empty files (template-driven conditional generation)
    try {
        String content = new String(Files.readAllBytes(file.toPath()), StandardCharsets.UTF_8);
        if (content.trim().isEmpty()) {
            if (file.delete()) {
                LOGGER.info("Deleted empty file: {}", file.getPath());
            }
            return;
        }
    } catch (IOException e) {
        LOGGER.warn("Could not check file content: {}", file.getPath());
    }
    
    // Existing post-processing (formatting, etc.)
    super.postProcessFile(file, fileType);
}
```

## 3. Use Case

Template with conditional:
```mustache
{{#hasBodyParam}}
<?php
class {{operationIdPascalCase}}FormRequest { }
{{/hasBodyParam}}
```

For operations WITHOUT body param:
1. Template outputs empty string
2. Empty file is created
3. `postProcessFile()` detects empty content
4. File is deleted

## 4. Acceptance Criteria

- [ ] Empty files (whitespace only) are deleted
- [ ] Non-empty files are preserved
- [ ] Log message when file is deleted
- [ ] Existing post-processing still works
- [ ] Unit test for empty file cleanup

## 5. Backward Compatibility
✅ 100% backward compatible - empty files are typically unwanted anyway.

### 6.1 Affected Files

| File | Lines | Change Type | Size Limit |
|------|-------|-------------|------------|
| `DefaultCodegen.java` | 8787 | Modify | +20 lines |

### 6.2 File Structure

```
modules/openapi-generator/src/main/java/org/openapitools/codegen/
└── DefaultCodegen.java      # Enhance postProcessFile()
```

### 6.3 Change Location

**DefaultCodegen.java - postProcessFile() (~Line 7800):**
```java
@Override
public void postProcessFile(File file, String fileType) {
    if (file == null || !file.exists()) {
        return;
    }
    
    // NEW: Delete empty files (template-driven conditional generation)
    try {
        String content = new String(
            java.nio.file.Files.readAllBytes(file.toPath()), 
            java.nio.charset.StandardCharsets.UTF_8
        );
        if (content.trim().isEmpty()) {
            if (file.delete()) {
                LOGGER.info("Deleted empty generated file: {}", file.getPath());
            }
            return;  // Skip further processing for deleted file
        }
    } catch (IOException e) {
        LOGGER.warn("Could not check file content for cleanup: {}", file.getPath());
    }
    
    // Existing post-processing code continues...
}
```

### 6.4 Design Decisions

| Decision | Rationale |
|----------|-----------|
| Check at start of method | Early exit, avoid processing empty files |
| Use `trim().isEmpty()` | Handle whitespace-only content |
| Log deletion | Visibility for debugging |
| Catch IOException | Don't fail generation for cleanup issues |
| Return after delete | Skip formatter/other processing |

### 6.5 Size Constraints

- **Lines added:** ~15-20
- **Methods added:** 0 (modify existing)
- **Test coverage:** 1 unit test (empty file deletion)

### 7.1 Definition of Empty

| Content | Deleted? |
|---------|----------|
| `""` (zero bytes) | Yes |
| `"   "` (spaces only) | Yes |
| `"

\n"` (newlines only) | Yes |
| `"<?php"` (any non-whitespace) | No |
| `"// comment"` | No |

### 7.2 Edge Cases

| Case | Behavior |
|------|----------|
| File doesn't exist | Skip (null check) |
| File read error | Log warning, don't delete |
| Delete fails | Log warning, continue |

### 7.3 Logging

```
INFO  - Deleted empty generated file: /output/Controller/GetPetController.php
WARN  - Could not check file content for cleanup: /output/error.php
```

### 7.4 Not In Scope

- Selective cleanup by file type
- Content-based cleanup (e.g., only comments)

| # | Task | Time | Lines |
|---|------|------|-------|
| 1 | Add null/exists check to `postProcessFile()` | 5m | 3 |
| 2 | Read file content with `Files.readAllBytes()` | 5m | 3 |
| 3 | Check `content.trim().isEmpty()` | 3m | 1 |
| 4 | Delete file and log if empty | 5m | 4 |
| 5 | Add try-catch with warning log | 5m | 4 |
| 6 | Add unit test (empty file deleted) | 10m | 15 |
| 7 | Add unit test (non-empty preserved) | 10m | 15 |
| 8 | Run tests and commit | 10m | 0 |

**Total: 53m, 45 lines**