---
code: GENDE-024
status: Implemented
dateCreated: 2026-01-02T14:51:36.318Z
type: Feature Enhancement
priority: High
dependsOn: GENDE-011
---

# Add Per-Operation File Generation to php-max Generator

## 1. Description

### Problem Statement

Currently php-max generator only supports:
- Per-model file generation (one file per schema)
- Per-tag file generation (one file per API tag)

This prevents generating **one controller per endpoint** pattern required by GOAL_MAX.md.

### Goal

Add per-operation file generation to enable:
- One controller per operation
- One FormRequest per operation (with body)
- One Resource per response

## 2. Rationale

- **GOAL_MAX.md compliance** - Requires one-controller-per-operation pattern
- **Clean architecture** - Each endpoint has focused, single-responsibility files
- **Testability** - Individual controllers easier to test
- **Framework flexibility** - Templates decide file structure

## 3. Solution Analysis

### Current Generator Loops

```java
// Per-model (existing)
modelTemplateFiles.put("model.mustache", ".php");

// Per-tag (existing)
apiTemplateFiles.put("api.mustache", ".php");
```

### Required Addition

```java
// Per-operation (NEW)
@Override
public void postProcessOperationsWithModels(...) {
    for (CodegenOperation op : operations) {
        writeOperationFile(op, "controller.mustache", "Controller.php");
        if (op.bodyParam != null) {
            writeOperationFile(op, "request.mustache", "FormRequest.php");
        }
    }
}
```

## 4. Implementation Specification

### Step 1: Add Operation File Writer

```java
protected void writeOperationFile(
    CodegenOperation op,
    String templateName,
    String suffix,
    String folder
) {
    Map<String, Object> data = new HashMap<>();
    data.put("operation", op);
    data.put("classname", toModelName(op.operationId));
    // ... add all operation data
    
    String filename = toModelName(op.operationId) + suffix;
    String outputPath = outputFolder + "/" + folder + "/" + filename;
    
    processTemplateToFile(data, templateName, outputPath);
}
```

### Step 2: Configure Operation Templates

Add new template configuration:
```java
protected Map<String, OperationTemplateConfig> operationTemplateFiles = new HashMap<>();

public void addOperationTemplate(String template, String suffix, String folder) {
    operationTemplateFiles.put(template, new OperationTemplateConfig(suffix, folder));
}
```

### Step 3: Process in postProcessOperationsWithModels

```java
@Override
public OperationsMap postProcessOperationsWithModels(...) {
    // ... existing code ...
    
    for (CodegenOperation op : operations) {
        for (Map.Entry<String, OperationTemplateConfig> entry : operationTemplateFiles.entrySet()) {
            writeOperationFile(op, entry.getKey(), entry.getValue());
        }
    }
    
    return result;
}
```

## 5. Acceptance Criteria

- [ ] Generator supports per-operation file generation
- [ ] Operation templates receive full operation context
- [ ] File naming uses operationId (PascalCase)
- [ ] Output folder configurable per template
- [ ] Works with `-t` external templates
- [ ] Conditional generation (e.g., only if hasBodyParam)

## 6. Current State
**Last Updated:** 2026-01-02

### Status: Implemented

### What Was Built

1. **OperationTemplateConfig class** - Configuration for per-operation templates
   - template name, folder, suffix, condition

2. **Auto-detection of operation templates** - `registerOperationTemplates()`
   - Detects `controller.mustache`, `formrequest.mustache`, `request.mustache`, `resource.mustache`
   - If template exists in custom `-t` directory, registers it

3. **Conditional generation** - `shouldGenerateOperationFile()`
   - Supports: `hasBodyParam`, `hasQueryParams`, `hasPathParams`, `hasFormParams`, `hasHeaderParams`
   - Also checks vendor extensions

4. **Per-operation file writer** - `writeOperationFile()`
   - Renders template with full operation context
   - Writes to configurable folder with configurable suffix

### Generated Output

```
lib/
├── Controller/
│   ├── CreateGameController.php    # One per operation
│   ├── DeleteGameController.php
│   ├── GetGameController.php
│   └── ...
├── Model/
│   ├── Game.php                    # One per schema
│   └── ...
└── Api/
    ├── GameManagementApi.php       # One per tag
    └── ...
```

### Usage

```bash
# With custom templates that include controller.mustache
openapi-generator generate -g php-max \
  -t path/to/templates \
  -i spec.yaml \
  -o output/
```

### Template Variables Available

| Variable | Description |
|----------|-------------|
| `operationId` | Original operation ID |
| `operationIdPascalCase` | PascalCase version |
| `operationIdCamelCase` | camelCase version |
| `classname` | Full class name with suffix |
| `summary`, `notes` | Operation documentation |
| `httpMethod`, `path` | HTTP details |
| `allParams`, `pathParams`, `queryParams`, etc. | Parameters |
| `bodyParam` | Request body |
| `responses` | Response definitions |
| `hasBodyParam`, `hasPathParams`, etc. | Convenience flags |
| `isGet`, `isPost`, `isPut`, etc. | HTTP method flags |
| `controllerPackage`, `handlerPackage`, etc. | Namespaces |

### Acceptance Criteria

- [x] Generator supports per-operation file generation
- [x] Operation templates receive full operation context
- [x] File naming uses operationId (PascalCase)
- [x] Output folder configurable per template
- [x] Works with `-t` external templates
- [x] Conditional generation (e.g., only if hasBodyParam)