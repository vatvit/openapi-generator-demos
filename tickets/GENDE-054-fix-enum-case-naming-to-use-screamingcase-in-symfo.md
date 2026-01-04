---
code: GENDE-054
status: Implemented
dateCreated: 2026-01-04T17:46:37.512Z
type: Bug Fix
priority: Low
relatedTickets: GENDE-048
---

# Fix enum case naming to use SCREAMING_CASE in Symfony templates

## 1. Description

The Symfony model.mustache template generates PHP enum cases using PascalCase naming, but PHP convention for enum cases is SCREAMING_SNAKE_CASE.

**Generated code:**
```php
enum GameStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
}
```

**Expected code:**
```php
enum GameStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
}
```

## 2. Rationale

PHP convention for enum cases follows the constant naming convention (SCREAMING_SNAKE_CASE). While PascalCase works, it's inconsistent with PHP community standards.

## 3. Solution Analysis

**Options:**
1. Template fix: Transform enum case names to SCREAMING_SNAKE_CASE in the template
2. Generator fix: Modify PhpMaxGenerator.java to provide a `nameInScreamingCase` variable
3. Keep as-is: PascalCase is valid PHP, just non-conventional

**Recommended:** Option 2 or keep as-is (low priority)

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/symfony-max/model.mustache`
- **Generator:** May need to add `nameInScreamingSnakeCase` variable to PhpMaxGenerator.java

## 5. Acceptance Criteria

- [ ] Enum cases use SCREAMING_SNAKE_CASE naming
- [ ] Integration tests pass for enum case naming