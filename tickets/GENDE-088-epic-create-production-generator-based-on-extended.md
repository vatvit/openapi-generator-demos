---
code: GENDE-088
status: Implemented
dateCreated: 2026-01-07T16:38:34.927Z
type: Architecture
priority: High
relatedTickets: GENDE-078,GENDE-089,GENDE-090,GENDE-091,GENDE-092,GENDE-093,GENDE-094,GENDE-095,GENDE-096,GENDE-097,GENDE-098,GENDE-099,GENDE-100,GENDE-101,GENDE-102,GENDE-103,GENDE-104,GENDE-105,GENDE-106,GENDE-107,GENDE-108,GENDE-109,GENDE-110,GENDE-111,GENDE-112,GENDE-113,GENDE-114,GENDE-115,GENDE-116,GENDE-117,GENDE-118,GENDE-119,GENDE-120,GENDE-121,GENDE-122,GENDE-123
dependsOn: GENDE-078
---

# Epic: Create production generator based on extended OpenAPI Generator core

## 1. Description

Create a production-quality OpenAPI generator that leverages the per-operation template support from the extended core (GENDE-078). This replaces the php-max PoC with a properly architected solution.

### Background
- **php-max (PoC)**: Custom generator with embedded core changes - proved the concept works
- **New generator**: Uses extended core engine, cleaner architecture, production-ready

### Scope
1. Create new generator using extended core
2. Laravel templates (DEFAULT - embedded in generator)
3. Symfony templates (external)
4. Slim templates (external)
5. Integration test projects for each framework

## 2. Rationale
- PoC validated the approach, now build it properly
- Leverage upstream core (once PR merged) or fork
- Clean separation: generator vs templates vs integration projects
- Reusable across PHP frameworks

### Relationship to php-max

This project has **two parallel generator approaches** (see GOAL.md):

| Aspect | php-max (PoC) | New Generator (This Epic) |
|--------|---------------|---------------------------|
| **Base** | OpenAPI Generator v7.18.0 | Fork with extended core (GENDE-078) |
| **Per-operation logic** | Embedded in `PhpMaxGenerator.java` | Uses core's `operationTemplateFiles()` |
| **Purpose** | Quick iteration, full control | Production-ready, upstream compatible |
| **Maintenance** | Self-contained | Benefits from upstream updates |
| **Status** | Working (166 tests pass) | Planned |

**Both generators are maintained.** They serve different purposes:
- **php-max**: Proven working, used for experimentation
- **New generator**: Clean architecture, long-term solution

### Dependencies

| Dependency | Required For | Status |
|------------|--------------|--------|
| GENDE-078 (Fork contribution) | Core `operationTemplateFiles()` API | In Progress |
| Fork branch `feat/per-operation-templates` | Can use before upstream merge | Ready |
## 3. Solution Analysis

### Architecture
```
openapi-generator (core with per-operation support)
        ↓
new-generator (extends core, Laravel templates embedded)
        ↓
    ┌───────────────┬─────────────────┬──────────────┐
    ↓               ↓                 ↓              ↓
 Laravel         Symfony            Slim          (future)
 (default)      (external)       (external)
```

### Generator Name
TBD - options: `php-contract`, `php-laravel-contract`, or other

## 4. Ticket Breakdown

### Phase 1: Generator Foundation (4 tickets)
| Ticket | Description | Depends On |
|--------|-------------|------------|
| GENDE-089 | Design generator architecture and naming | - |
| GENDE-090 | Create generator project structure | GENDE-089 |
| GENDE-091 | Implement base generator class | GENDE-090 |
| GENDE-092 | Configure files.json for per-operation generation | GENDE-091 |

### Phase 2: Laravel - Default Templates (15 tickets)
| Ticket | Description | Depends On |
|--------|-------------|------------|
| GENDE-093 | Create Laravel controller template (per-operation) | GENDE-092 |
| GENDE-094 | Create Laravel model template | GENDE-092 |
| GENDE-095 | Create Laravel handler interface template (per-tag) | GENDE-092 |
| GENDE-096 | Create Laravel request templates (FormRequest + DTO) | GENDE-092 |
| GENDE-097 | Create Laravel response templates | GENDE-092 |
| GENDE-098 | Create Laravel routes template | GENDE-092 |
| GENDE-099 | Create Laravel service provider template | GENDE-092 |
| GENDE-100 | Create Laravel integration test project | GENDE-099 |
| GENDE-101 | Generate TicTacToe library | GENDE-100 |
| GENDE-102 | Generate Petshop library | GENDE-101 |
| GENDE-103 | Create TicTacToe handler implementations | GENDE-101 |
| GENDE-104 | Create Petshop handler implementations | GENDE-102 |
| GENDE-105 | Create TicTacToe integration tests | GENDE-103 |
| GENDE-106 | Create Petshop integration tests | GENDE-104 |
| GENDE-107 | Verify Laravel PHPStan level 6 compliance | GENDE-106 |

### Phase 3: Symfony - External Templates (8 tickets)
| Ticket | Description | Depends On |
|--------|-------------|------------|
| GENDE-108 | Create Symfony external templates directory | GENDE-092 |
| GENDE-109 | Create Symfony controller template | GENDE-108 |
| GENDE-110 | Create Symfony model and request/response templates | GENDE-109 |
| GENDE-111 | Create Symfony routes and services templates | GENDE-110 |
| GENDE-112 | Create Symfony integration test project | GENDE-111 |
| GENDE-113 | Generate and integrate Symfony libraries (both specs) | GENDE-112 |
| GENDE-114 | Create Symfony integration tests (both specs) | GENDE-113 |
| GENDE-115 | Verify Symfony PHPStan level 6 compliance | GENDE-114 |

### Phase 4: Slim - External Templates (8 tickets)
| Ticket | Description | Depends On |
|--------|-------------|------------|
| GENDE-116 | Create Slim external templates directory | GENDE-092 |
| GENDE-117 | Create Slim controller (action) template | GENDE-116 |
| GENDE-118 | Create Slim model and request/response templates | GENDE-117 |
| GENDE-119 | Create Slim routes and dependencies templates | GENDE-118 |
| GENDE-120 | Create Slim integration test project | GENDE-119 |
| GENDE-121 | Generate and integrate Slim libraries (both specs) | GENDE-120 |
| GENDE-122 | Create Slim integration tests (both specs) | GENDE-121 |
| GENDE-123 | Verify Slim PHPStan level 6 compliance | GENDE-122 |

### Phase 5: Documentation (1 ticket)
| Ticket | Description | Depends On |
|--------|-------------|------------|
| GENDE-124 | Create documentation for new generator and features | GENDE-107,GENDE-115,GENDE-123 |

### Dependency Graph
```
GENDE-089 → 090 → 091 → 092 ─┬─→ Phase 2 (Laravel: 093-107) ──┐
                             ├─→ Phase 3 (Symfony: 108-115) ──┼─→ GENDE-124 (Docs)
                             └─→ Phase 4 (Slim: 116-123) ─────┘
```

**Total: 36 tickets**

## 5. Acceptance Criteria

- [ ] New generator builds and runs
- [ ] Laravel: both specs generate, tests pass
- [ ] Symfony: both specs generate, tests pass
- [ ] Slim: both specs generate, tests pass
- [ ] All generated code passes PHPStan level 6

## 6. Dependencies

| Dependency | Status | Notes |
|------------|--------|-------|
| GENDE-078 | In Progress | Core changes (can use fork until merged) |

## 7. Current State
**Last Updated:** 2026-01-07

| Phase | Status |
|-------|--------|
| Phase 1: Generator | Pending |
| Phase 2: Laravel | Pending |
| Phase 3: Symfony | Pending |
| Phase 4: Slim | Pending |

### Fork Verification (2026-01-07)

✅ **Fork changes verified as fully applicable to all tickets.**

**Core API available from fork (commit `5958d5f9d9c`):**

| Component | Purpose |
|-----------|---------|
| `TemplateFileType.Operation` | Enum for per-operation templates |
| `operationTemplateFiles()` | Map to store operation template configs |
| Per-operation loop | Generates one file per operation |
| `resolveOperationFilename()` | Resolves `{{operationIdPascalCase}}` patterns |
| `enrichOperation()` | Adds `operationIdPascalCase`, `hasBodyParam`, `isGet`, etc. |
| `enrichPropertyConstraints()` | Adds `hasMinLength`, `isEmail`, etc. |

**Generator Configuration Method:**
```java
// In generator's processOpts() method:
operationTemplateFiles.put("controller.mustache", 
    "{{operationIdPascalCase}}Controller.php");
```

**Available filename patterns:**
- `{{operationId}}`, `{{operationIdPascalCase}}`, `{{operationIdCamelCase}}`
- `{{httpMethod}}`, `{{httpMethodLower}}`, `{{pathSanitized}}`

**Next Actions:**
1. Start GENDE-089 (Design generator architecture)
2. Continue GENDE-078 series (upstream contribution)