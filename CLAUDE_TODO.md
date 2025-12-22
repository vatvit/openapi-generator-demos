# Project TODO

This document contains project plans for comparing OpenAPI generators and Makefile improvement findings.

---

## 🎯 Project Goal: Compare OpenAPI Generators

**Objective:** Compare different OpenAPI **generators** by customizing their templates to produce **Laravel-compatible packages**.

### Key Concept:

- **Same Target:** All projects use **Laravel** as the integration framework
- **Different Generators:** php-laravel, php-lumen, (future: php-symfony, etc.)
- **Custom Templates:** Each generator gets custom templates to output Laravel-compatible code
- **Independent Projects:** Each project is a separate Laravel application for isolated testing

### Why Compare Generators?

The `php-laravel` generator has limitations (e.g., cannot generate separate files per operation). Other generators might have different capabilities. By customizing templates to target Laravel, we can objectively compare:

1. Generator flexibility and features
2. Template customization capabilities
3. Code generation quality
4. PSR-4 compliance
5. Ease of integration

---

## 📁 Project Naming Convention

**Format:** `laravel-api--{generator-name}--{template-approach}`

**Examples:**
- `laravel-api--php-laravel--replaced-tags` - Uses **php-laravel** generator with **custom templates**
- `laravel-api--php-lumen--laravel-templates` - Uses **php-lumen** generator with **Laravel-compatible templates**

**Explanation:**
1. **laravel-api** - All projects use Laravel as foundation
2. **{generator-name}** - Which OpenAPI generator is used (php-laravel, php-lumen, php-symfony, etc.)
3. **{template-approach}** - Description of template customization approach

---

## 📊 Current Projects

### 1. laravel-api--php-laravel--replaced-tags

**Status:** ✅ Complete and Working

**Generator:** OpenAPI Generator's `php-laravel`

**Templates:** Custom templates at `openapi-generator-server-templates/openapi-generator-server-php-laravel/`

**Architecture:**
- Interface-first approach
- Per-operation interface files (PSR-4 compliant)
- Response factories for type safety
- Dependency injection bindings
- Tag preprocessing (replaces tags with operationId)

**Integration:**
- Generated packages: `PetStoreApiV2\Server\*`, `TicTacToeApiV2\Server\*`
- Output: `generated/php-laravel/petstore/`, `generated/php-laravel/tictactoe/`
- Laravel app integrates both via PSR-4 autoload
- Business logic in `app/Api/PetStore/`, `app/Api/TicTacToe/`

**Commands:**
- `make generate-server` - Generate both APIs
- `make start-laravel` - Start on port 8000
- `make test-laravel-phpunit` - Run tests

**Key Files:**
- Configs: `projects/laravel-api--php-laravel--replaced-tags/openapi-generator-configs/`
- Docker: Port 8000, MySQL 3306, Redis 6379
- Database: `laravel_api`

---

### 2. laravel-api--php-lumen--laravel-templates

**Status:** 🚧 In Progress (Phase 4 Complete - Templates Created)

**Generator:** OpenAPI Generator's `php-lumen` (but targeting **Laravel**, not Lumen!)

**Templates:** Custom Laravel-compatible templates at `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/`

**Goal:** Test if `php-lumen` generator can produce Laravel-compatible packages when using custom templates.

**Why php-lumen generator?**
- Different codebase than php-laravel
- Might have different capabilities/limitations
- Interesting to see if it can target Laravel via templates

**Architecture (Planned):**
- Interface-first approach (similar to php-laravel project)
- Laravel-compatible packages (not Lumen apps!)
- Same namespaces: `PetStoreApiV2\Server\*`, `TicTacToeApiV2\Server\*`
- Same integration pattern as php-laravel project

**Integration (Planned):**
- Output: `generated/php-lumen/petstore/`, `generated/php-lumen/tictactoe/`
- Laravel app integrates both via PSR-4 autoload
- Business logic in `app/Api/PetStore/`, `app/Api/TicTacToe/`

**Commands:**
- `make generate-lumen-laravel` - Generate both APIs
- `make start-lumen-laravel` - Start on port 8001
- `make test-lumen-laravel-phpunit` - Run tests

**Key Files:**
- Configs: `projects/laravel-api--php-lumen--laravel-templates/openapi-generator-configs/`
- Docker: Port 8001, MySQL 3307, Redis 6380
- Database: `lumen_laravel_api`
- Container names: `lumen-laravel-*`

**Important:** This is a **Laravel** application, NOT a Lumen application. We're just using the php-lumen **generator** with custom templates.

---

## 🚀 php-lumen Generator Project - Implementation Plan

### ✅ Phase 1: Project Setup (COMPLETED)

- [x] Copy Laravel project structure
- [x] Rename to `laravel-api--php-lumen--laravel-templates`
- [x] Update Docker configuration (ports, container names, database)
- [x] Update `.env` and `.env.example`
- [x] Update project Makefile

### ✅ Phase 2: Generator Setup (COMPLETED)

- [x] Update `openapi-generator-generators/php-lumen/Makefile` to support `TEMPLATE_PATH`
- [x] Create generator config files:
  - `petshop-lumen-laravel-config.json`
  - `tictactoe-lumen-laravel-config.json`
- [x] Update root Makefile with new targets

### ✅ Phase 3: Custom Template Creation (COMPLETED)

**Goal:** Create Laravel-compatible templates for php-lumen generator

**Created Templates:**
- [x] `api.mustache` - Generates API interfaces (not implementations)
- [x] `model.mustache` - Generates model classes
- [x] `routes.mustache` - Generates route definitions
- [x] `composer.mustache` - Generates package metadata

**Template Location:** `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/`

**Status:** Templates created and tested. They generate interfaces but also include extra Lumen files (app/, bootstrap/, etc.) which can be ignored.

### ✅ Phase 4: Generate and Verify Packages (COMPLETED)

**Tasks:**
- [x] Generate PetStore package: `make generate-lumen-laravel-petshop`
- [x] Generate TicTacToe package: `make generate-lumen-laravel-tictactoe`
- [x] Verify generated structure:
  - [x] Check `generated/php-lumen/petstore/lib/Api/` contains interfaces
  - [x] Check `generated/php-lumen/tictactoe/lib/Api/` contains interfaces
  - [x] Verify namespaces (ISSUES FOUND - see below)
- [x] Review generated code quality
- [x] Identify template improvements needed

**Generated Output:**
```
generated/php-lumen/
├── petstore/
│   └── lib/
│       ├── Api/
│       │   ├── AddPetApi.php (interface)
│       │   ├── DeletePetApi.php (interface)
│       │   ├── FindPetByIdApi.php (interface)
│       │   └── FindPetsApi.php (interface)
│       ├── routes/web.php
│       ├── composer.json
│       └── [extra Lumen app files]
└── tictactoe/
    └── lib/
        ├── Api/
        │   ├── CreateGameApi.php (interface)
        │   ├── DeleteGameApi.php (interface)
        │   ├── GetBoardApi.php (interface)
        │   ├── GetGameApi.php (interface)
        │   ├── GetLeaderboardApi.php (interface)
        │   ├── GetMovesApi.php (interface)
        │   ├── GetPlayerStatsApi.php (interface)
        │   ├── GetSquareApi.php (interface)
        │   ├── ListGamesApi.php (interface)
        │   └── PutSquareApi.php (interface)
        ├── routes/web.php
        ├── composer.json
        └── [extra Lumen app files]
```

**Issues Found:**

### 🔴 CRITICAL Issues

1. **Duplicated Namespace in Generated Code**
   - **Location:** All API interface files and routes
   - **Expected:** `PetStoreApiV2\Server\Api\FindPetsApiInterface`
   - **Actual:** `PetStoreApiV2\Server\PetStoreApiV2\Server\Api\FindPetsApiInterface`
   - **Root Cause:** The `apiPackage` config includes full namespace, but php-lumen generator prepends `invokerPackage` again
   - **Solution Options:**
     - Option A: Change config to use relative package: `"apiPackage": "Api"` instead of `"apiPackage": "PetStoreApiV2\\Server\\Api"`
     - Option B: Investigate if php-lumen generator has a flag to disable auto-prefixing
   - **Files Affected:** `generated/php-lumen/*/lib/Api/*.php`, `generated/php-lumen/*/lib/routes/web.php`
   - **Impact:** HIGH - Code won't autoload correctly with PSR-4

2. **Wrong Route Parameter Type**
   - **Location:** `routes.mustache` line 34
   - **Issue:** `function ({{#pathParams}}\Laravel\Lumen\Routing\Router ${{paramName}}...`
   - **Problem:** Route parameters are typed as `\Laravel\Lumen\Routing\Router` which is incorrect
   - **Solution:** Remove type hint: `function ({{#pathParams}}${{paramName}}...`
   - **Example:** Generated `function (\Laravel\Lumen\Routing\Router $gameId)` should be `function ($gameId)`
   - **Impact:** HIGH - Routes will fail when invoked

### 🟡 MODERATE Issues

3. **Composer Package Name Has Double Vendor**
   - **Location:** `generated/php-lumen/*/lib/composer.json`
   - **Actual:** `"name": "vatvit/vatvit/petstore-lumen-laravel"`
   - **Expected:** `"name": "vatvit/petstore-lumen-laravel"`
   - **Root Cause:** `composerVendorName` appears twice in generated name
   - **Impact:** MEDIUM - Package name format is invalid for Packagist

4. **Extra Lumen Application Files Generated**
   - **Location:** `generated/php-lumen/*/lib/app/`, `lib/bootstrap/`, `lib/public/`, `lib/storage/`, etc.
   - **Issue:** Full Lumen app structure generated (not just package files)
   - **Impact:** LOW - Can be ignored but bloats output
   - **Note:** This is expected behavior for php-lumen generator default templates

5. **No Models Generated**
   - **Location:** `generated/php-lumen/*/lib/Models/` directory missing
   - **Expected:** Model classes like `Pet.php`, `Game.php`, etc.
   - **Root Cause:** Either specs don't define models, or model template not being triggered
   - **Impact:** MEDIUM - Model DTOs would be useful for type safety

**Recommendations:**

**Immediate Action Required (Before Phase 5):**
1. Fix namespace duplication by testing config option A (`"apiPackage": "Api"`)
2. Fix route parameter type hint in `routes.mustache`

**Optional Improvements:**
3. Investigate composer package name generation
4. Check why models aren't being generated
5. Consider creating .openapi-generator-ignore to exclude unwanted Lumen app files

**Status:** ✅ Generation successful with critical issues identified and documented. Issues fixed in Phase 4.5.

### ✅ Phase 4.5: Fix Critical Issues (COMPLETED)

**Both critical issues have been resolved:**

1. **Fix Namespace Duplication** ✅
   - [x] Updated config files to use `"apiPackage": "Api"` instead of full namespace
   - [x] Regenerated both packages
   - [x] Verified namespaces are correct
   - **Result:** Interfaces now use `PetStoreApiV2\Server\Api\*` and `TicTacToeApiV2\Server\Api\*` (no duplication)

2. **Fix Route Parameter Type** ✅
   - [x] Edited `routes.mustache` line 34 to remove `\Laravel\Lumen\Routing\Router` type hint
   - [x] Regenerated both packages
   - [x] Verified routes have correct parameter signatures
   - **Result:** Route closures now use `function ($id)` instead of `function (\Laravel\Lumen\Routing\Router $id)`

**Files Modified:**
- `projects/laravel-api--php-lumen--laravel-templates/openapi-generator-configs/petshop-lumen-laravel-config.json`
- `projects/laravel-api--php-lumen--laravel-templates/openapi-generator-configs/tictactoe-lumen-laravel-config.json`
- `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/routes.mustache`

**Verification Results:**
- ✅ PetStore interfaces: `PetStoreApiV2\Server\Api\AddPetApi`, etc. (namespaces correct)
- ✅ TicTacToe interfaces: `TicTacToeApiV2\Server\Api\CreateGameApi`, etc. (namespaces correct)
- ✅ Route parameters: `function ($id)`, `function ($gameId)`, etc. (type hints removed)

### ✅ Phase 4.6: Fix PSR-4 Naming Compliance (COMPLETED)

**Issue Found:** Filename and interface name mismatch
- **Problem:** File `DeleteGameApi.php` contained `interface DeleteGameApiInterface`
- **Impact:** PSR-4 violation - autoloader cannot find the interface

**Solution:**
- Removed "Interface" suffix from template to use just `{{classname}}`
- Changed `interface {{classname}}Interface` to `interface {{classname}}`
- Updated routes to reference `{{classname}}` instead of `{{classname}}Interface`

**Files Modified:**
- `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/api.mustache`
- `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/routes.mustache`

**Verification Results:**
- ✅ File: `DeleteGameApi.php` → Interface: `DeleteGameApi`
- ✅ File: `FindPetsApi.php` → Interface: `FindPetsApi`
- ✅ Routes use: `TicTacToeApiV2\Server\Api\DeleteGameApi::class`
- ✅ Full namespace with correct interface: `PetStoreApiV2\Server\Api\FindPetsApi`

**Note:** While the interface names no longer have "Interface" suffix (which would be clearer), this matches php-lumen generator conventions and ensures PSR-4 compliance. The DocBlock clearly states it's an interface.

### ✅ Phase 4.7: Clean Up Unnecessary Files (COMPLETED)

**Issue:** php-lumen generator creates full Lumen application structure (app/, bootstrap/, database/, etc.) which is not needed for a Laravel-compatible package.

**Solution:** Added automatic cleanup commands to Makefile

**Changes Made:**
1. Created custom `.openapi-generator-ignore` template (prevents file overwrites on subsequent generations)
2. Added cleanup commands to `generate-lumen-laravel-petshop` and `generate-lumen-laravel-tictactoe` targets in root Makefile
3. Cleanup removes:
   - `lib/app/`, `lib/bootstrap/`, `lib/database/`, `lib/public/`, `lib/resources/`, `lib/storage/`, `lib/tests/`
   - `lib/.env.example`, `lib/artisan`, `lib/phpunit.xml`, `lib/.editorconfig`, `lib/.styleci.yml`

**Files Modified:**
- `Makefile` - Added cleanup steps to generation targets
- `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/openapi-generator-ignore.mustache` - Created custom ignore template

**Remaining Package Structure:**
```
generated/php-lumen/petstore/lib/
├── Api/ (4 interface files)
├── routes/web.php
├── composer.json
├── .gitignore
└── readme.md
```

```
generated/php-lumen/tictactoe/lib/
├── Api/ (10 interface files)
├── routes/web.php
├── composer.json
├── .gitignore
└── readme.md
```

**Verification:**
- ✅ PetStore: Only package files remain (Api/, routes/, composer.json, .gitignore, readme.md)
- ✅ TicTacToe: Only package files remain (Api/, routes/, composer.json, .gitignore, readme.md)
- ✅ No Lumen application files present
- ✅ Cleanup runs automatically on every generation

### 🔄 Phase 5: Laravel Integration (NEXT STEP)

**Prerequisites:** ✅ All critical issues fixed (Phases 4.5, 4.6, and 4.7 completed).

**Tasks:**
- [ ] Update `composer.json` autoload:
  ```json
  "autoload": {
      "psr-4": {
          "App\\": "app/",
          "PetStoreApiV2\\Server\\": "../../generated/php-lumen/petstore/lib/",
          "TicTacToeApiV2\\Server\\": "../../generated/php-lumen/tictactoe/lib/"
      }
  }
  ```
- [ ] Run `make dumpautoload-lumen-laravel`
- [ ] Create business logic implementations in `app/Api/`
- [ ] Register dependency injection bindings in `AppServiceProvider`
- [ ] Test that interfaces are properly resolved

### 🔄 Phase 6: Testing (NOT STARTED)

**Tasks:**
- [ ] Create PHPUnit tests for both APIs
- [ ] Test endpoint integration
- [ ] Verify dependency injection works
- [ ] Ensure all operations are accessible
- [ ] Compare test results with php-laravel project

---

## 🔮 Future Generator Projects (Ideas)

### php-symfony Generator

**Project Name:** `laravel-api--php-symfony--laravel-templates`

**Goal:** Test if php-symfony generator can target Laravel

**Why:** Symfony generator might have different capabilities

**Status:** Not started

### Other Potential Generators

- `php` (generic PHP generator)
- Custom generator built specifically for Laravel
- Community-contributed generators

---

## 📊 Comparison Goals

After completing php-lumen and potentially other generator projects:

### 1. Generator Capabilities

**Compare:**
- Can each generator produce separate files per operation?
- PSR-4 compliance out of the box
- Template flexibility
- Configuration options
- Code generation quality

### 2. Template Customization

**Compare:**
- How easy is it to customize templates?
- What aspects can be controlled via templates?
- Template debugging and maintenance
- Documentation quality

### 3. Integration Complexity

**Compare:**
- How difficult is Laravel integration for each?
- Required boilerplate code
- Dependency injection patterns
- Route registration approaches

### 4. Code Quality

**Compare:**
- Type safety
- Documentation generation
- PHPDoc quality
- Naming conventions
- Code organization

### 5. Developer Experience

**Compare:**
- IDE support and autocompletion
- Error messages
- Debugging ease
- Regeneration workflow

### 6. Maintenance

**Compare:**
- How easy is it to update specs and regenerate?
- Impact on existing implementations
- Breaking change handling
- Version migration

---

## ⚠️ Important Principles

### 1. Project Independence

**Each project is COMPLETELY INDEPENDENT:**

- `laravel-api--php-laravel--replaced-tags` - Do NOT modify when working on php-lumen project
- `laravel-api--php-lumen--laravel-templates` - Do NOT modify when working on php-laravel project
- Future projects - Each stands alone

**Why?**
- Clean comparison requires isolation
- Different generators might need different Laravel configurations
- Prevents cross-contamination of approaches

### 2. Same Laravel Foundation

**All projects use Laravel as the base:**
- Same framework version
- Same architectural patterns (interface-first, DI, etc.)
- Same OpenAPI specs (petshop, tictactoe)
- Only the **generator** changes

**Why?**
- Fair comparison
- Focus on generator differences, not framework differences

### 3. Custom Templates Required

**Default templates generate full applications, NOT packages:**
- Default php-lumen templates → Full Lumen app
- Default php-symfony templates → Full Symfony app
- We need CUSTOM templates to generate Laravel-compatible packages

**Why?**
- We want packages to integrate into ONE Laravel app
- Default generators assume standalone applications
- Custom templates give us control over output structure

---

## 🎯 Success Criteria

### Per Project

- [ ] Generates Laravel-compatible packages (not full apps)
- [ ] Both PetStore and TicTacToe APIs integrate into ONE Laravel app
- [ ] All endpoints accessible and functional
- [ ] PHPUnit tests pass with 100% coverage
- [ ] Can run alongside other generator projects (different ports)

### Overall

- [ ] Clear documentation of each generator's strengths/weaknesses
- [ ] Comparison matrix showing capabilities
- [ ] Recommendations for when to use each generator
- [ ] Template examples for community use

---

# Makefile Improvement TODO

This section contains findings from Makefile analysis and suggested improvements. Items are organized by priority and Makefile location.

---

## 🔴 CRITICAL PRIORITY - Must Fix

### 1. Generator Makefile: Hardcoded project path violates separation of concerns

**Location:** `/openapi-generator-generators/php-laravel/Makefile` lines 46, 54

**Issue:** Config path is hardcoded to specific project:
```makefile
-c /local/projects/laravel-api--php-laravel--replaced-tags/openapi-generator-configs/$(CONFIG)
```

**Problem:**
- Generator Makefile should NOT reference specific projects
- Violates separation of concerns documented in CLAUDE.md
- Can't reuse this generator for other projects

**Solution Options:**
```makefile
# Option 1: Require full path from caller
CONFIG_PATH := $(CONFIG)  # Caller provides full path like "projects/foo/configs/config.json"

# Option 2: Standard location within generator directory
CONFIG_PATH := configs/$(CONFIG)  # Configs live with generator

# Option 3: Accept CONFIG_PATH as separate parameter
ifndef CONFIG_PATH
	$(error CONFIG_PATH is required. Example: CONFIG_PATH=projects/laravel-api/openapi-generator-configs/config.json)
endif
```

**Status:** ✅ FIXED in php-lumen generator (uses CONFIG_PATH parameter)

---

### 2. Generator Makefile: Platform-specific sed command

**Location:** `/openapi-generator-generators/php-laravel/Makefile` line 120

**Issue:**
```makefile
sed -i '' 's/OPENAPI_GENERATOR_VERSION := .*/OPENAPI_GENERATOR_VERSION := $(VERSION)/' Makefile
```

**Problem:** `sed -i ''` is macOS-specific, fails on Linux (needs `sed -i` without empty string)

**Solution:**
```makefile
# Portable approach - works on both macOS and Linux
sed -i.bak 's/OPENAPI_GENERATOR_VERSION := .*/OPENAPI_GENERATOR_VERSION := $(VERSION)/' Makefile && rm Makefile.bak
```

**Status:** ✅ FIXED in php-lumen generator

---

## 🟡 HIGH PRIORITY - Should Fix

### 5. Root Makefile: Hardcoded paths limit scalability

**Location:** `/Makefile` lines 52-58, 62-68, 141-173

**Issue:**
- `openapi-generator-generators/php-laravel` hardcoded in multiple places
- `projects/laravel-api--php-laravel--replaced-tags` repeated 10+ times

**Problem:** Adding new generators or projects requires editing many lines

**Solution:**
```makefile
# Add at top of file
GENERATOR_PHP_LARAVEL := openapi-generator-generators/php-laravel
PROJECT_LARAVEL_DEMO := projects/laravel-api--php-laravel--replaced-tags

# Then use variables:
generate-petshop:
	@$(MAKE) -C $(GENERATOR_PHP_LARAVEL) generate \
		SPEC_NAME=petshop \
		# ... rest

setup-laravel:
	@$(MAKE) -C $(PROJECT_LARAVEL_DEMO) setup
```

---

### 6. Root Makefile: No Docker availability check

**Location:** `/Makefile` - all docker commands

**Issue:** All docker commands assume Docker is running

**Problem:** Cryptic errors if Docker daemon isn't running

**Solution:**
```makefile
# Add helper target
.PHONY: check-docker
check-docker:
	@docker info >/dev/null 2>&1 || (echo "❌ Docker is not running. Please start Docker."; exit 1)

# Add as dependency to targets that need it
validate-spec: check-docker
	@echo "📋 Validating PetStore OpenAPI specification..."
	# ... rest
```

---

## 🟢 MEDIUM PRIORITY - Nice to Have

*(Other Makefile improvements from previous analysis remain here...)*

---

**Last Updated:** 2025-12-22
**Analysis Date:** 2025-12-22
