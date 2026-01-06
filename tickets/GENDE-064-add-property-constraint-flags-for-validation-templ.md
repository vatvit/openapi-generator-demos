---
code: GENDE-064
status: Implemented
dateCreated: 2026-01-06T13:01:29.154Z
type: Feature Enhancement
priority: Low
dependsOn: GENDE-062
---

# Add property constraint flags for validation templates

## 1. Description

Add constraint presence flags to model properties for cleaner validation rule generation in templates.

### Target File
`modules/openapi-generator/src/main/java/org/openapitools/codegen/DefaultCodegen.java`

## 2. Implementation

```java
// In postProcessModels or updatePropertyForArray/Map
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
    prop.vendorExtensions.put("isUrl", "url".equals(prop.dataFormat) || "uri".equals(prop.dataFormat));
    prop.vendorExtensions.put("isDate", "date".equals(prop.dataFormat));
    prop.vendorExtensions.put("isDateTime", "date-time".equals(prop.dataFormat));
}
```

## 3. Template Usage

```mustache
{{#vars}}
'{{name}}' => [
    {{#required}}'required',{{/required}}
    {{#vendorExtensions.hasMinLength}}'min:{{minLength}}',{{/vendorExtensions.hasMinLength}}
    {{#vendorExtensions.hasMaxLength}}'max:{{maxLength}}',{{/vendorExtensions.hasMaxLength}}
    {{#vendorExtensions.hasPattern}}'regex:{{pattern}}',{{/vendorExtensions.hasPattern}}
],
{{/vars}}
```

## 4. Acceptance Criteria

- [ ] `hasMinLength`, `hasMaxLength` flags available
- [ ] `hasMinimum`, `hasMaximum` flags available
- [ ] `hasPattern`, `hasMinItems`, `hasMaxItems` flags available
- [ ] Format flags (`isUrl`, `isDate`, `isDateTime`) available
- [ ] Unit tests for each flag
- [ ] Documentation updated

## 5. Backward Compatibility
✅ 100% backward compatible - adds new variables only.

### 6.1 Affected Files

| File | Lines | Change Type | Size Limit |
|------|-------|-------------|------------|
| `DefaultCodegen.java` | 8787 | Modify | +35 lines |

### 6.2 File Structure

```
modules/openapi-generator/src/main/java/org/openapitools/codegen/
└── DefaultCodegen.java      # Add enrichPropertyConstraints()
```

### 6.3 Change Location

**DefaultCodegen.java - postProcessModels() (~Line 5400):**
```java
@Override
public ModelsMap postProcessModels(ModelsMap objs) {
    // Existing code...
    
    for (ModelMap modelMap : objs.getModels()) {
        CodegenModel model = modelMap.getModel();
        // NEW: Enrich properties with constraint flags
        for (CodegenProperty prop : model.vars) {
            enrichPropertyConstraints(prop);
        }
    }
    
    return objs;
}

// NEW method (~30 lines)
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

### 6.4 Design Decisions

| Decision | Rationale |
|----------|-----------|
| Use `vendorExtensions` | Standard place, doesn't change core property model |
| Separate method | Clean, testable, overridable |
| Check null explicitly | `minLength != null` vs `minLength > 0` (0 is valid constraint) |
| Include format flags | Common validation needs (email, uuid, url) |

### 6.5 Size Constraints

- **New method:** ~25-30 lines
- **Hook in existing method:** ~5 lines  
- **Total:** ~35 lines
- **Test coverage:** 1 unit test per constraint type

### 7.1 Constraint Flag Logic

| Flag | True When |
|------|-----------|
| `hasMinLength` | `prop.minLength != null` |
| `hasMaxLength` | `prop.maxLength != null` |
| `hasPattern` | `prop.pattern != null && !prop.pattern.isEmpty()` |

**Note:** Check `!= null`, not `> 0`. Value of `0` is a valid constraint.

### 7.2 Format Flag Logic

| Flag | True When Format Is |
|------|---------------------|
| `isUrl` | `"url"` or `"uri"` |
| `isDate` | `"date"` |
| `isDateTime` | `"date-time"` |
| `isEmail` | `"email"` |
| `isUuid` | `"uuid"` |

### 7.3 Edge Cases

| Case | Behavior |
|------|----------|
| `minLength: 0` | `hasMinLength = true` |
| `pattern: ""` | `hasPattern = false` |
| Unknown format | No flag set |

### 7.4 Not In Scope

- Enum value flags (already exist)
- Array item type flags

| # | Task | Time | Lines |
|---|------|------|-------|
| 1 | Create `enrichPropertyConstraints()` method | 5m | 3 |
| 2 | Add `hasMinLength`, `hasMaxLength`, `hasMinimum`, `hasMaximum` | 5m | 4 |
| 3 | Add `hasPattern`, `hasMinItems`, `hasMaxItems` | 5m | 3 |
| 4 | Add `isUrl`, `isDate`, `isDateTime`, `isEmail`, `isUuid` | 8m | 6 |
| 5 | Hook into `postProcessModels()` | 10m | 5 |
| 6 | Add unit tests for constraint flags | 15m | 20 |
| 7 | Add unit tests for format flags | 10m | 15 |
| 8 | Run tests and commit | 10m | 0 |

**Total: 1h 8m, 56 lines**