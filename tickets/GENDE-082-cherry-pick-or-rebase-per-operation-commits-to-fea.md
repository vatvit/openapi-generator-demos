---
code: GENDE-082
status: Implemented
dateCreated: 2026-01-07T16:05:46.254Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Prepare Branch
relatedTickets: GENDE-078,GENDE-081
dependsOn: GENDE-081
implementationDate: 2026-01-07
implementationNotes: Commit 9df587cd7c6 cherry-picked to feat/per-operation-templates (new hash: 5958d5f9d9c). Core tests pass: 22 tests, 0 failures.
---

# Cherry-pick or rebase per-operation commits to feature branch

## 1. Description

Move the per-operation template commits from local master to the new feature branch.

## 2. Rationale

- Keep commits clean and focused
- Separate feature commits from any other local changes
- Enable clean PR history

## 3. Solution Analysis

### Option A: Cherry-pick (Recommended)
```bash
# Find commit hashes for per-operation changes
git log --oneline master | head -20

# Cherry-pick specific commits
git cherry-pick <commit-hash>
```

### Option B: Interactive Rebase
```bash
git rebase -i upstream/master
# Select only per-operation commits
```

### Commits to Include
| Commit | Description |
|--------|-------------|
| `9df587cd7c6` | feat(core): add per-operation template generation support |
| (others?) | Any additional related commits |

## 4. Implementation Specification

### Steps
1. Identify all commits related to per-operation feature
2. Checkout feature branch
3. Cherry-pick commits in order
4. Resolve any conflicts
5. Verify build still works

### Commands
```bash
git checkout feat/per-operation-templates
git cherry-pick 9df587cd7c6
# Add more commits if needed

# Verify
git log --oneline -5
mvn test -pl modules/openapi-generator-core -DskipTests=false
```

## 5. Acceptance Criteria

- [ ] All per-operation commits are on feature branch
- [ ] Commits are clean (no unrelated changes)
- [ ] `mvn compile` succeeds
- [ ] Core tests still pass