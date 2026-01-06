---
code: GENDE-061
status: Implemented
dateCreated: 2026-01-06T13:01:27.958Z
type: Feature Enhancement
priority: High
dependsOn: GENDE-060
---

# Add per-operation processing loop in DefaultGenerator

## 1. Description

Add processing loop in `DefaultGenerator.java` to handle `templateType: "Operation"` templates, generating one file per OpenAPI operation.

### Target File
`modules/openapi-generator/src/main/java/org/openapitools/codegen/DefaultGenerator.java`

## 2. Implementation

### 2.1 Add operationTemplateFiles to CodegenConfig

```java
// In CodegenConfig interface
Map<String, String> operationTemplateFiles();
```

### 2.2 Handle Operation type in switch (around line 1402)

```java
switch (userDefinedTemplate.getTemplateType()) {
    case API:
        config.apiTemplateFiles().put(templateFile, templateExt);
        break;
    case Operation:  // NEW
        config.operationTemplateFiles().put(templateFile, templateExt);
        break;
    // ...
}
```

### 2.3 Add per-operation loop in generateApis() (around line 686)

```java
for (String tag : paths.keySet()) {
    List<CodegenOperation> ops = paths.get(tag);
    
    // Existing per-TAG processing
    // ...
    
    // NEW: Per-operation file generation
    for (CodegenOperation op : ops) {
        for (String templateName : config.operationTemplateFiles().keySet()) {
            Map<String, Object> opData = buildOperationData(op);
            String filename = resolveOperationFilename(templateName, op);
            processTemplateToFile(opData, templateName, filename, generateApis, CodegenConstants.APIS);
        }
    }
}
```

## 3. Acceptance Criteria

- [ ] `operationTemplateFiles` map added to CodegenConfig
- [ ] Switch case handles `Operation` type
- [ ] Per-operation loop generates files correctly
- [ ] Filename variables resolved (`{{operationId}}`, `{{operationIdPascalCase}}`)
- [ ] Existing tests pass
- [ ] New integration test for per-operation generation

## 4. Backward Compatibility
✅ 100% backward compatible - loop only executes if operationTemplateFiles is not empty.

### 5.1 Affected Files

| File | Lines | Change Type | Size Limit |
|------|-------|-------------|------------|
| `CodegenConfig.java` | 369 | Modify | +5 lines |
| `DefaultCodegen.java` | 8787 | Modify | +15 lines |
| `DefaultGenerator.java` | 2026 | Modify | +50 lines |

### 5.2 File Structure

```
modules/openapi-generator/src/main/java/org/openapitools/codegen/
├── CodegenConfig.java       # Interface - add operationTemplateFiles()
├── DefaultCodegen.java      # Base impl - add operationTemplateFiles map
└── DefaultGenerator.java    # Generator - add per-operation loop
```

### 5.3 Change Locations

**CodegenConfig.java (~Line 176):**
```java
Map<String, String> modelDocTemplateFiles();
Map<String, String> operationTemplateFiles();  // NEW
```

**DefaultCodegen.java (~Line 200):**
```java
protected Map<String, String> operationTemplateFiles = new HashMap<>();

@Override
public Map<String, String> operationTemplateFiles() {
    return operationTemplateFiles;
}
```

**DefaultGenerator.java:**
```java
// Line ~1402: Add switch case
case Operation:
    config.operationTemplateFiles().put(templateFile, templateExt);
    break;

// Line ~788: Add per-operation loop (inside existing tag loop)
for (CodegenOperation op : ops) {
    for (String templateName : config.operationTemplateFiles().keySet()) {
        // Build operation-specific data
        // Resolve filename with operationId
        // Process template
    }
}
```

### 5.4 Design Decisions

| Decision | Rationale |
|----------|-----------|
| Add to CodegenConfig interface | Follows existing pattern for apiTemplateFiles, modelTemplateFiles |
| Loop inside tag loop | Reuse existing operation iteration, access to tag context |
| Separate operationTemplateFiles map | Clean separation, no pollution of existing maps |

### 5.5 Size Constraints

- **CodegenConfig.java:** +3 lines (method signature + docs)
- **DefaultCodegen.java:** +10 lines (field + getter)
- **DefaultGenerator.java:** +50 lines (switch case + loop + helper)
- **Total:** ~65 lines
- **Test coverage:** 2-3 integration tests

### 6.1 Filename Variable Resolution

| Variable | Source | Example |
|----------|--------|---------|
| `{{operationId}}` | `op.operationId` | `createPet` |
| `{{operationIdPascalCase}}` | `camelize(op.operationId)` | `CreatePet` |
| `{{httpMethod}}` | `op.httpMethod` | `POST` |
| `{{baseName}}` | tag name | `Pet` |

### 6.2 Edge Cases

| Case | Behavior |
|------|----------|
| Empty `operationTemplateFiles` | Loop doesn't execute (no-op) |
| Operation with no operationId | Skip generation, log warning |
| Duplicate operationId | Each generates separate file (may overwrite) |
| Special chars in operationId | Sanitize via `toModelName()` |

### 6.3 Template Data Available

All standard `CodegenOperation` properties plus `additionalProperties` from config.

### 6.4 Not In Scope

- Template variable enrichment (GENDE-062)
- Empty file cleanup (GENDE-063)

| # | Task | Time | Lines |
|---|------|------|-------|
| 1 | Add `operationTemplateFiles()` to CodegenConfig interface | 5m | 1 |
| 2 | Add field + getter to DefaultCodegen | 10m | 5 |
| 3 | Add `case Operation:` to switch in DefaultGenerator | 10m | 4 |
| 4 | Create `resolveOperationFilename()` helper method | 15m | 15 |
| 5 | Add per-operation loop in `generateApis()` | 30m | 40 |
| 6 | Run `mvn compile` | 3m | 0 |
| 7 | Add integration test | 30m | 50 |
| 8 | Run `mvn test` | 10m | 0 |
| 9 | Commit changes | 2m | 0 |

**Total: 1h 55m, 115 lines**