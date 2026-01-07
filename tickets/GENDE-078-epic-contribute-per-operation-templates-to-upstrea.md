---
code: GENDE-078
status: Proposed
dateCreated: 2026-01-07T16:05:08.569Z
type: Architecture
priority: High
relatedTickets: GENDE-070,GENDE-079,GENDE-080,GENDE-081,GENDE-082,GENDE-083,GENDE-084,GENDE-085,GENDE-086,GENDE-087
---

# Epic: Contribute per-operation templates to upstream OpenAPI Generator

## 1. Description

Contribute the per-operation template generation feature (commit `9df587cd7c6`) to upstream OpenAPI Generator project.

### Current State
- ✅ GitHub fork created: https://github.com/vatvit/openapi-generator
- ✅ Git remotes configured (origin=fork, upstream=OpenAPITools)
- Changes committed locally on master (`9df587cd7c6`)
- Feature validated via GENDE-070 (3628 tests pass, 166 integration tests)

### Target State
- Proper GitHub fork created
- Feature branch with clean commits
- PR submitted and merged to upstream

## 2. Rationale
- Share improvements with community
- Avoid maintaining a separate fork long-term
- Get upstream support and maintenance
- Enable others to use per-operation generation

### Relationship to Generators

This project has **two parallel generator approaches** (see GOAL.md):

| Generator | Uses This Fork? | Per-operation Logic |
|-----------|-----------------|---------------------|
| **php-max** (PoC) | No | Embedded in Java generator (v7.18.0) |
| **New generator** (GENDE-088) | **Yes** | Uses fork's `operationTemplateFiles()` API |

This epic (GENDE-078) contributes the fork's core changes to upstream, which:
- Enables the **new generator** to work with official OpenAPI Generator releases
- Benefits the community with per-operation template support
- Does NOT affect php-max (it has its own implementation)
## 3. Solution Analysis

Follow OpenAPI Generator CONTRIBUTING.md guidelines:
1. Fork repository on GitHub
2. Create feature branch
3. Add required tests and samples
4. Submit PR with documentation

## 4. Ticket Breakdown
### Phase 1: Setup GitHub Fork
| Ticket | Description | Status | Depends On |
|--------|-------------|--------|------------|
| GENDE-079 | Fork repository on GitHub | **Implemented** ✅ | - |
| GENDE-080 | Configure git remotes | **Implemented** ✅ | GENDE-079 |

### Phase 2: Prepare Branch
| Ticket | Description | Status | Depends On |
|--------|-------------|--------|------------|
| GENDE-081 | Create feature branch from upstream master | **Implemented** ✅ | GENDE-080 |
| GENDE-082 | Cherry-pick/rebase commits to feature branch | **Implemented** ✅ | GENDE-081 |

### Phase 3: Contribution Requirements
| Ticket | Description | Status | Depends On |
|--------|-------------|--------|------------|
| GENDE-083 | Add unit tests for per-operation generation | Proposed | GENDE-082 |
| GENDE-084 | Update Petstore samples | Proposed | GENDE-083 |
| GENDE-085 | Update documentation/wiki | Proposed | GENDE-084 |
| GENDE-086 | Document vendor extensions | Proposed | GENDE-085 |

### Phase 4: Submit PR
| Ticket | Description | Status | Depends On |
|--------|-------------|--------|------------|
| GENDE-087 | Push branch and create PR | Proposed | GENDE-086 |

### Dependency Graph
```
GENDE-079 → GENDE-080 → GENDE-081 → GENDE-082 → GENDE-083 → GENDE-084 → GENDE-085 → GENDE-086 → GENDE-087
   Fork       Remotes     Branch      Commits     Tests       Samples      Docs       Extensions    PR
```
## 5. Acceptance Criteria

- [ ] PR submitted to upstream OpenAPI Generator
- [ ] PR passes CI checks
- [ ] PR merged (or clear feedback received)

## 6. Current State

**Last Updated:** 2026-01-07

| Phase | Status |
|-------|--------|
| Phase 1: Setup Fork | **Complete** ✅ |
| Phase 2: Prepare Branch | **Complete** ✅ |
| Phase 3: Requirements | Pending |
| Phase 4: Submit PR | Pending |

### Git State
```
Branch: feat/per-operation-templates (tracking upstream/master)
Commit: 5958d5f9d9c - feat(core): add per-operation template generation support

Remotes:
  origin   → git@github.com:vatvit/openapi-generator.git (fork)
  upstream → git@github.com:OpenAPITools/openapi-generator.git
```

### Verification
- Core module compiles ✅
- Core tests pass (22 tests, 0 failures) ✅

### Next Actions
- GENDE-083: Add unit tests for per-operation generation
- GENDE-084: Update Petstore samples