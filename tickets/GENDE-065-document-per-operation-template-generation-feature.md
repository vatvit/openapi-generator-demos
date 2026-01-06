---
code: GENDE-065
status: Implemented
dateCreated: 2026-01-06T13:01:29.545Z
type: Documentation
priority: Low
dependsOn: GENDE-064
---

# Document per-operation template generation feature

## 1. Description

Create documentation for the new per-operation template generation feature, including usage examples and migration guide.

### Target Files
- `docs/customization.md` (or similar)
- `README.md` (brief mention)

## 2. Documentation Content

### 2.1 Feature Overview

- What is per-operation generation
- When to use it (one controller per endpoint, handler interfaces, etc.)
- Comparison with per-tag generation

### 2.2 Configuration Guide

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

### 2.3 Available Variables

| Variable | Description | Example |
|----------|-------------|--------|
| `{{operationId}}` | Operation ID as-is | `createPet` |
| `{{operationIdPascalCase}}` | PascalCase | `CreatePet` |
| `{{vendorExtensions.hasBodyParam}}` | Has request body | `true/false` |
| `{{vendorExtensions.isPost}}` | Is POST method | `true/false` |

### 2.4 Conditional Generation Example

```mustache
{{#vendorExtensions.hasBodyParam}}
<?php
class {{vendorExtensions.operationIdPascalCase}}FormRequest { }
{{/vendorExtensions.hasBodyParam}}
```

### 2.5 Migration Guide

How to convert existing per-tag templates to per-operation.

## 3. Acceptance Criteria
- [ ] Feature documented in customization guide
- [ ] All new variables documented
- [ ] Configuration examples provided
- [ ] Migration guide written
- [ ] README updated with brief mention

### 4.1 Affected Files

| File | Location | Change Type | Size Limit |
|------|----------|-------------|------------|
| `customization.md` | `docs/` | Create/Modify | ~200 lines |
| `README.md` | root | Modify | +10 lines |

### 4.2 Documentation Structure

```
docs/
├── customization.md         # Main customization guide
│   └── ## Per-Operation Templates (NEW SECTION)
│       ├── ### Overview
│       ├── ### Configuration
│       ├── ### Available Variables
│       ├── ### Conditional Generation
│       └── ### Migration Guide
└── ...

README.md
└── ## Features
    └── - Per-operation template generation (NEW bullet)
```

### 4.3 Content Outline

**customization.md - New Section (~150 lines):**

```markdown

### 5.1 Documentation Location

| Content | File |
|---------|------|
| Feature overview | `docs/customization.md` |
| Quick reference | `README.md` |

### 5.2 Required Examples

| Example | Purpose |
|---------|---------|
| Basic config | Show `templateType: "Operation"` |
| Controller template | One controller per operation |
| Conditional generation | Using `{{#hasBodyParam}}` |
| Migration steps | Converting from per-tag |

### 5.3 Variable Documentation

All new variables must be listed in a table with type, location, and description.

### 5.4 Not In Scope

- Video documentation
- Generator-specific guides

| # | Task | Time | Lines |
|---|------|------|-------|
| 1 | Create `## Per-Operation Templates` section header + overview | 10m | 15 |
| 2 | Write `### Configuration` with JSON example | 15m | 30 |
| 3 | Create `### Available Variables` table | 15m | 25 |
| 4 | Write `### Conditional Generation` with template example | 15m | 25 |
| 5 | Write `### Migration Guide` with steps | 20m | 30 |
| 6 | Update README.md with feature bullet | 5m | 3 |
| 7 | Review links and commit | 10m | 0 |

**Total: 1h 30m, 128 lines**
## Per-Operation Template Generation

### Overview
Generate one file per OpenAPI operation instead of one file per tag.

### Configuration
\`\`\`json
{
  "files": {
    "controller.mustache": {
      "templateType": "Operation",
      "folder": "Controller",
      "destinationFilename": "{{operationIdPascalCase}}Controller.php"
    }
  }
}
\`\`\`

### Available Variables
| Variable | Type | Description |
|----------|------|-------------|
| `operationId` | string | Operation ID as defined |
| `operationIdPascalCase` | string | PascalCase version |
| `hasBodyParam` | boolean | Has request body |
| ... | ... | ... |

### Conditional Generation
Use Mustache conditionals + empty file cleanup...

### Migration Guide
Converting from per-tag to per-operation...
```

### 4.4 Size Constraints

- **New documentation:** ~150-200 lines
- **README update:** ~10 lines
- **Examples:** 3-4 code blocks