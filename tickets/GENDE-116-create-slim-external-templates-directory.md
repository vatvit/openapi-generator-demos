---
code: GENDE-116
status: Implemented
dateCreated: 2026-01-07T16:42:23.904Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 4: Slim
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Slim external templates directory

## 1. Description

Create the external templates directory for Slim-specific templates.

## 2. Rationale

Slim templates are external to:
- Keep generator framework-agnostic
- Support Slim 4 patterns
- Allow independent updates

## 3. Solution Analysis

### Directory Structure
```
openapi-generator-server-templates/{generator-name}-slim/
├── controller.mustache
├── model.mustache
├── api-interface.mustache
├── routes.mustache
├── dependencies.mustache
├── files.json
└── README.md
```

## 4. Implementation Specification

### Usage
```bash
java -jar openapi-generator-cli.jar generate \
  -g {generator-name} \
  -t openapi-generator-server-templates/{generator-name}-slim \
  -i spec.yaml \
  -o output/
```

## 5. Acceptance Criteria

- [ ] Directory structure created
- [ ] files.json configured
- [ ] README with usage instructions