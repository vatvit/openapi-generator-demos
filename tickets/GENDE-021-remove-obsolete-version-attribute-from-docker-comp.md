---
code: GENDE-021
status: Proposed
dateCreated: 2026-01-01T17:02:58.431Z
type: Technical Debt
priority: Low
---

# Remove obsolete 'version' attribute from docker-compose.yml files

## 1. Description

When running `docker-compose` commands, a deprecation warning appears:

```
WARN[0000] the attribute 'version' is obsolete, it will be ignored, please remove it to avoid potential confusion
```

This affects the following files:
- `projects/laravel-api--php-laravel--default/docker-compose.yml`
- `projects/symfony-api--php-symfony--default/docker-compose.yml`

The `version` attribute was historically used to specify the Compose file format version, but modern Docker Compose (v2+) no longer requires it and will ignore it.

## 2. Rationale

- Eliminates unnecessary warning messages during development
- Keeps configuration files aligned with current Docker Compose best practices
- Prevents confusion for developers who may think the version is significant

## 3. Solution Analysis

### Selected Approach
Simply remove the `version: '3.8'` (or similar) line from all docker-compose.yml files.

### Alternatives Considered
- Keep the version attribute: Rejected because it causes warnings and is ignored anyway
- Suppress warnings: Not recommended as it hides potentially useful information

## 4. Implementation Specification

1. Remove the `version` line from `projects/laravel-api--php-laravel--default/docker-compose.yml`
2. Remove the `version` line from `projects/symfony-api--php-symfony--default/docker-compose.yml`
3. Verify docker-compose commands still work without warnings

## 5. Acceptance Criteria

- [ ] No `version` attribute in any docker-compose.yml files
- [ ] `docker-compose up` runs without the obsolete attribute warning
- [ ] All services start correctly