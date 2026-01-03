---
code: GENDE-032
status: Done
dateCreated: 2026-01-03T12:45:00.000Z
dateCompleted: 2026-01-03T13:00:00.000Z
type: Bug Fix
priority: High
relatedTickets: GENDE-033
---

# Laravel: Fix Petshop namespace and regenerate

## 1. Description

The Petshop library was generated with wrong namespace (`TictactoeApi` instead of `PetshopApi`). Fix the generation config and regenerate.

## 2. Current Problem

```php
// routes/api.php comment says:
// Note: petshop excluded - has wrong namespace (TictactoeApi instead of PetshopApi)
```

## 3. Tasks

- [ ] Check petshop generation config in `openapi-generator-configs/`
- [ ] Fix namespace settings (`invokerPackage`, etc.)
- [ ] Regenerate petshop library to `generated/php-max-laravel/petshop/`
- [ ] Verify files have correct `PetshopApi` namespace
- [ ] Run PHP syntax check on generated code

## 4. Resolution

**No action needed** - The petshop library was already correctly generated with `PetshopApi` namespace.
The comment in `routes/api.php` was outdated.

Verified:
- All models use `PetshopApi\Model` namespace
- All handlers use `PetshopApi\Api\Handlers` namespace
- All controllers use `PetshopApi\Api\Http\Controllers` namespace
- All files pass PHP syntax check

## 5. Acceptance Criteria

- [x] Petshop library uses `PetshopApi` namespace consistently
- [x] All generated files pass PHP syntax check
- [x] Ready for integration (GENDE-033)
