# CLAUDE_FLOW.md

Structured workflow for ticket creation and implementation using MDT (Markdown Tickets).

## Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                    BEFORE IMPLEMENTATION                         │
├─────────────────────────────────────────────────────────────────┤
│  mdt:requirements → mdt:assess → mdt:architecture →             │
│  mdt:clarification → mdt:tasks                                  │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                       IMPLEMENTATION                             │
├─────────────────────────────────────────────────────────────────┤
│  mdt:implement → mdt:tech-debt                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## Phase 1: Before Implementation

These steps prepare a ticket for implementation. A ticket can stay in this phase indefinitely until ready for work.

### mdt:requirements

**Purpose:** Define what needs to be done and why.

**Actions:**
1. Read the ticket fully (`mcp__mdt-all__get_cr`)
2. Identify the problem statement
3. Define success criteria
4. List functional requirements (what the system SHALL do)
5. List non-functional requirements (performance, security, etc.)

**Update Ticket Sections:**
- `## 1. Description` - Clear problem statement
- `## 2. Rationale` - Why this is needed
- `## 5. Acceptance Criteria` - Measurable conditions

**Output:** Ticket has clear requirements that can be validated.

---

### mdt:assess

**Purpose:** Understand current state and what exists.

**Actions:**
1. Explore codebase for relevant files (`Glob`, `Grep`, `Read`)
2. Check related tickets (`mcp__mdt-all__list_crs`)
3. Identify existing components that can be reused
4. Document current state vs desired state
5. Identify risks and blockers

**Update Ticket Sections:**
- `## Current State` - What exists now
- `## Dependencies` - What this depends on
- `## Risks` - What could go wrong

**Output:** Clear understanding of starting point and gaps.

---

### mdt:architecture

**Purpose:** Design the solution approach.

**Actions:**
1. Evaluate solution options
2. Consider trade-offs (complexity, maintainability, performance)
3. Choose approach with justification
4. Define component boundaries
5. Identify integration points

**Update Ticket Sections:**
- `## 3. Solution Analysis` - Options and chosen approach
- `## 4. Implementation Specification` - Technical details

**Output:** Clear technical design that can be implemented.

---

### mdt:clarification

**Purpose:** Resolve ambiguities before implementation.

**Actions:**
1. List assumptions made
2. Identify unclear requirements
3. Ask user for clarification (`AskUserQuestion`)
4. Document decisions made
5. Update ticket with answers

**Update Ticket Sections:**
- Add clarifications to relevant sections
- Document decisions in `## Architecture Decisions` if significant

**Output:** All ambiguities resolved, ready for task breakdown.

---

### mdt:tasks

**Purpose:** Break down into implementable units.

**Actions:**
1. Create subtasks/child tickets for complex work
2. Define task dependencies
3. Estimate complexity (not time)
4. Assign priorities
5. Update epic/parent ticket with task list

**Tools:**
- `mcp__mdt-all__create_cr` - Create subtasks
- `mcp__mdt-all__update_cr_attrs` - Set dependencies

**Update Ticket Sections:**
- `## Tasks` or `## Ticket Breakdown` - Task list with dependencies

**Output:** Actionable task list, ready for implementation.

---

## Phase 2: Implementation

These steps execute the work defined in Phase 1.

### mdt:implement

**Purpose:** Execute the implementation with tests.

**Actions:**

#### Step 1: Setup
1. Update ticket status to "In Progress"
2. Read "Current State" section for context
3. Create todo list (`TodoWrite`)

#### Step 2: Write Tests First (TDD when applicable)
1. Create test file(s) for the feature
2. Write failing tests that define expected behavior
3. Run tests to confirm they fail

#### Step 3: Implement
1. Write minimal code to pass tests
2. Run tests frequently
3. Refactor while keeping tests green

#### Step 4: Verify
1. Run full test suite
2. Run static analysis (PHPStan, etc.)
3. Manual verification if needed

#### Step 5: Complete
1. Update ticket "Current State" with results
2. Update ticket status to "Implemented"
3. Add implementation notes

**Tools:**
- `Bash` - Run tests, build commands
- `Edit`, `Write` - Create/modify code
- `TodoWrite` - Track progress
- `mcp__mdt-all__update_cr_status` - Update status
- `mcp__mdt-all__manage_cr_sections` - Update Current State

**Output:** Working implementation with passing tests.

---

### mdt:tech-debt

**Purpose:** Address technical debt discovered during implementation.

**Actions:**
1. Document tech debt found during implementation
2. Assess severity (critical, high, medium, low)
3. Create tickets for significant items
4. Fix minor items inline if quick
5. Update parent ticket with tech debt references

**Decision Matrix:**

| Severity | Time to Fix | Action |
|----------|-------------|--------|
| Critical | Any | Fix now |
| High | < 30 min | Fix now |
| High | > 30 min | Create ticket |
| Medium | < 15 min | Fix now |
| Medium | > 15 min | Create ticket |
| Low | Any | Create ticket |

**Tools:**
- `mcp__mdt-all__create_cr` with `type: "Technical Debt"`

**Output:** Tech debt documented or resolved.

---

## Quick Reference

### Command Summary

| Command | Phase | Purpose |
|---------|-------|---------|
| `mdt:requirements` | Before | Define what and why |
| `mdt:assess` | Before | Understand current state |
| `mdt:architecture` | Before | Design solution |
| `mdt:clarification` | Before | Resolve ambiguities |
| `mdt:tasks` | Before | Break down work |
| `mdt:implement` | During | Execute with tests |
| `mdt:tech-debt` | During | Handle debt |

### Ticket Status Flow

```
Proposed → Approved → In Progress → Implemented
                ↓
            Rejected
                ↓
            On Hold
```

### Minimum Viable Ticket

A ticket is ready for implementation when it has:
- [ ] Clear description (what problem it solves)
- [ ] Acceptance criteria (how to verify done)
- [ ] Solution approach (how to implement)
- [ ] No blocking dependencies

---

## Usage Examples

### Example 1: New Feature Ticket

```
User: "Create a ticket for adding dark mode"

Claude:
1. mdt:requirements - Define dark mode requirements
2. mdt:assess - Check existing theme system
3. mdt:architecture - Design theme switching approach
4. mdt:clarification - Ask about default theme, persistence
5. mdt:tasks - Break into: component, state, CSS, tests
```

### Example 2: Bug Fix Ticket

```
User: "Fix the login timeout issue"

Claude:
1. mdt:requirements - Define expected vs actual behavior
2. mdt:assess - Find related code, logs, previous fixes
3. mdt:architecture - Identify root cause and fix approach
4. mdt:implement - Write test reproducing bug, fix, verify
```

### Example 3: Implementation Session

```
User: "Implement GENDE-083"

Claude:
1. Read ticket with mcp__mdt-all__get_cr
2. Check "Current State" for context
3. mdt:implement:
   - Update status to "In Progress"
   - Write tests
   - Implement
   - Run tests
   - Update "Current State"
   - Update status to "Implemented"
4. mdt:tech-debt - Create tickets for any debt found
```

---

## Integration with CLAUDE.md

This flow supplements the MDT workflow in CLAUDE.md:

- **Session Start:** Read ticket → Check "Current State"
- **During Work:** Follow mdt:* commands as needed
- **Session End:** Update "Current State" → Update status

The flow commands are guidelines, not strict requirements. Use judgment based on ticket complexity and context.
