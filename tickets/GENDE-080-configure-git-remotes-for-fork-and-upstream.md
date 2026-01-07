---
code: GENDE-080
status: Implemented
dateCreated: 2026-01-07T16:05:27.953Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 1: Setup Fork
relatedTickets: GENDE-078,GENDE-079
dependsOn: GENDE-079
implementationDate: 2026-01-07
implementationNotes: Remotes configured: origin=vatvit/openapi-generator (fork), upstream=OpenAPITools/openapi-generator
---

# Configure git remotes for fork and upstream

## 1. Description

Configure git remotes in local clone to work with both your fork and upstream repository.

## 2. Rationale

Proper remote setup enables:
- Pushing to your fork
- Fetching latest from upstream
- Keeping feature branch up to date

## 3. Solution Analysis

### Current State
```bash
git remote -v
# origin -> OpenAPITools/openapi-generator (or local path)
```

### Target State
```bash
git remote -v
# origin   -> vatvit/openapi-generator (your fork)
# upstream -> OpenAPITools/openapi-generator
```

## 4. Implementation Specification

### Commands
```bash
cd openapi-generator

# Rename current origin (if pointing to upstream)
git remote rename origin upstream

# Or add upstream if origin is already your fork
git remote add upstream https://github.com/OpenAPITools/openapi-generator.git

# Add your fork as origin
git remote add origin git@github.com:vatvit/openapi-generator.git

# Verify
git remote -v
```

## 5. Acceptance Criteria

- [ ] `git remote -v` shows both `origin` (fork) and `upstream`
- [ ] `git fetch upstream` works
- [ ] `git fetch origin` works