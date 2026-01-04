---
code: GENDE-048
status: Implemented
dateCreated: 2026-01-03T18:00:00.000Z
type: Bug Fix
priority: High
relatedTickets: GENDE-036,GENDE-037,GENDE-038
implementationDate: 2026-01-04
implementationNotes: Fixed array type syntax in handler.mustache, api-interface.mustache, controller.mustache, api.mustache, and model.mustache templates. Used {{#isArray}}array{{/isArray}}{{^isArray}}{{dataType}}{{/isArray}} pattern. Also fixed map types and mixed types. All PHP files now pass syntax validation.
---

# Fix array type syntax in php-max Symfony handler templates

## 1. Description

The `handler.mustache` template in php-max Symfony templates generates invalid PHP syntax for array parameters.

**Generated code:**
```php
public function findPets(
    string[]|null $tags = null,  // INVALID - PHP syntax error
    int|null $limit = null,
): FindPets200Response|FindPets0Response;
```

**Expected code:**
```php
public function findPets(
    array|null $tags = null,  // VALID
    int|null $limit = null,
): FindPets200Response|FindPets0Response;
```

## 2. Rationale

PHP does not support typed array syntax like `string[]` - it only supports `array`. The template uses `{{dataType}}` which outputs `string[]` for array types.

## 3. Solution Analysis

**Options:**
1. Template fix: Add conditional logic to replace `string[]`, `int[]`, etc. with `array`
2. Generator fix: Modify PhpMaxGenerator.java to output `array` instead of typed arrays
3. Post-processing: Add a sed/regex replacement step after generation

**Recommended:** Option 1 - Template fix using `{{#isArray}}array{{/isArray}}{{^isArray}}{{dataType}}{{/isArray}}`

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/symfony-max/handler.mustache`
- **Affected file example:** `generated/php-max-symfony/petshop/src/Handler/FindPetsApiHandlerInterface.php`

## 5. Acceptance Criteria

- [ ] Array parameters generate as `array|null` not `string[]|null`
- [ ] Generated handler interfaces pass PHP syntax check (`php -l`)
- [ ] PHPUnit tests pass without manual fixes
