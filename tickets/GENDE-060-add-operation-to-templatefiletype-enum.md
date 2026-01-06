---
code: GENDE-060
status: Implemented
dateCreated: 2026-01-06T13:01:27.582Z
type: Feature Enhancement
priority: High
dependsOn: GENDE-059
---

# Add Operation to TemplateFileType enum

## 1. Description

Add new `Operation` value to the `TemplateFileType` enum to enable per-operation file generation.

### Target File
`modules/openapi-generator-core/src/main/java/org/openapitools/codegen/api/TemplateFileType.java`

## 2. Implementation

```java
public enum TemplateFileType {
    API(Constants.APIS),
    Model(Constants.MODELS),
    Operation(Constants.OPERATIONS),  // NEW
    APIDocs(Constants.API_DOCS),
    ModelDocs(Constants.MODEL_DOCS),
    APITests(Constants.API_TESTS),
    ModelTests(Constants.MODEL_TESTS),
    SupportingFiles(Constants.SUPPORTING_FILES);
    
    // ...
    
    public static class Constants {
        public static final String APIS = "apis";
        public static final String MODELS = "models";
        public static final String OPERATIONS = "operations";  // NEW
        // ...
    }
}
```

## 3. Acceptance Criteria

- [ ] `Operation` value added to enum
- [ ] `OPERATIONS` constant added
- [ ] Existing tests pass
- [ ] New unit test for `Operation` type

## 4. Backward Compatibility
✅ 100% backward compatible - new enum value, existing configs won't use it.

### 5.1 Affected Files

| File | Lines | Change Type | Size Limit |
|------|-------|-------------|------------|
| `TemplateFileType.java` | 67 | Modify | +5 lines |

### 5.2 File Structure

```
modules/openapi-generator-core/src/main/java/org/openapitools/codegen/api/
└── TemplateFileType.java    # Enum definition
```

### 5.3 Change Location

```java
// Line 9-16: Add Operation between Model and APIDocs
public enum TemplateFileType {
    API(Constants.APIS),
    Model(Constants.MODELS),
    Operation(Constants.OPERATIONS),  // NEW - Line ~12
    APIDocs(Constants.API_DOCS),
    // ...
}

// Line 58-66: Add constant
public static class Constants {
    public static final String OPERATIONS = "operations";  // NEW - Line ~62
}
```

### 5.4 Design Decisions

| Decision | Rationale |
|----------|-----------|
| Place after `Model` | Logical grouping: API → Model → Operation |
| Use `"operations"` string | Consistent with existing pattern (`"apis"`, `"models"`) |
| No additional methods | Enum is simple, no special handling needed |

### 5.5 Size Constraints

- **Max lines added:** 5
- **Max methods added:** 0
- **Test coverage:** 1 new unit test

### 6.1 Open Questions (Resolved)

| Question | Resolution |
|----------|------------|
| Where in enum order? | After `Model`, before `APIDocs` (logical grouping) |
| String constant value? | `"operations"` (lowercase, plural, consistent with others) |
| Need default case in switch? | No - unknown types already ignored in DefaultGenerator |

### 6.2 Edge Cases

| Case | Behavior |
|------|----------|
| Typo in config (`"Operaton"`) | `forTemplateType()` throws `IllegalArgumentException` |
| Case sensitivity (`"operation"` vs `"Operation"`) | Match is case-sensitive, use `"Operation"` |

### 6.3 Not In Scope

- Processing logic for Operation type (GENDE-061)
- Template variables (GENDE-062)

| # | Task | Time | Lines |
|---|------|------|-------|
| 1 | Add `Operation(Constants.OPERATIONS)` to enum | 5m | 1 |
| 2 | Add `OPERATIONS = "operations"` to Constants | 2m | 1 |
| 3 | Run `mvn compile` to verify | 2m | 0 |
| 4 | Add unit test for `forTemplateType("operations")` | 10m | 15 |
| 5 | Run `mvn test` | 5m | 0 |
| 6 | Commit changes | 2m | 0 |

**Total: 26 min, 17 lines**