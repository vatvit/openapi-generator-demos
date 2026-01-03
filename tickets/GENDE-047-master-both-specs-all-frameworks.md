---
code: GENDE-047
status: Open
dateCreated: 2026-01-03T12:45:00.000Z
type: Epic
priority: High
relatedTickets: GENDE-030,GENDE-031,GENDE-032,GENDE-033,GENDE-034,GENDE-035,GENDE-036,GENDE-037,GENDE-038,GENDE-039,GENDE-040,GENDE-041,GENDE-042,GENDE-043,GENDE-044,GENDE-045,GENDE-046
---

# Master: Both specs for all frameworks

## 1. Goal

Generate and test both TicTacToe and Petshop APIs for all frameworks (Laravel, Symfony, Slim).

## 2. Ticket Summary

### Laravel (4 tickets)
| Ticket | Description | Status | Blocked By |
|--------|-------------|--------|------------|
| GENDE-032 | Fix Petshop namespace and regenerate | Open | - |
| GENDE-033 | Integrate Petshop API | Open | GENDE-032 |
| GENDE-034 | Create Petshop handlers | Open | GENDE-033 |
| GENDE-035 | Add Petshop tests | Open | GENDE-034 |

### Symfony (3 tickets)
| Ticket | Description | Status | Blocked By |
|--------|-------------|--------|------------|
| GENDE-036 | Generate Petshop library | Open | - |
| GENDE-037 | Integrate Petshop API | Open | GENDE-036 |
| GENDE-038 | Add Petshop tests | Open | GENDE-037 |

### Slim (8 tickets)
| Ticket | Description | Status | Blocked By |
|--------|-------------|--------|------------|
| GENDE-039 | Complete controller template | Open | - |
| GENDE-040 | Complete handler and model templates | Open | - |
| GENDE-041 | Complete routes and config templates | Open | - |
| GENDE-042 | Generate TicTacToe library | Open | GENDE-039,040,041 |
| GENDE-043 | Generate Petshop library | Open | GENDE-039,040,041 |
| GENDE-044 | Create integration test project | Open | GENDE-042,043 |
| GENDE-045 | Add TicTacToe tests | Open | GENDE-044 |
| GENDE-046 | Add Petshop tests | Open | GENDE-044 |

### Bug Fixes (2 tickets)
| Ticket | Description | Status |
|--------|-------------|--------|
| GENDE-030 | Fix Symfony per-TAG handler naming | Open |
| GENDE-031 | Unskip Symfony test | Blocked by GENDE-030 |

## 3. Dependency Graph

```
Laravel:
  GENDE-032 → GENDE-033 → GENDE-034 → GENDE-035

Symfony:
  GENDE-030 (bug fix, optional)
  GENDE-036 → GENDE-037 → GENDE-038

Slim:
  GENDE-039 ─┐
  GENDE-040 ─┼→ GENDE-042 ─┐
  GENDE-041 ─┘  GENDE-043 ─┴→ GENDE-044 → GENDE-045
                                       → GENDE-046
```

## 4. Recommended Execution Order

**Phase 1 - Quick wins (can run in parallel):**
- GENDE-032 (Laravel: fix namespace)
- GENDE-036 (Symfony: generate petshop)
- GENDE-039, 040, 041 (Slim: complete templates)

**Phase 2 - Integration:**
- GENDE-033 (Laravel: integrate)
- GENDE-037 (Symfony: integrate)
- GENDE-042, 043 (Slim: generate libs)

**Phase 3 - Handlers & Project setup:**
- GENDE-034 (Laravel: handlers)
- GENDE-044 (Slim: create project)

**Phase 4 - Testing:**
- GENDE-035 (Laravel: tests)
- GENDE-038 (Symfony: tests)
- GENDE-045, 046 (Slim: tests)

## 5. Current State

| Framework | TicTacToe | Petshop |
|-----------|-----------|---------|
| Laravel | ✅ Tested (69) | ❌ Namespace bug |
| Symfony | ✅ Tested (37) | ❌ Not generated |
| Slim | ⚠️ Partial | ❌ Not started |
