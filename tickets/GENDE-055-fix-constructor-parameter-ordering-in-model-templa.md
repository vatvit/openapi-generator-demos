---
code: GENDE-055
status: Implemented
dateCreated: 2026-01-05T23:19:43.197Z
type: Bug Fix
priority: Medium
---

# Fix constructor parameter ordering in model templates to avoid PHP deprecation warnings

## 1. Description

The model.mustache templates for all php-max frameworks generate constructors with optional parameters declared before required parameters, causing PHP 8.4 deprecation warnings.

**Example from Game model:**
```php
public function __construct(
    string $id,
    GameStatus $status,
    GameMode $mode,
    ?Player $playerX = null,     // optional
    ?Player $playerO = null,     // optional
    ?Mark $currentTurn = null,   // optional
    ?Winner $winner = null,      // optional
    array $board,                // REQUIRED - but comes after optional!
    \DateTime $createdAt,        // REQUIRED - but comes after optional!
    ?\DateTime $updatedAt = null,
    ?\DateTime $completedAt = null,
)
```

**PHP Warning:**
```
Optional parameter $playerX declared before required parameter $createdAt is implicitly treated as a required parameter
```

## 2. Rationale

PHP 8.0+ deprecated declaring optional parameters before required parameters. This causes deprecation warnings that clutter test output and will become errors in future PHP versions.

## 3. Solution Analysis

**Options:**
1. Sort parameters in template: required first, then optional
2. Sort in generator Java code before passing to template
3. Make all parameters optional with null defaults

**Recommended:** Option 2 - Sort in PhpMaxGenerator.java to ensure required parameters come before optional ones.

## 4. Implementation Specification

- **Generator:** `PhpMaxGenerator.java` - sort `model.vars` so required properties come first
- **Templates affected:** All model.mustache files (laravel-max, symfony-max, slim-max)

## 5. Acceptance Criteria

- [ ] No PHP deprecation warnings about parameter ordering
- [ ] All model constructors have required params before optional
- [ ] All integration tests pass without deprecation warnings