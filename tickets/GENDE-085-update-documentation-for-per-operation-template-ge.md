---
code: GENDE-085
status: Proposed
dateCreated: 2026-01-07T16:06:26.651Z
type: Documentation
priority: Medium
phaseEpic: Phase 3: Requirements
relatedTickets: GENDE-078,GENDE-084
dependsOn: GENDE-084
---

# Update documentation for per-operation template generation

## 1. Description

Update OpenAPI Generator documentation to describe the new per-operation template generation feature.

## 2. Rationale

Users need to know:
- How to configure `templateType: Operation`
- What new template variables are available
- Example usage in `files` configuration

## 3. Solution Analysis

### Documentation Locations

| Location | Content | Priority |
|----------|---------|----------|
| `docs/templating.md` | Main template docs | High |
| `docs/customization.md` | Custom template usage | Medium |
| Wiki: Template Variables | New variables list | Medium |
| README.md | Brief mention | Low |

## 4. Implementation Specification

### Content to Add

#### templating.md Additions
```markdown
## Template Types

### Operation Templates (NEW)

Use `templateType: Operation` to generate one file per OpenAPI operation:

```json
{
  "files": [
    {
      "templateFile": "controller.mustache",
      "destinationFilename": "{{operationIdPascalCase}}Controller.php",
      "folder": "Controllers",
      "templateType": "Operation"
    }
  ]
}
```

### New Template Variables

| Variable | Description | Example |
|----------|-------------|----------|
| `operationIdPascalCase` | PascalCase operation ID | `CreatePet` |
| `operationIdCamelCase` | camelCase operation ID | `createPet` |
| `hasPathParams` | Has path parameters | `true` |
| `hasQueryParams` | Has query parameters | `false` |
| `hasBodyParam` | Has request body | `true` |
```

## 5. Acceptance Criteria

- [ ] `docs/templating.md` updated with per-operation section
- [ ] New template variables documented
- [ ] Example configuration included
- [ ] Documentation renders correctly