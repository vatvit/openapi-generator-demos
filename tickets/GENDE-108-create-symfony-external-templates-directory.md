---
code: GENDE-108
status: Proposed
dateCreated: 2026-01-07T16:41:33.475Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 3: Symfony
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Symfony external templates directory

## 1. Description

Create the external templates directory for Symfony-specific templates.

## 2. Rationale

Symfony templates are external (not embedded in generator) to:
- Keep generator framework-agnostic
- Allow independent template updates
- Support multiple Symfony versions

## 3. Solution Analysis

### Directory Structure
```
openapi-generator-server-templates/{generator-name}-symfony/
├── controller.mustache
├── model.mustache
├── api-interface.mustache
├── request.mustache
├── response.mustache
├── routes.yaml.mustache
├── services.yaml.mustache
├── files.json
└── README.md
```

## 4. Implementation Specification

### Usage
```bash
java -jar openapi-generator-cli.jar generate \
  -g {generator-name} \
  -t openapi-generator-server-templates/{generator-name}-symfony \
  -i spec.yaml \
  -o output/
```

## 5. Acceptance Criteria

- [ ] Directory structure created
- [ ] files.json configured
- [ ] README with usage instructions