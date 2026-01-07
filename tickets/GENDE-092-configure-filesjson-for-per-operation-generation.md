---
code: GENDE-092
status: Proposed
dateCreated: 2026-01-07T16:39:11.356Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 1: Generator
relatedTickets: GENDE-088,GENDE-091
dependsOn: GENDE-091
---

# Configure generator for per-operation template generation

## 1. Description
Configure the generator to use per-operation generation by extending the existing generator configuration (not creating a separate files.json).

**Note:** We extend the generator's built-in configuration, not create external files.json. The per-operation support is configured in the generator class itself using the extended core features.
## 2. Rationale

The `files` configuration controls:
- Which templates to process
- Output file naming patterns
- Template type (API, Model, Operation, SupportingFiles)

## 3. Solution Analysis
### Approach: Extend Generator Config (NOT external files.json)

The per-operation generation is configured inside the generator class by overriding methods:

```java
public class NewGenerator extends AbstractPhpCodegen {
    
    @Override
    public void processOpts() {
        super.processOpts();
        
        // Configure per-operation templates
        supportingFiles.add(new SupportingFile(
            "controller.mustache",
            "Http/Controllers",
            "{{operationIdPascalCase}}Controller.php"
        ).templateType(TemplateFileType.Operation));
    }
}
```

### Template Types Available (from extended core)
| Type | Loop | Use Case |
|------|------|----------|
| `API` | Per tag | Handler interfaces |
| `Model` | Per schema | DTOs |
| `Operation` | Per operation | Controllers |
| `SupportingFiles` | Once | Routes, config |

### Why NOT external files.json
- Generator is self-contained
- No external dependencies
- Cleaner distribution
- Laravel templates embedded as default
## 4. Implementation Specification

### files.json Structure
```json
{
  "files": [
    {
      "templateFile": "controller.mustache",
      "destinationFilename": "{{operationIdPascalCase}}Controller.php",
      "folder": "Http/Controllers",
      "templateType": "Operation"
    },
    {
      "templateFile": "model.mustache",
      "folder": "Models",
      "templateType": "Model"
    }
  ]
}
```

## 5. Acceptance Criteria

- [ ] files.json created with all file types
- [ ] Per-operation files configured correctly
- [ ] Generator reads and applies configuration