---
code: GENDE-059
status: Implemented
dateCreated: 2026-01-06T11:45:34.483Z
type: Feature Enhancement
priority: Medium
---

# Contribute Template Flexibility Improvements to OpenAPI Generator

## 1. Description

### Problem Statement
While developing the php-max generator, we discovered several limitations in the existing OpenAPI Generator template system that required creating a custom generator. Many of these improvements could benefit the entire community if contributed upstream.

### Goal
Analyze our php-max generator innovations and propose upstream contributions to the official OpenAPI Generator repository that would benefit all PHP generators (and potentially others).

### Target Repository
https://github.com/OpenAPITools/openapi-generator

## 2. Rationale

- Our innovations solve real problems encountered by many users
- Contributing upstream benefits the entire community
- Reduces maintenance burden of custom generators
- Establishes credibility in the OpenAPI community

## 3. Potential Contributions to Analyze

### 3.1 Per-Operation File Generation (HIGH VALUE)
**Current Limitation:** Most generators create one file per TAG (e.g., `PetsApi.php` contains all pet operations)
**Our Solution:** Per-operation files (`CreatePetController.php`, `DeletePetController.php`)
**Benefit:** Better separation of concerns, easier testing, cleaner architecture
**Complexity:** Medium - requires changes to `DefaultGenerator.java`

### 3.2 files.json Configuration System (HIGH VALUE)
**Current Limitation:** File naming/structure hardcoded in Java generator
**Our Solution:** External `files.json` to configure:
- Template → output file mapping
- Suffixes (e.g., `Interface.php`, `Controller.php`)
- Folder structure
- Conditional generation
**Benefit:** Template authors can customize output without Java changes
**Complexity:** Medium

### 3.3 Multiple Template Sets per Generator (MEDIUM VALUE)
**Current Limitation:** One template set per generator
**Our Solution:** Framework-specific template directories (`laravel-max/`, `symfony-max/`)
**Benefit:** One generator supporting multiple frameworks
**Complexity:** Low-Medium

### 3.4 Enhanced Template Variables (LOW-MEDIUM VALUE)
**Current Limitation:** Limited variables available in templates
**Our Additions:**
- `operationIdPascalCase` - for class names
- `hasQueryParams`, `hasPathParams` - for conditional generation
- `responsesByStatusCode` - grouped responses
- `firstSuccessResponse` - common pattern
**Benefit:** More powerful templates without Java changes
**Complexity:** Low

### 3.5 Handler/Interface Pattern (MEDIUM VALUE)
**Current Limitation:** Controllers contain business logic
**Our Solution:** Separate handler interfaces for dependency injection
**Benefit:** Clean architecture, testability
**Complexity:** Template-only change

## 4. Analysis Tasks

### Phase 1: Research Existing Solutions
- [ ] Check if similar PRs exist or were rejected
- [ ] Review OpenAPI Generator roadmap
- [ ] Study contribution guidelines in detail
- [ ] Identify which improvements align with project direction

### Phase 2: Evaluate Each Improvement
- [ ] Per-operation generation - feasibility analysis
- [ ] files.json system - feasibility analysis
- [ ] Multiple template sets - feasibility analysis
- [ ] Template variables - feasibility analysis
- [ ] Handler pattern - feasibility analysis

### Phase 3: Prioritize & Plan
- [ ] Rank improvements by value/effort ratio
- [ ] Identify quick wins (template-only changes)
- [ ] Identify larger architectural changes
- [ ] Create implementation plan for top priorities

### Phase 4: Contribution
- [ ] Start with smallest improvement first
- [ ] Create GitHub issue to discuss approach
- [ ] Implement and submit PR
- [ ] Iterate based on feedback

## 5. Acceptance Criteria

- [ ] All potential improvements analyzed
- [ ] Feasibility assessed for each
- [ ] At least 1 improvement contributed upstream
- [ ] PR merged or feedback received

## 6. Current State
**Status:** Not Started
**Last Updated:** 2026-01-06

### Innovations from php-max to Analyze
| Innovation | Files | Potential Value |
|------------|-------|----------------|
| Per-operation generation | PhpMaxGenerator.java | High |
| files.json config | files.json, generator | High |
| Template variables | PhpMaxGenerator.java | Medium |
| Handler interfaces | handler.mustache | Medium |
| Response grouping | response.mustache | Low |

### Next Actions
1. Review OpenAPI Generator contribution guidelines
2. Search for existing similar proposals/PRs
3. Analyze per-operation generation feasibility first

### 7.1 Behavioral Requirements (EARS Format)
#### Extending Existing `files` Config
| ID | EARS Statement |
|----|----------------|
| BR-01 | WHEN a config specifies `templateType: "Operation"` in the `files` section, the generator SHALL process that template once per OpenAPI operation. |
| BR-02 | WHEN `templateType` is omitted, the generator SHALL default to existing behavior (`SupportingFiles`). |
| BR-03 | IF an unknown `templateType` value is provided, THEN the generator SHALL log a warning and skip that template. |

#### File Naming for Operations
| ID | EARS Statement |
|----|----------------|
| BR-04 | WHEN generating operation files, the generator SHALL support `{{operationId}}` variable in `destinationFilename`. |
| BR-05 | WHEN generating operation files, the generator SHALL support `{{operationIdPascalCase}}` variable in `destinationFilename`. |
| BR-06 | WHEN `folder` is specified, the generator SHALL place generated files in that subdirectory relative to output. |

#### Empty File Cleanup (Template-Driven Conditional Generation)
| ID | EARS Statement |
|----|----------------|
| BR-07 | WHILE post-processing generated files, the generator SHALL delete files that contain only whitespace. |
| BR-08 | WHEN a template outputs empty content (via Mustache conditionals), the generator SHALL NOT create the file OR shall delete it in post-processing. |

#### Enhanced Template Variables
| ID | EARS Statement |
|----|----------------|
| BR-09 | WHILE processing operations, the generator SHALL expose `operationIdPascalCase` variable for class naming. |
| BR-10 | WHILE processing operations, the generator SHALL expose boolean flags: `hasQueryParams`, `hasPathParams`, `hasBodyParam`, `hasFormParams`, `hasHeaderParams`. |
| BR-11 | WHILE processing operations, the generator SHALL expose HTTP method flags: `isGet`, `isPost`, `isPut`, `isPatch`, `isDelete`. |
| BR-12 | WHILE processing properties, the generator SHALL expose constraint flags: `hasMinLength`, `hasMaxLength`, `hasMinimum`, `hasMaximum`, `hasPattern`.

#### Backward Compatibility
| ID | EARS Statement |
|----|----------------|
| BR-13 | WHEN existing configs without `templateType: "Operation"` are used, the generator SHALL behave exactly as before. |
| BR-14 | WHEN `files` section is omitted, the generator SHALL use default template processing. |
### 7.2 Functional Requirements (FR)
| ID | Requirement | Priority |
|----|-------------|----------|
| FR-01 | Generator SHALL support `templateType: "Operation"` in existing `files` config | High |
| FR-02 | Generator SHALL process Operation templates once per OpenAPI operation | High |
| FR-03 | Generator SHALL support `{{operationIdPascalCase}}` in `destinationFilename` | High |
| FR-04 | Generator SHALL support `{{operationId}}` in `destinationFilename` | High |
| FR-05 | Generator SHALL delete empty files in `postProcessFile()` | Medium |
| FR-06 | Generator SHALL provide `hasQueryParams`, `hasPathParams`, `hasBodyParam` boolean variables | Medium |
| FR-07 | Generator SHALL provide HTTP method flags (`isGet`, `isPost`, etc.) | Medium |
| FR-08 | Generator SHALL provide property constraint flags (`hasMinLength`, `hasMaximum`, etc.) | Medium |
| FR-09 | Generator SHALL maintain 100% backward compatibility with existing configs | Critical |

**Removed:** `condition` attribute - handled by Mustache template conditionals + empty file cleanup instead.
### 7.3 Non-Functional Requirements (NFR)

| ID | Requirement | Measure | Target |
|----|-------------|---------|--------|
| NFR-01 | Backward Compatibility | Existing templates unchanged | 100% compatible |
| NFR-02 | Performance | Generation time overhead | < 5% increase |
| NFR-03 | Documentation | New features documented | All features in README |
| NFR-04 | Test Coverage | Unit tests for new features | > 80% coverage |
| NFR-05 | Configuration Validation | Invalid files.json handling | Clear error messages |
| NFR-06 | Cross-Generator Support | Features available to all generators | Java base class implementation |

### 7.4 Configuration Requirements
**Extends existing `files` config - no new config files needed.**

| Property | Location | Type | Description |
|----------|----------|------|-------------|
| `files` | generator config | object | Existing config section |
| `files.*.templateType` | generator config | enum | `API`, `Model`, `SupportingFiles`, **`Operation`** (NEW) |
| `files.*.folder` | generator config | string | Output subdirectory (existing) |
| `files.*.destinationFilename` | generator config | string | Filename with variables (existing) |

**New `templateType` Value:**
```json
{
  "files": {
    "controller.mustache": {
      "templateType": "Operation",
      "folder": "Controller",
      "destinationFilename": "{{operationIdPascalCase}}Controller.php"
    }
  }
}
```

**Conditional Generation (Template-Driven):**

Instead of config-level `condition`, use Mustache conditionals in templates:
```mustache
{{#hasBodyParam}}
<?php
class {{operationIdPascalCase}}FormRequest { ... }
{{/hasBodyParam}}
```

Empty output is cleaned up by `postProcessFile()` in the generator.
### 7.5 Artifact Mapping (Proposed)

| Requirement | Target File(s) |
|-------------|----------------|
| BR-01, BR-02, FR-01 | `DefaultGenerator.java` or `AbstractGenerator.java` |
| BR-04 to BR-08, FR-02 | `FilesConfigLoader.java` (new) |
| BR-09 to BR-12, FR-03, FR-04 | `DefaultCodegen.java` |
| BR-13, BR-14 | Template loading mechanism |

### 8.1 OOTB Generator Capabilities (Current State)

| Feature | AbstractPhpCodegen | PhpLaravelServerCodegen | PhpSlim4ServerCodegen |
|---------|-------------------|------------------------|----------------------|
| Per-TAG file generation | ✅ | ✅ | ✅ |
| Per-operation file generation | ❌ | ❌ | ❌ |
| External config (files.json) | ❌ | ❌ | ❌ |
| Multiple packages | 3 (invoker, api, model) | 4 (+controller) | 5 (+auth, interfaces, app) |
| Template variables | Basic | Basic + route names | Basic + PSR-7 |
| Security scheme extraction | ❌ | ❌ | Basic |
| Enum as PHP 8.1 enum | ❌ | ❌ | ❌ |
| Property constraint flags | ❌ | ❌ | ❌ |
| Conditional file generation | ❌ | ❌ | ❌ |

### 8.2 php-max Generator Features (Our Innovation)

| Feature | php-max | Lines | Complexity |
|---------|---------|-------|------------|
| Per-operation file generation | ✅ | 726-845 | High |
| files.json configuration | ✅ | 88-368 | Medium |
| Enhanced template variables | ✅ | 953-1023 | Low |
| Property constraint flags | ✅ | 644-677 | Low |
| Security scheme extraction | ✅ | 472-534 | Medium |
| PHP 8.1 enum generation | ✅ | 592-638 | Low |
| Required property sorting | ✅ | 570-587 | Low |
| Multiple packages (6) | ✅ | 43-56, 196-237 | Low |
| Conditional generation | ✅ | 747-768 | Low |

### 8.3 Critical Gap: Per-Operation vs Per-TAG

**OOTB Limitation (PhpLaravelServerCodegen:171):**
```java
// Always generates ONE file per TAG
return controllerFileFolder() + "/" + toControllerName(tag) + suffix;
```

**php-max Solution (PhpMaxGenerator:731-741):**
```java
// ONE file per OPERATION
for (CodegenOperation op : operations) {
    writeOperationFile(op, config);
}
```

**Impact:** Without per-operation generation, clean controller separation is impossible.

### 8.4 Answer: Are Current Features Enough?

**NO.** The proposed features are necessary but not sufficient.

The OOTB generators use `DefaultGenerator.java` which processes API files per-TAG. To generate php-max-like output, we need:

1. **Either** modify `DefaultGenerator.java` to support per-operation mode
2. **Or** contribute php-max as a new generator with custom `writeOperationFiles()` logic

### 8.5 Revised Strategy: files.json as Single Source of Truth
**Key Insight:** Per-operation generation should NOT be a CLI param or generator config. It should be **inferred from files.json**.

#### files.json Schema (Proposed)

```json
{
  "templates": {
    "model": { 
      "template": "model.mustache", 
      "scope": "model",
      "folder": "Model", 
      "suffix": ".php" 
    },
    "api": { 
      "template": "api-interface.mustache", 
      "scope": "tag",
      "folder": "Api", 
      "suffix": "Interface.php" 
    },
    "controller": { 
      "template": "controller.mustache", 
      "scope": "operation",
      "folder": "Controller", 
      "suffix": "Controller.php" 
    },
    "handler": { 
      "template": "handler.mustache", 
      "scope": "operation",
      "folder": "Handler", 
      "suffix": "ApiHandlerInterface.php",
      "condition": "hasBodyParam"
    }
  },
  "supporting": [
    { "template": "routes.mustache", "output": "routes/api.php" },
    { "template": "composer.mustache", "output": "composer.json" }
  ]
}
```

#### Scope Values

| Scope | Loop | Example Output |
|-------|------|----------------|
| `model` | Per schema/model | `Pet.php`, `Order.php` |
| `tag` | Per tag (current OOTB) | `PetsApi.php`, `OrdersApi.php` |
| `operation` | Per operation | `CreatePetController.php`, `GetPetController.php` |

#### Benefits

1. **Zero CLI params** - no `--perOperationFiles` flag needed
2. **Zero generator config** - no Java property to set
3. **Template-portable** - copy templates + files.json = works
4. **Single source of truth** - all file generation config in one place
5. **Backwards compatible** - generators without files.json use defaults

#### Core Implementation (Minimal Java Change)

```java
// In AbstractPhpCodegen or DefaultCodegen
protected void processTemplates() {
    FilesConfig config = loadFilesConfig(templateDir);
    if (config == null) {
        // Fall back to default behavior
        super.processTemplates();
        return;
    }
    
    for (TemplateConfig tmpl : config.templates.values()) {
        switch (tmpl.scope) {
            case "model": 
                processPerModel(tmpl); 
                break;
            case "tag": 
                processPerTag(tmpl); 
                break;
            case "operation": 
                processPerOperation(tmpl); 
                break;
        }
    }
}
```

#### Track 1: Core Contribution (Revised)

| Feature | Scope | Complexity |
|---------|-------|------------|
| files.json loader | DefaultCodegen or AbstractPhpCodegen | Medium |
| `scope: "operation"` support | Same | Medium |
| `condition` support | Same | Low |
| Enhanced template variables | AbstractPhpCodegen | Low |
| Property constraint flags | AbstractPhpCodegen | Low |

#### Track 2: Only If Track 1 Rejected

If core maintainers reject files.json approach:
- Contribute php-max as standalone generator
- Maintains our innovation independently