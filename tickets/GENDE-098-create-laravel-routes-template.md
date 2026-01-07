---
code: GENDE-098
status: Implemented
dateCreated: 2026-01-07T16:39:57.213Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Laravel routes template

## 1. Description

Create the routes.mustache template for Laravel route registration.

## 2. Rationale

Generated routes:
- Map paths to controllers
- Apply middleware
- Follow Laravel conventions

## 3. Solution Analysis

### Routes Pattern
```php
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::post('/pets', CreatePetController::class);
    Route::get('/pets', FindPetsController::class);
    Route::get('/pets/{petId}', GetPetByIdController::class);
});
```

### Template Variables Used
- `operations` (all operations)
- `path`
- `httpMethod`
- `operationIdPascalCase`

## 4. Implementation Specification

### Template Location
`src/main/resources/{generator-name}/routes.mustache`

### Supporting Files Type
This is a `SupportingFiles` template (generated once, not per operation).

## 5. Acceptance Criteria

- [ ] All operations have routes
- [ ] Correct HTTP methods
- [ ] Path parameters mapped correctly
- [ ] Valid Laravel route syntax