---
code: GENDE-030
status: Open
dateCreated: 2026-01-03T12:00:00.000Z
type: Bug Fix
priority: Medium
relatedTickets: GENDE-027,GENDE-031
---

# Fix Symfony per-TAG handler interface class/filename mismatch

## 1. Description

The php-max generator with Symfony templates produces per-TAG handler interface files where the class name does not match the filename, violating PSR-4 autoloading.

**Current state (BUG):**
- File: `GameManagementApiHandlerInterface.php`
- Class: `interface GameManagementHandlerInterface` (missing "Api")

**Desired state:**
- File: `GameManagementApiHandlerInterface.php`
- Class: `interface GameManagementApiHandlerInterface` (names match)

## 2. Affected Files

All per-TAG handler interfaces in Symfony templates:
- `GameManagementApiHandlerInterface.php` → class `GameManagementHandlerInterface`
- `GameplayApiHandlerInterface.php` → class `GameplayHandlerInterface`
- `StatisticsApiHandlerInterface.php` → class `StatisticsHandlerInterface`
- `TicTacApiHandlerInterface.php` → class `TicTacHandlerInterface`

## 3. Root Cause

The Symfony `api.mustache` template uses different naming patterns for:
- **Filename**: Uses `{{classname}}ApiHandlerInterface` pattern
- **Class declaration**: Uses `{{classname}}HandlerInterface` pattern (missing "Api")

## 4. Impact

- PSR-4 autoloading fails for these classes
- Composer `dump-autoload` shows warnings:
  ```
  Class TictactoeApi\Api\Handler\GameManagementHandlerInterface located in
  .../GameManagementApiHandlerInterface.php does not comply with psr-4
  ```
- Per-TAG handler interfaces cannot be type-hinted or used in DI

## 5. Solution

Update the Symfony `api.mustache` template to use consistent naming:

```mustache
{{! Current - WRONG }}
interface {{classname}}HandlerInterface

{{! Fixed - CORRECT }}
interface {{classname}}ApiHandlerInterface
```

## 6. Artifact Locations

- **Template file**: `openapi-generator-server-templates/php-max/symfony/api.mustache`
- **Generated output**: `generated/php-max-symfony/tictactoe/src/Handler/`
- **Integration tests**: `projects/symfony-api--symfony-max--integration-tests/`

## 7. Acceptance Criteria

- [ ] Per-TAG handler interface class names match their filenames
- [ ] `composer dump-autoload` shows no PSR-4 warnings for Handler interfaces
- [ ] Per-TAG interfaces can be successfully autoloaded and type-hinted
- [ ] GENDE-031 test can be unskipped and passes
