---
code: GENDE-052
status: Implemented
dateCreated: 2026-01-04T18:00:00.000Z
type: Bug Fix
priority: Low
relatedTickets: GENDE-043,GENDE-044
---

# Fix inconsistent namespace casing between specs

## 1. Description

Different OpenAPI specs generate with inconsistent namespace casing, making it confusing and error-prone when setting up autoloading.

**Examples:**
- TicTacToe spec → `TicTacToe\Api\` (PascalCase with internal caps)
- Petshop spec → `PetshopApi\Api\` (single word PascalCase)

## 2. Rationale

The namespace is derived from the `invokerPackage` configuration, which can be set differently for each spec. There's no standardization enforced.

- TicTacToe config: Uses default or different invokerPackage setting
- Petshop config: Uses `PetshopApi` as invokerPackage

## 3. Solution Analysis

**Recommended Convention:**
All invokerPackage values should follow pattern: `{SpecName}Api`
- `PetshopApi` ✓
- `TictactoeApi` (not `TicTacToe`)

**Actions:**
1. Document standard naming convention
2. Update config files to follow convention
3. Regenerate libraries with consistent naming

## 4. Implementation Specification

- **Config files:** `openapi-generator-generators/php-max/configs/slim-*.json`
- **Affected:** All generated libraries across all framework template sets

## 5. Acceptance Criteria

- [ ] Document standard naming convention in CLAUDE.md or similar
- [ ] Regenerate TicTacToe with consistent naming (`TictactoeApi`)
- [ ] Update all test project autoload configs
