---
code: GENDE-131
status: Implemented
dateCreated: 2026-01-09T00:00:00.000Z
type: Bug Fix
priority: High
relatedTickets: GENDE-077
---

# Fix routes template controller namespace inconsistency

## 1. Description

The generated `routes/api.php` file references controllers with incorrect namespace `\PetshopApi\Controller\*`, but the actual controllers are generated with namespace `\PetshopApi\Api\Http\Controllers\*`.

## 2. Problem Details

**Current behavior (incorrect):**
```php
// routes/api.php
Route::delete('/pets/{id}', \PetshopApi\Controller\DeletePetController::class)
Route::get('/pets', \PetshopApi\Controller\FindPetsController::class)
```

**Expected behavior:**
```php
// routes/api.php
Route::delete('/pets/{id}', \PetshopApi\Api\Http\Controllers\DeletePetController::class)
Route::get('/pets', \PetshopApi\Api\Http\Controllers\FindPetsController::class)
```

**Controller file location and namespace:**
- File: `app/Http/Controllers/FindPetsController.php`
- Namespace: `PetshopApi\Api\Http\Controllers`

## 3. Root Cause

The routes template (`api.mustache` or similar) is using the wrong namespace pattern for controller references. It appears to be using a legacy `Controller` namespace instead of the proper `Api\Http\Controllers` namespace.

## 4. Files to Investigate

- `openapi-generator-server-templates/openapi-generator-server-php-max-default/api.mustache` (routes template)
- `openapi-generator-server-templates/openapi-generator-server-php-max-default/controller.mustache` (controller template)
- Check namespace variables in generator: `controllerPackage`, `apiPackage`, etc.

## 5. Solution

Update the routes template to use the correct controller namespace pattern that matches the generated controller files.

## 6. Acceptance Criteria
- [x] Routes file references correct controller namespace `\{invokerPackage}\Api\Http\Controllers\*`
- [x] Generated routes work without "class not found" errors
- [x] PHPStan passes on routes file
- [x] All integration tests pass after fix (92 tests, 158 assertions)

**Fixed:** 2026-01-09

**Root cause:** The `routes.mustache` template used `{{controllerPackage}}` which defaults to `{invokerPackage}\Controller`, but the PSR-4 autoload maps controllers to `{invokerPackage}\Api\Http\Controllers`.

**Solution:** Updated `openapi-generator-server-templates/openapi-generator-server-php-max-default/routes.mustache` line 34 to use hardcoded namespace pattern:
```mustache
# Before:
\{{controllerPackage}}\{{vendorExtensions.operationIdPascalCase}}Controller::class

# After:
\{{invokerPackage}}\Api\Http\Controllers\{{vendorExtensions.operationIdPascalCase}}Controller::class
```

**Verification:**
- PHPStan level 6: ✅ 0 errors
- Integration tests: ✅ 92 tests, 158 assertions
## 7. Impact

**High** - This bug causes runtime errors when trying to access any API endpoint because Laravel cannot find the controller classes.
