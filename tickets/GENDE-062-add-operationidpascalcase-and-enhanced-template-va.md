---
code: GENDE-062
status: Implemented
dateCreated: 2026-01-06T13:01:28.355Z
type: Feature Enhancement
priority: Medium
dependsOn: GENDE-060
---

# Add operationIdPascalCase and enhanced template variables

## 1. Description

Add enhanced template variables for operation processing, including `operationIdPascalCase` for class naming and boolean flags for conditional template logic.

### Target File
`modules/openapi-generator/src/main/java/org/openapitools/codegen/DefaultCodegen.java`

## 2. Implementation

### 2.1 Add operationIdPascalCase

```java
// In postProcessOperationsWithModels or similar
op.vendorExtensions.put("operationIdPascalCase", camelize(op.operationId));
```

### 2.2 Add operation boolean flags

```java
op.vendorExtensions.put("hasPathParams", op.pathParams != null && !op.pathParams.isEmpty());
op.vendorExtensions.put("hasQueryParams", op.queryParams != null && !op.queryParams.isEmpty());
op.vendorExtensions.put("hasBodyParam", op.bodyParam != null);
op.vendorExtensions.put("hasFormParams", op.formParams != null && !op.formParams.isEmpty());
op.vendorExtensions.put("hasHeaderParams", op.headerParams != null && !op.headerParams.isEmpty());
```

### 2.3 Add HTTP method flags

```java
op.vendorExtensions.put("isGet", "GET".equalsIgnoreCase(op.httpMethod));
op.vendorExtensions.put("isPost", "POST".equalsIgnoreCase(op.httpMethod));
op.vendorExtensions.put("isPut", "PUT".equalsIgnoreCase(op.httpMethod));
op.vendorExtensions.put("isPatch", "PATCH".equalsIgnoreCase(op.httpMethod));
op.vendorExtensions.put("isDelete", "DELETE".equalsIgnoreCase(op.httpMethod));
```

## 3. Template Usage

```mustache
{{! Controller class name }}
class {{vendorExtensions.operationIdPascalCase}}Controller

{{! Conditional form request }}
{{#vendorExtensions.hasBodyParam}}
use App\Http\Requests\{{vendorExtensions.operationIdPascalCase}}FormRequest;
{{/vendorExtensions.hasBodyParam}}
```

## 4. Acceptance Criteria

- [ ] `operationIdPascalCase` available in templates
- [ ] `hasPathParams`, `hasQueryParams`, `hasBodyParam`, `hasFormParams`, `hasHeaderParams` flags available
- [ ] `isGet`, `isPost`, `isPut`, `isPatch`, `isDelete` flags available
- [ ] Unit tests for each variable
- [ ] Documentation updated

## 5. Backward Compatibility
✅ 100% backward compatible - adds new variables, doesn't change existing ones.

### 6.1 Affected Files

| File | Lines | Change Type | Size Limit |
|------|-------|-------------|------------|
| `DefaultCodegen.java` | 8787 | Modify | +40 lines |

### 6.2 File Structure

```
modules/openapi-generator/src/main/java/org/openapitools/codegen/
└── DefaultCodegen.java      # Add enrichOperation() method
```

### 6.3 Change Location

**DefaultCodegen.java - postProcessOperationsWithModels() (~Line 5200):**
```java
@Override
public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {
    // Existing code...
    
    // NEW: Enrich each operation with additional variables
    for (CodegenOperation op : operations) {
        enrichOperation(op);
    }
    
    return objs;
}

// NEW method (~40 lines)
protected void enrichOperation(CodegenOperation op) {
    // Naming variations
    op.vendorExtensions.put("operationIdPascalCase", camelize(op.operationId));
    op.vendorExtensions.put("operationIdCamelCase", camelize(op.operationId, LOWERCASE_FIRST_LETTER));
    
    // Parameter presence flags
    op.vendorExtensions.put("hasPathParams", !op.pathParams.isEmpty());
    op.vendorExtensions.put("hasQueryParams", !op.queryParams.isEmpty());
    op.vendorExtensions.put("hasBodyParam", op.bodyParam != null);
    op.vendorExtensions.put("hasFormParams", !op.formParams.isEmpty());
    op.vendorExtensions.put("hasHeaderParams", !op.headerParams.isEmpty());
    
    // HTTP method flags
    op.vendorExtensions.put("isGet", "GET".equalsIgnoreCase(op.httpMethod));
    op.vendorExtensions.put("isPost", "POST".equalsIgnoreCase(op.httpMethod));
    op.vendorExtensions.put("isPut", "PUT".equalsIgnoreCase(op.httpMethod));
    op.vendorExtensions.put("isPatch", "PATCH".equalsIgnoreCase(op.httpMethod));
    op.vendorExtensions.put("isDelete", "DELETE".equalsIgnoreCase(op.httpMethod));
}
```

### 6.4 Design Decisions

| Decision | Rationale |
|----------|-----------|
| Use `vendorExtensions` | Standard place for custom variables, doesn't pollute core model |
| Place in `postProcessOperationsWithModels` | Called after all operations processed, consistent hook point |
| Separate `enrichOperation()` method | Clean, testable, overridable by subclasses |
| Check for null/empty safely | Defensive coding, avoid NPE |

### 6.5 Size Constraints

- **New method:** ~35-40 lines
- **Hook in existing method:** ~5 lines
- **Total:** ~45 lines
- **Test coverage:** 1 unit test per variable group

### 7.1 Variable Naming Convention

| Pattern | Example | Usage |
|---------|---------|-------|
| `operationId*` | `operationIdPascalCase` | Naming variations |
| `has*` | `hasBodyParam` | Boolean presence flags |
| `is*` | `isPost` | Boolean type flags |

### 7.2 Edge Cases

| Case | Behavior |
|------|----------|
| Null pathParams list | `hasPathParams = false` (not NPE) |
| Empty string operationId | `operationIdPascalCase = ""` |
| operationId with numbers | `get2FACode` → `Get2FACode` |
| operationId with underscores | `get_pet_by_id` → `GetPetById` |

### 7.3 Not In Scope

- Property constraint flags (GENDE-064)
- Parameter enrichment

| # | Task | Time | Lines |
|---|------|------|-------|
| 1 | Create `enrichOperation()` method signature | 5m | 3 |
| 2 | Add `operationIdPascalCase`, `operationIdCamelCase` | 5m | 3 |
| 3 | Add `hasPathParams`, `hasQueryParams`, `hasBodyParam`, `hasFormParams`, `hasHeaderParams` | 10m | 8 |
| 4 | Add `isGet`, `isPost`, `isPut`, `isPatch`, `isDelete` | 5m | 5 |
| 5 | Hook into `postProcessOperationsWithModels()` | 10m | 5 |
| 6 | Add unit tests for each variable group | 25m | 40 |
| 7 | Run tests and commit | 10m | 0 |

**Total: 1h 10m, 64 lines**