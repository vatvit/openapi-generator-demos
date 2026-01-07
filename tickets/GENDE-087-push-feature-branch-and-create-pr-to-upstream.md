---
code: GENDE-087
status: Proposed
dateCreated: 2026-01-07T16:06:44.878Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 4: Submit PR
relatedTickets: GENDE-078,GENDE-083,GENDE-084,GENDE-085,GENDE-086
dependsOn: GENDE-086
---

# Push feature branch and create PR to upstream

## 1. Description

Push the feature branch to GitHub fork and create a Pull Request to upstream OpenAPI Generator.

## 2. Rationale

This is the final step to contribute the per-operation template generation feature to the community.

## 3. Solution Analysis

### PR Requirements (from CONTRIBUTING.md)
- [ ] Meaningful title and description
- [ ] Enable "Allow edits from maintainers"
- [ ] Link to related issues (if any)
- [ ] Smaller changes preferred
- [ ] Include OpenAPI spec for reproduction

## 4. Implementation Specification

### Step 1: Push Branch
```bash
cd openapi-generator
git push -u origin feat/per-operation-templates
```

### Step 2: Create PR

**Target:** `OpenAPITools/openapi-generator` → `master` branch

**Title:**
```
feat(core): Add per-operation template generation support
```

**Description Template:**
```markdown
## Summary

Adds support for generating one file per OpenAPI operation using `templateType: Operation` in the `files` configuration.

## Motivation

Currently, templates can only generate files per-API (tag) or per-model. This PR adds per-operation generation, enabling:
- One controller per operation (cleaner architecture)
- Operation-specific file naming (e.g., `CreatePetController.php`)
- Fine-grained template control

## Changes

- Added `TemplateFileType.Operation` enum value
- Extended `DefaultGenerator` to handle per-operation template loop
- Added `enrichOperation()` for operation-level template variables
- Added empty file cleanup for whitespace-only output
- Added property constraint flags (`hasMinLength`, etc.)

## New Template Variables

| Variable | Description |
|----------|-------------|
| `operationIdPascalCase` | PascalCase operation ID |
| `operationIdCamelCase` | camelCase operation ID |
| `hasPathParams` | Has path parameters |
| `hasQueryParams` | Has query parameters |
| `hasBodyParam` | Has request body |

## Example Configuration

```json
{
  "files": [{
    "templateFile": "controller.mustache",
    "destinationFilename": "{{operationIdPascalCase}}Controller.php",
    "folder": "Controllers",
    "templateType": "Operation"
  }]
}
```

## Testing

- [x] All existing tests pass (3628 tests)
- [x] New unit tests added for per-operation generation
- [x] Sample generated and verified

## Checklist

- [x] Tests added
- [x] Documentation updated
- [x] Samples regenerated
- [x] "Allow edits from maintainers" enabled
```

### Step 3: Monitor and Respond
- Watch for CI results
- Respond to reviewer feedback
- Make requested changes

## 5. Acceptance Criteria

- [ ] Branch pushed to fork
- [ ] PR created with complete description
- [ ] "Allow edits from maintainers" enabled
- [ ] CI passes (or issues addressed)
- [ ] Ready for maintainer review