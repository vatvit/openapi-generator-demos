---
code: GENDE-056
status: Implemented
dateCreated: 2026-01-05T23:19:43.263Z
type: Bug Fix
priority: Medium
---

# Fix per-TAG API interface class naming mismatch in Symfony templates

## 1. Description

The per-TAG API interface files in Symfony have a class name that doesn't match the filename, violating PSR-4 autoloading standards.

**Example:**
- File: `GameManagementApiHandlerInterface.php`
- Class inside: `interface GameManagementHandlerInterface` (missing 'Api' in class name)

This causes:
1. PSR-4 autoloading failures
2. Test skipped: `test_all_per_tag_handler_interfaces_exist`

## 2. Rationale

The per-TAG handler interface template generates class names without the 'Api' suffix that the filename has, creating a mismatch.

## 3. Solution Analysis

**Options:**
1. Fix template to include 'Api' in class name: `{{classname}}ApiHandlerInterface`
2. Fix file naming to exclude 'Api': `{{classname}}HandlerInterface.php`
3. Use files.json to control naming

**Recommended:** Option 1 - Update the template class name to match the filename pattern.

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/symfony-max/api-interface.mustache`
- **Change:** Update interface name from `{{classname}}HandlerInterface` to `{{classname}}ApiHandlerInterface`

## 5. Acceptance Criteria

- [ ] Class names match filenames per PSR-4 standard
- [ ] `test_all_per_tag_handler_interfaces_exist` test passes (not skipped)
- [ ] No composer autoload warnings for per-TAG interfaces