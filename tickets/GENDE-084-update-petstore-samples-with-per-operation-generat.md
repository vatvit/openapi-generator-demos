---
code: GENDE-084
status: Proposed
dateCreated: 2026-01-07T16:06:26.529Z
type: Technical Debt
priority: High
phaseEpic: Phase 3: Requirements
relatedTickets: GENDE-078,GENDE-083
dependsOn: GENDE-083
---

# Update Petstore samples with per-operation generation

## 1. Description

Update the Petstore sample generation to include examples of per-operation template usage.

## 2. Rationale

Per CONTRIBUTING.md:
> "Update Petstore samples: Run the shell script(s) under the `bin` folder to update Petstore samples"

Samples demonstrate the feature works and serve as documentation.

## 3. Solution Analysis

### Options

| Option | Description | Effort |
|--------|-------------|--------|
| A | Add new sample for per-operation | Medium |
| B | Update existing sample to use per-operation | Low |
| C | Both A and B | High |

**Recommendation:** Option A - Add new sample to avoid breaking existing samples.

### Sample Location
```
samples/server/petstore/php-per-operation/
```

## 4. Implementation Specification

### Steps
1. Create generator config using `templateType: Operation`
2. Create shell script in `bin/` folder
3. Run script to generate sample
4. Commit generated sample

### Files to Create
```
bin/configs/php-per-operation.yaml
bin/generate-samples.sh (update)
samples/server/petstore/php-per-operation/
```

### Example Config
```yaml
generatorName: php
outputDir: samples/server/petstore/php-per-operation
inputSpec: modules/openapi-generator/src/test/resources/3_0/petstore.yaml
templateDir: path/to/per-operation-templates
additionalProperties:
  # per-operation specific config
```

## 5. Acceptance Criteria

- [ ] Sample config exists in `bin/configs/`
- [ ] Sample generated in `samples/server/petstore/`
- [ ] Sample shows one file per operation pattern
- [ ] `mvn verify -Psamples` passes