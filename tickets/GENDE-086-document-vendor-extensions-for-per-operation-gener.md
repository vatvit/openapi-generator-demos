---
code: GENDE-086
status: Implemented
dateCreated: 2026-01-07T16:06:26.785Z
type: Documentation
priority: Low
phaseEpic: Phase 3: Requirements
relatedTickets: GENDE-078,GENDE-085
dependsOn: GENDE-085
---

# Document vendor extensions for per-operation generation

## 1. Description

Document any new vendor extensions (`x-` properties) added for per-operation template generation on the OpenAPI Generator wiki.

## 2. Rationale

Per CONTRIBUTING.md:
> "If adding new vendor extensions, update the wiki: https://github.com/openapitools/openapi-generator/wiki/Vendor-Extensions"

## 3. Solution Analysis

### Vendor Extensions Added

Review the per-operation changes to identify any new `x-` extensions:

| Extension | Purpose | Scope |
|-----------|---------|-------|
| (TBD) | Check if any added | Operation/Property |

### Check Required
```bash
cd openapi-generator
git diff upstream/master -- . | grep -i "x-"
```

## 4. Implementation Specification

### If Extensions Found
1. Go to wiki: https://github.com/openapitools/openapi-generator/wiki/Vendor-Extensions
2. Add entry following existing format
3. Include: name, description, scope, example

### Wiki Entry Format
```markdown
| Extension | Description | Applicable to |
|-----------|-------------|---------------|
| x-operation-extra | Extra operation metadata | Operation |
```

## 5. Acceptance Criteria
- [ ] Check completed for new vendor extensions
- [ ] If found: Wiki updated with new extensions
- [ ] If none: Document "No new vendor extensions" in PR description

**Status:** Implemented (N/A - no new vendor extensions)

**Findings:**
- Per-operation feature adds internal `vendorExtensions` map entries (template variables)
- These are NOT `x-*` properties in OpenAPI specs
- Examples: `vendorExtensions.operationIdPascalCase`, `vendorExtensions.hasBodyParam`
- These are computed by generator, not user-specified

**Action:** Document "No new vendor extensions" in PR description when submitting.