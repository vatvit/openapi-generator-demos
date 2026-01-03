---
code: GENDE-050
status: Proposed
dateCreated: 2026-01-04T18:00:00.000Z
type: Bug Fix
priority: High
relatedTickets: GENDE-043,GENDE-044,GENDE-045,GENDE-046
---

# Fix Slim handler namespace generation

## 1. Description

The Slim handler.mustache template generates files with incorrect namespace. The handler files use `Handler\` as the namespace instead of the configured `handlerPackage` value (e.g., `PetshopApi\Handler\`).

**Generated code:**
```php
namespace Handler;

class AddPetHandler implements RequestHandlerInterface
```

**Expected code:**
```php
namespace PetshopApi\Handler;

class AddPetHandler implements RequestHandlerInterface
```

## 2. Rationale

The `handlerPackage` value appears to only contain `Handler` without the invoker package prefix. This causes PSR-4 autoloading issues and requires workarounds in composer.json.

## 3. Solution Analysis

**Investigation Needed:**
1. Check how `handlerPackage` is computed in PhpMaxGenerator.java
2. Verify if it should include the invoker package prefix
3. Compare with how other packages (apiPackage, modelPackage) are constructed

**Options:**
1. Fix generator to pass full namespace (invokerPackage + handlerPackage)
2. Fix template to concatenate invokerPackage and handlerPackage
3. Use different variable that contains full namespace

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/slim-max/handler.mustache`
- **Generator:** `openapi-generator-generators/php-max/src/main/java/org/openapitools/codegen/phpmax/PhpMaxGenerator.java`
- **Affected files:** `generated/php-max-slim/petshop/lib/Handler/*.php`

## 5. Acceptance Criteria

- [ ] Handler files generate with correct full namespace (e.g., `PetshopApi\Handler`)
- [ ] PSR-4 autoloading works without warnings
- [ ] All existing tests continue to pass
