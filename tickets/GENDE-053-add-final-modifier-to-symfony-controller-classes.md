---
code: GENDE-053
status: Implemented
dateCreated: 2026-01-04T17:46:37.240Z
type: Bug Fix
priority: Low
relatedTickets: GENDE-048
---

# Add final modifier to Symfony controller classes

## 1. Description

The Symfony controller.mustache template generates controller classes without the `final` modifier. Best practice in Symfony is to mark controllers as `final` to prevent inheritance.

**Generated code:**
```php
class CreateGameController
{
    // ...
}
```

**Expected code:**
```php
final class CreateGameController
{
    // ...
}
```

## 2. Rationale

Symfony best practices recommend marking controllers as `final` because:
- Controllers should not be extended
- Prevents accidental inheritance chains
- Makes the code intent clear

## 3. Solution Analysis

**Fix:** Add `final` keyword to the controller class definition in the template.

Change from:
```mustache
class {{classname}}
```

To:
```mustache
final class {{classname}}
```

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/symfony-max/controller.mustache`
- **Change:** Add `final` modifier before `class` keyword

## 5. Acceptance Criteria

- [ ] Generated controller classes have `final` modifier
- [ ] Integration tests pass for controller finality check