---
code: GENDE-033
status: Done
dateCreated: 2026-01-03T12:45:00.000Z
dateCompleted: 2026-01-03T13:05:00.000Z
type: Integration
priority: High
relatedTickets: GENDE-032,GENDE-034
blockedBy: GENDE-032
---

# Laravel: Integrate Petshop API into project

## 1. Description

Add Petshop API to the existing Laravel integration test project. Configure autoloading and routes.

## 2. Tasks

- [ ] Add Petshop namespace mappings to `composer.json`:
  ```json
  "PetshopApi\\Model\\": "../../generated/php-max-laravel/petshop/app/Models/",
  "PetshopApi\\Api\\Http\\": "../../generated/php-max-laravel/petshop/app/Http/",
  "PetshopApi\\Api\\Handlers\\": "../../generated/php-max-laravel/petshop/app/Handlers/"
  ```
- [ ] Uncomment petshop routes in `routes/api.php`
- [ ] Run `composer dump-autoload`
- [ ] Verify no autoload errors

## 3. Resolution

- Petshop namespace mappings were already in composer.json
- Uncommented petshop routes in `routes/api.php`
- Ran `composer dump-autoload` - 5644 classes loaded
- All 69 TicTacToe tests pass

## 4. Acceptance Criteria

- [x] Petshop classes autoload correctly
- [x] Routes registered without conflicts
- [x] Existing TicTacToe tests still pass
