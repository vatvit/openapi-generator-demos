---
code: GENDE-015
status: Implemented
dateCreated: 2026-01-01T14:14:28.227Z
type: Documentation
priority: Medium
relatedTickets: GENDE-003,GENDE-010
---

# Generator Research Guide - Standard Process Documentation

## 1. Description

### Problem Statement

We've established a repeatable process for investigating OpenAPI generators through GENDE-010 (php-laravel) and GENDE-003 (php-symfony). This process should be documented for future investigations.

### Goal

Create and maintain a research guide that documents:
1. Step-by-step investigation process
2. Artifact locations and naming conventions
3. Scoring methodology against GOAL_MAX.md
4. Decision criteria for custom generator investment

### Scope

- Document created at `openapi-generator-server-templates/GENERATOR-RESEARCH-GUIDE.md`
- Covers all 8 phases of investigation
- Includes commands, templates, and checklists
- Lists available generators for future research

## 2. Rationale

- **Repeatability** - Same process for any generator
- **Consistency** - Same artifacts and structure
- **Onboarding** - New contributors can follow guide
- **Reference** - Quick lookup for commands and structure

## 3. Solution Analysis

### Research Pipeline (8 Phases)

| Phase | Name | Artifacts |
|-------|------|----------|
| 1 | Extract Templates | `openapi-generator-server-{generator}-default/` |
| 2 | Generate Sample | `generated/{generator}/tictactoe/`, `petshop/` |
| 3 | Analyze vs Goals | Scoring table |
| 4 | Document Findings | `GENERATOR-ANALYSIS.md` |
| 5 | Custom Templates | `openapi-generator-server-{generator}/` |
| 6 | Demo Project | `projects/{framework}-api--{generator}--default/` |
| 7 | Integration Tests | `tests/` in demo project |
| 8 | Decision | Go/No-Go ticket |

## 4. Implementation Specification

### Deliverable

File: `openapi-generator-server-templates/GENERATOR-RESEARCH-GUIDE.md`

Contents:
- Overview diagram
- Phase-by-phase instructions
- Docker commands for each step
- GENERATOR-ANALYSIS.md template
- Artifact location reference
- Available generators list
- Completed investigations table

## 5. Acceptance Criteria

- [x] GENERATOR-RESEARCH-GUIDE.md created
- [x] All 8 phases documented
- [x] Commands for template extraction included
- [x] Commands for code generation included
- [x] Scoring template included
- [x] GENERATOR-ANALYSIS.md template included
- [x] Artifact locations documented
- [x] Available generators listed

## 6. Current State

**Status:** Implemented

**Location:** `openapi-generator-server-templates/GENERATOR-RESEARCH-GUIDE.md`

**Usage:** Follow this guide when investigating any new OpenAPI generator.