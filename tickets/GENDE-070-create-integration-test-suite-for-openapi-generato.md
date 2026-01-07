---
code: GENDE-070
status: Implemented
dateCreated: 2026-01-07T10:46:31.064Z
type: Feature Enhancement
priority: High
implementationDate: 2026-01-07
implementationNotes: All 6 phases complete. Fork validated (3628 tests pass). Unified make commands: test-max-all, test-max-laravel, test-max-symfony, test-max-slim, validate-fork. Total 166 tests, 305 assertions across all frameworks.
---

# Create Integration Test Suite for OpenAPI Generator Fork Verification
## 1. Description

Create a comprehensive integration test suite to verify the OpenAPI Generator fork with per-operation template generation support (commit `9df587cd7c6`). This ensures backward compatibility and validates the new features work correctly across multiple PHP frameworks.

### Problem Statement
The fork adds significant new functionality (per-operation templates, property constraints, empty file cleanup) that needs verification before:
- Using in production
- Creating a PR to upstream OpenAPI Generator

### Scope
- Backward compatibility verification
- php-max generator creation using the fork
- Multi-framework integration (Laravel, Symfony, Slim)
- Template adaptation for each framework
- Automated test suite
- Two API specs (petshop, tictactoe) per framework

## 2. Rationale

### Why This Is Needed
1. **Risk Mitigation** - Fork changes core generator logic; must verify no regressions
2. **Feature Validation** - New per-operation generation needs real-world testing
3. **Multi-Framework Proof** - Demonstrate framework-agnostic design works
4. **Upstream PR Preparation** - Integration tests strengthen contribution case

### Success Criteria
- All existing OpenAPI Generator tests pass (backward compatibility)
- php-max generator builds and runs with fork
- Each framework (Laravel, Symfony, Slim) generates valid code
- Both specs (petshop, tictactoe) work for each framework
- Automated tests pass for all integrations

## 3. Solution Analysis

### Approach

| Phase | Description | Deliverable |
|-------|-------------|-------------|
| 1. Fork Validation | Run OpenAPI Generator test suite | Test report |
| 2. Generator Setup | Build php-max with fork dependency | Working generator |
| 3. Laravel Integration | Use existing templates, verify generation | Laravel test project |
| 4. Symfony Integration | Adapt templates from Laravel | Symfony test project |
| 5. Slim Integration | Adapt templates from Laravel | Slim test project |
| 6. Test Automation | PHPUnit tests for all integrations | CI-ready test suite |

### Framework Template Strategy

```
php-max/src/main/resources/php-max/  (Laravel - default)
    ↓ copy & adapt
openapi-generator-server-php-max-symfony/  (external)
    ↓ copy & adapt  
openapi-generator-server-php-max-slim/  (external)
```

## 4. Implementation Specification

### 4.1 Phase 1: Fork Validation (Backward Compatibility)

```bash
cd openapi-generator
mvn test -pl modules/openapi-generator-core
mvn test -pl modules/openapi-generator
```

**Acceptance:** All existing tests pass

### 4.2 Phase 2: php-max Generator with Fork

```xml
<!-- pom.xml dependency -->
<dependency>
  <groupId>org.openapitools</groupId>
  <artifactId>openapi-generator</artifactId>
  <version>LOCAL-FORK</version>
</dependency>
```

**Verify:**
- `templateType: Operation` works
- `{{operationIdPascalCase}}` resolves
- Empty file cleanup functions
- Property constraint flags available

### 4.3 Phase 3: Laravel Integration

| Component | Source | Action |
|-----------|--------|--------|
| Templates | `php-max/src/main/resources/php-max/` | Use as-is |
| Test Project | `projects/laravel-api--php-max--fork-test/` | Create new |
| Specs | petshop.yaml, tictactoe.yaml | Generate both |

**Tests:**
- Route registration
- Controller invocation
- Request validation
- Response transformation
- Handler interface contracts

### 4.4 Phase 4: Symfony Integration

| Component | Source | Action |
|-----------|--------|--------|
| Templates | Copy from Laravel, adapt | Create `openapi-generator-server-php-max-symfony/` |
| Test Project | `projects/symfony-api--php-max--fork-test/` | Create new |
| Specs | petshop.yaml, tictactoe.yaml | Generate both |

**Template Adaptations:**
- Controller → Symfony controller style
- Routes → `routes.yaml` format
- DI → `services.yaml` format
- Validation → Symfony Validator

### 4.5 Phase 5: Slim Integration

| Component | Source | Action |
|-----------|--------|--------|
| Templates | Copy from Laravel, adapt | Create `openapi-generator-server-php-max-slim/` |
| Test Project | `projects/slim-api--php-max--fork-test/` | Create new |
| Specs | petshop.yaml, tictactoe.yaml | Generate both |

**Template Adaptations:**
- Controller → Slim action style
- Routes → `routes.php` with Slim syntax
- DI → PHP-DI container
- Validation → Respect/Validation or custom

### 4.6 Phase 6: Test Automation

```
projects/
├── laravel-api--php-max--fork-test/
│   ├── tests/Feature/Petshop/
│   ├── tests/Feature/Tictactoe/
│   └── Makefile (test commands)
├── symfony-api--php-max--fork-test/
│   ├── tests/Functional/Petshop/
│   ├── tests/Functional/Tictactoe/
│   └── Makefile
└── slim-api--php-max--fork-test/
    ├── tests/Petshop/
    ├── tests/Tictactoe/
    └── Makefile
```

**Test Categories per Framework:**
1. Generation tests (files created correctly)
2. Syntax tests (PHP lint passes)
3. Static analysis (PHPStan level 6)
4. Unit tests (model serialization)
5. Integration tests (HTTP request/response)

## 5. Acceptance Criteria
### Backward Compatibility
- [x] OpenAPI Generator core tests pass
- [x] OpenAPI Generator module tests pass
- [x] Existing generators unaffected

### php-max Generator
- [x] Builds with fork dependency
- [x] Per-operation generation works
- [x] All new template variables available
- [x] Empty file cleanup works

### Laravel Integration
- [x] Petshop library generates
- [x] Tictactoe library generates
- [x] Integration tests pass (92 tests)
- [ ] PHPStan level 6 passes → GENDE-076

### Symfony Integration
- [x] Templates adapted from Laravel
- [x] Petshop library generates
- [x] Tictactoe library generates
- [x] Integration tests pass (61 tests)
- [ ] PHPStan level 6 passes → GENDE-076

### Slim Integration
- [x] Templates adapted from Laravel
- [x] Petshop library generates
- [x] Tictactoe library generates
- [x] Integration tests pass (13 tests)
- [ ] PHPStan level 6 passes → GENDE-076

### Automation
- [x] `make test-max-all` runs all framework tests
- [ ] `make generate-max-all` regenerates all libraries → GENDE-077
- ~~CI-ready~~ (removed from scope)
## 6. Dependencies

| Dependency | Status |
|------------|--------|
| GENDE-060: Operation enum | ✅ Implemented |
| GENDE-061: Per-operation loop | ✅ Implemented |
| GENDE-062: Template variables | ✅ Implemented |
| GENDE-063: Empty file cleanup | ✅ Implemented |
| GENDE-064: Property constraints | ✅ Implemented |
| GENDE-065: Documentation | ✅ Implemented |
| Fork commit `9df587cd7c6` | ✅ Committed locally |

## 7. Risks

| Risk | Mitigation |
|------|------------|
| Fork tests fail | Fix issues before proceeding |
| Template adaptation complex | Start with Laravel (already working) |
| Framework-specific edge cases | Document limitations per framework |

## 8. Estimated Effort
| Phase | Effort |
|-------|--------|
| Fork validation | 1-2 hours |
| Generator setup | 1 hour |
| Laravel integration | 2-3 hours |
| Symfony templates + integration | 4-6 hours |
| Slim templates + integration | 4-6 hours |
| Test automation | 2-3 hours |
| **Total** | **14-21 hours** |

### 9.1 Fork Validation Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-070-001 | When running `mvn test` on openapi-generator-core module, the system SHALL pass all existing tests | Must |
| FR-070-002 | When running `mvn test` on openapi-generator module, the system SHALL pass all existing tests | Must |
| FR-070-003 | When using existing generators (java, python, etc.) with the fork, the system SHALL produce identical output to upstream | Must |

### 9.2 php-max Generator Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-070-010 | When php-max generator is built with fork dependency, the system SHALL compile without errors | Must |
| FR-070-011 | When `templateType: Operation` is configured, the system SHALL generate one file per OpenAPI operation | Must |
| FR-070-012 | When `{{operationIdPascalCase}}` is used in destination filename, the system SHALL resolve to PascalCase operation ID | Must |
| FR-070-013 | When `{{operationIdCamelCase}}` is used in destination filename, the system SHALL resolve to camelCase operation ID | Must |
| FR-070-014 | When template output is whitespace-only, the system SHALL delete the generated file | Must |
| FR-070-015 | When property has constraints (minLength, maxLength, etc.), the system SHALL set corresponding `has*` flags in vendorExtensions | Must |
| FR-070-016 | When operation has parameters, the system SHALL set corresponding `has*Params` flags in vendorExtensions | Must |

### 9.3 Laravel Integration Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-070-020 | When generating Petshop spec with Laravel templates, the system SHALL create all required files (controllers, models, handlers, routes) | Must |
| FR-070-021 | When generating Tictactoe spec with Laravel templates, the system SHALL create all required files | Must |
| FR-070-022 | When generated Laravel code is linted with `php -l`, all files SHALL pass syntax check | Must |
| FR-070-023 | When generated Laravel code is analyzed with PHPStan level 6, the system SHALL report zero errors | Should |
| FR-070-024 | When Laravel integration tests are run, the system SHALL execute successfully with ≥90% pass rate | Must |
| FR-070-025 | When a request matches an OpenAPI operation, the system SHALL route to the correct controller | Must |
| FR-070-026 | When request body is provided, the system SHALL validate against OpenAPI schema constraints | Must |
| FR-070-027 | When handler returns response, the system SHALL transform via generated Resource classes | Must |

### 9.4 Symfony Integration Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-070-030 | When Symfony templates are created, they SHALL be adapted from Laravel templates | Must |
| FR-070-031 | When generating Petshop spec with Symfony templates, the system SHALL create Symfony-compatible controllers | Must |
| FR-070-032 | When generating Tictactoe spec with Symfony templates, the system SHALL create Symfony-compatible controllers | Must |
| FR-070-033 | When generated Symfony code is linted, all files SHALL pass syntax check | Must |
| FR-070-034 | When generated Symfony code is analyzed with PHPStan level 6, the system SHALL report zero errors | Should |
| FR-070-035 | When Symfony integration tests are run, the system SHALL execute successfully | Must |
| FR-070-036 | When routes are generated, they SHALL use Symfony `routes.yaml` format | Must |
| FR-070-037 | When DI configuration is generated, it SHALL use Symfony `services.yaml` format | Must |

### 9.5 Slim Integration Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-070-040 | When Slim templates are created, they SHALL be adapted from Laravel templates | Must |
| FR-070-041 | When generating Petshop spec with Slim templates, the system SHALL create Slim-compatible actions | Must |
| FR-070-042 | When generating Tictactoe spec with Slim templates, the system SHALL create Slim-compatible actions | Must |
| FR-070-043 | When generated Slim code is linted, all files SHALL pass syntax check | Must |
| FR-070-044 | When generated Slim code is analyzed with PHPStan level 6, the system SHALL report zero errors | Should |
| FR-070-045 | When Slim integration tests are run, the system SHALL execute successfully | Must |
| FR-070-046 | When routes are generated, they SHALL use Slim `$app->get/post/put/delete()` syntax | Must |
| FR-070-047 | When DI configuration is generated, it SHALL use PHP-DI container format | Must |

### 9.6 Test Automation Requirements

| ID | EARS Statement | Priority |
|----|----------------|----------|
| FR-070-050 | When `make test-all` is executed, the system SHALL run tests for all frameworks sequentially | Must |
| FR-070-051 | When `make generate-all` is executed, the system SHALL regenerate all libraries for all frameworks | Must |
| FR-070-052 | When `make test-laravel` is executed, the system SHALL run only Laravel tests | Must |
| FR-070-053 | When `make test-symfony` is executed, the system SHALL run only Symfony tests | Must |
| FR-070-054 | When `make test-slim` is executed, the system SHALL run only Slim tests | Must |
| FR-070-055 | When any test command fails, the system SHALL exit with non-zero status code | Must |
| FR-070-056 | When tests are run in Docker, all commands SHALL execute without host dependencies | Must |

## 10. Non-Functional Requirements

### 10.1 Compatibility

| ID | Requirement | Target | Priority |
|----|-------------|--------|----------|
| NFR-070-001 | Fork SHALL maintain 100% backward compatibility with upstream OpenAPI Generator | 100% | Must |
| NFR-070-002 | Generated code SHALL be compatible with PHP 8.1+ | PHP ≥8.1 | Must |
| NFR-070-003 | Laravel templates SHALL target Laravel 10/11 | Laravel 10+ | Must |
| NFR-070-004 | Symfony templates SHALL target Symfony 6/7 | Symfony 6+ | Must |
| NFR-070-005 | Slim templates SHALL target Slim 4 | Slim 4 | Must |

### 10.2 Quality

| ID | Requirement | Target | Priority |
|----|-------------|--------|----------|
| NFR-070-010 | Generated PHP code SHALL pass PHPStan level 6 | 0 errors | Should |
| NFR-070-011 | Generated PHP code SHALL follow PSR-12 coding standard | 0 violations | Should |
| NFR-070-012 | Test coverage per framework SHALL exceed 80% | ≥80% | Should |
| NFR-070-013 | All generated files SHALL have consistent code style | Automated check | Should |

### 10.3 Performance

| ID | Requirement | Target | Priority |
|----|-------------|--------|----------|
| NFR-070-020 | Code generation for single spec SHALL complete within 30 seconds | ≤30s | Should |
| NFR-070-021 | Full test suite per framework SHALL complete within 5 minutes | ≤5min | Should |
| NFR-070-022 | `make test-all` SHALL complete within 20 minutes | ≤20min | Should |

### 10.4 Maintainability

| ID | Requirement | Target | Priority |
|----|-------------|--------|----------|
| NFR-070-030 | Each framework's templates SHALL be self-contained in separate directory | Isolation | Must |
| NFR-070-031 | Test projects SHALL use Docker for reproducible environments | Docker | Must |
| NFR-070-032 | All make commands SHALL be documented in README | Docs | Should |
| NFR-070-033 | Template changes SHALL not require Java code changes | Decoupled | Must |

### 10.5 Portability

| ID | Requirement | Target | Priority |
|----|-------------|--------|----------|
| NFR-070-040 | Build and test SHALL work on macOS | macOS 12+ | Must |
| NFR-070-041 | Build and test SHALL work on Linux | Ubuntu 22.04+ | Must |
| NFR-070-042 | Build and test SHALL work in CI environment | GitHub Actions | Should |

## 11. Requirements Traceability
| Requirement | Phase | Verification Method |
|-------------|-------|---------------------|
| FR-070-001..003 | Phase 1: Fork Validation | `mvn test` output |
| FR-070-010..016 | Phase 2: Generator Setup | Unit tests (GENDE-071-074) |
| FR-070-020..027 | Phase 3: Laravel | PHPUnit integration tests |
| FR-070-030..037 | Phase 4: Symfony | PHPUnit functional tests |
| FR-070-040..047 | Phase 5: Slim | PHPUnit tests |
| FR-070-050..056 | Phase 6: Automation | Manual verification + CI |
| NFR-070-* | All phases | Automated checks + review |

### 12.1 Component Inventory

| Component | Location | Status | Fitness |
|-----------|----------|--------|---------|
| **OpenAPI Generator Fork** | `openapi-generator/` | Committed locally | ✅ Ready |
| **php-max Generator** | `openapi-generator-generators/php-max/` | Built | ✅ Ready |
| **Laravel Templates (embedded)** | `php-max/src/main/resources/php-max/` | 16 files | ✅ Ready |
| **Symfony Templates (external)** | `openapi-generator-server-php-max-symfony/` | 10 files | ⚠️ Partial |
| **Slim Templates (external)** | `openapi-generator-server-php-max-slim/` | 8 files | ⚠️ Partial |
| **Laravel Test Project** | `projects/laravel-api--laravel-max--integration-tests/` | 11 test files | ✅ Ready |
| **Symfony Test Project** | `projects/symfony-api--symfony-max--integration-tests/` | 7 test files | ⚠️ Basic |
| **Slim Test Project** | `projects/slim-api--slim-max--integration-tests/` | 2 test files | ❌ Minimal |

### 12.2 Fork Assessment

| Aspect | Status | Details |
|--------|--------|---------|
| **Commit** | ✅ | `9df587cd7c6` - per-operation template support |
| **Files Changed** | 6 | TemplateFileType, CodegenConfig, DefaultCodegen, DefaultGenerator, docs |
| **Lines Added** | 284 | Core logic + documentation |
| **Upstream Tests** | ⚠️ Unknown | 307 test files exist, need to verify pass |
| **Unit Tests** | ⚠️ Partial | Only TemplateFileTypeTest added (GENDE-071-074 pending) |

### 12.3 Template Fitness

#### Laravel Templates (Embedded - Default)

| Template | Lines | Completeness | Notes |
|----------|-------|--------------|-------|
| `controller.mustache` | 95 | ✅ Complete | Per-operation, __invoke pattern |
| `model.mustache` | 140 | ✅ Complete | Full DTO with fromArray/toArray |
| `api-interface.mustache` | 35 | ✅ Complete | Handler interface per tag |
| `form-request.mustache` | 20 | ✅ Complete | Laravel FormRequest |
| `resource.mustache` | 55 | ✅ Complete | Laravel Resource |
| `routes.mustache` | 95 | ✅ Complete | Route registration |
| `security-validator.mustache` | 210 | ✅ Complete | Auth middleware |
| `middleware-stub.mustache` | 260 | ✅ Complete | Security stubs |

**Verdict:** ✅ Production-ready

#### Symfony Templates (External)

| Template | Lines | Completeness | Notes |
|----------|-------|--------------|-------|
| `controller.mustache` | 65 | ⚠️ Basic | Needs response handling |
| `model.mustache` | Dispatcher | ✅ Complete | Routes to model_generic/enum |
| `model_generic.mustache` | 95 | ✅ Complete | Full DTO |
| `model_enum.mustache` | 8 | ✅ Complete | PHP 8.1 enum |
| `api.mustache` | 22 | ⚠️ Basic | Service class stub |
| `routes.yaml.mustache` | 30 | ✅ Complete | Symfony routes |
| `services.yaml.mustache` | 25 | ✅ Complete | DI config |

**Missing:** Form validation, Response DTOs, Security middleware
**Verdict:** ⚠️ Needs work (est. 4-6 hours)

#### Slim Templates (External)

| Template | Lines | Completeness | Notes |
|----------|-------|--------------|-------|
| `controller.mustache` | 80 | ⚠️ Basic | Action pattern |
| `model.mustache` | 80 | ⚠️ Basic | DTO without validation |
| `api.mustache` | 25 | ⚠️ Basic | Handler interface |
| `routes.mustache` | 40 | ⚠️ Basic | Slim route syntax |
| `dependencies.mustache` | 40 | ⚠️ Basic | PHP-DI setup |

**Missing:** Request validation, Response transformation, Security, Error handling
**Verdict:** ⚠️ Needs significant work (est. 6-8 hours)

### 12.4 Integration Test Projects

#### Laravel (`laravel-api--laravel-max--integration-tests`)

| Aspect | Status | Count/Details |
|--------|--------|---------------|
| Test Files | ✅ | 11 files |
| Test Classes | ✅ | ~15 classes |
| Assertions | ✅ | 157 assertions |
| Specs Tested | ⚠️ | TicTacToe ✅, Petshop partial |
| PHPStan | ⚠️ | Level 6, 10 warnings |
| Docker | ✅ | Configured |

**Verdict:** ✅ Good foundation, minor fixes needed

#### Symfony (`symfony-api--symfony-max--integration-tests`)

| Aspect | Status | Count/Details |
|--------|--------|---------------|
| Test Files | ⚠️ | 7 files |
| Test Classes | ⚠️ | ~8 classes |
| Specs Tested | ⚠️ | TicTacToe only |
| PHPStan | ❓ | Not configured |
| Docker | ✅ | Configured |

**Verdict:** ⚠️ Needs expansion (est. 3-4 hours)

#### Slim (`slim-api--slim-max--integration-tests`)

| Aspect | Status | Count/Details |
|--------|--------|---------------|
| Test Files | ❌ | 2 files |
| Test Classes | ❌ | Minimal |
| Specs Tested | ❌ | None complete |
| PHPStan | ❌ | Not configured |
| Docker | ⚠️ | Basic |

**Verdict:** ❌ Needs significant work (est. 6-8 hours)

### 12.5 Risk Assessment

| Risk | Likelihood | Impact | Mitigation |
|------|------------|--------|------------|
| Fork tests fail | Medium | High | Run `mvn test` first, fix issues |
| Symfony templates incomplete | High | Medium | Prioritize core templates |
| Slim templates incomplete | High | Medium | Can defer to later phase |
| Generator dependency version mismatch | Low | High | Use local Maven install |
| Docker environment differences | Low | Medium | Pin versions in docker-compose |

### 12.6 Effort Estimate by Component

| Component | Current State | Work Needed | Effort |
|-----------|---------------|-------------|--------|
| Fork validation | Ready | Run tests, fix issues | 1-2h |
| php-max generator | Ready | Verify with fork | 1h |
| Laravel templates | Complete | Minor fixes | 1h |
| Laravel tests | Good | Add Petshop tests | 2h |
| Symfony templates | Partial | Complete missing templates | 4-6h |
| Symfony tests | Basic | Expand test coverage | 3-4h |
| Slim templates | Partial | Complete all templates | 6-8h |
| Slim tests | Minimal | Create from scratch | 5-6h |
| Automation | None | Create Makefiles, CI | 2-3h |
| **Total** | | | **25-33h** |

### 12.7 Recommended Approach
**Phase 1: Validate Foundation (3-4h)**
1. Run fork tests (`mvn test`)
2. Verify php-max generator works
3. Run Laravel integration tests

**Phase 2: Complete Laravel (3-4h)**
1. Add Petshop handler implementations
2. Add Petshop integration tests
3. Fix PHPStan warnings

**Phase 3: Complete Symfony (7-10h)**
1. Add missing templates (validation, security)
2. Generate both specs
3. Create comprehensive tests

**Phase 4: Complete Slim (11-14h)**
1. Complete all templates
2. Generate both specs
3. Create test project from scratch

**Phase 5: Automation (2-3h)**
1. Create unified Makefile
2. Add CI configuration
3. Document all commands

| # | Decision | Options | Risk | Validation Needed |
|---|----------|---------|------|-------------------|
| 1 | Fork backward compatibility | Pass / Fail | High | Run upstream tests |
| 2 | php-max + fork integration | Local install / Published JAR | Medium | Build and generate |
| 3 | Per-operation variables availability | All available / Some missing | Medium | Generate and inspect |
| 4 | Symfony template approach | Adapt Laravel / Start fresh | Medium | Generate minimal spec |
| 5 | Slim DI container | PHP-DI / Pimple / Custom | Low | Test container setup |
| 6 | Test project structure | Shared / Separate per framework | Low | Compare approaches |

### 13.2 POC 1: Fork Backward Compatibility

**Question:** Do all existing OpenAPI Generator tests pass with our changes?

**Validation:**
```bash
cd openapi-generator

## 17. Current State
**Last Updated:** 2026-01-07
**Status:** Implemented (remaining items split to new tickets)

### Phase Status

| Phase | Description | Status | Notes |
|-------|-------------|--------|-------|
| Phase 1 | Fork Validation | **Complete** ✅ | 3628 tests pass |
| Phase 2 | Generator Verification | **Complete** ✅ | Done via GENDE-047 |
| Phase 3 | Laravel Integration | **Complete** ✅ | 92 tests, 157 assertions |
| Phase 4 | Symfony Integration | **Complete** ✅ | 61 tests, 126 assertions |
| Phase 5 | Slim Integration | **Complete** ✅ | 13 tests, 22 assertions |
| Phase 6 | Automation | **Complete** ✅ | Test commands done |

### Automation Commands

| Command | Description |
|---------|-------------|
| `make test-max-all` | Run all php-max tests |
| `make test-max-laravel` | Run Laravel tests only |
| `make test-max-symfony` | Run Symfony tests only |
| `make test-max-slim` | Run Slim tests only |
| `make validate-fork` | Validate fork (3628 tests) |

### Test Summary
- **Total:** 166 tests, 305 assertions (all passing)

### Split to New Tickets

| Ticket | Description | Priority |
|--------|-------------|----------|
| GENDE-076 | PHPStan level 6 verification for all frameworks | Medium |
| GENDE-077 | Add `make generate-max-all` command | Low |

### Removed from Scope
- CI configuration (GitHub Actions) - can be added later if needed
# Run core module tests
mvn test -pl modules/openapi-generator-core -DskipTests=false

# Run main module tests
mvn test -pl modules/openapi-generator -DskipTests=false
```

**Expected Result:** All tests pass

**Decision:** ✅ Proceed if >99% pass | ⚠️ Investigate if 95-99% | ❌ Fix if <95%

---

### 13.3 POC 2: php-max Generator with Fork

**Question:** Can php-max generator use the local fork successfully?

**Validation:**
```bash
cd openapi-generator
mvn install -DskipTests -pl modules/openapi-generator-core,modules/openapi-generator

cd ../openapi-generator-generators/php-max
mvn clean package -DskipTests

# Test generation
java -cp target/php-max-openapi-generator-1.0.0.jar:target/dependency/* \
  org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max \
  -i ../../openapi-generator-specs/petshop.yaml \
  -o /tmp/poc-test
```

**Verify:**
- [ ] Controllers generated (one per operation)
- [ ] Models generated
- [ ] Routes generated
- [ ] No Java exceptions

---

### 13.4 POC 3: Per-Operation Variable Availability

**Question:** Are all new template variables available?

**Validation:**
```bash
java -DdebugOperations -cp ... org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max -i petshop.yaml -o /tmp/debug 2>&1 | grep -E "operationId|hasBody|isPost"
```

**Variables to Check:**

| Variable | Expected |
|----------|----------|
| `vendorExtensions.operationIdPascalCase` | CreatePet, FindPets, etc. |
| `vendorExtensions.operationIdCamelCase` | createPet, findPets, etc. |
| `vendorExtensions.hasPathParams` | true/false |
| `vendorExtensions.hasQueryParams` | true/false |
| `vendorExtensions.hasBodyParam` | true/false |
| `vendorExtensions.isGet/isPost/etc` | true/false |

---

### 13.5 POC 4: Symfony Template Gap Analysis

**Question:** What's missing from Symfony templates?

**Validation:**
```bash
java -cp ... org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-symfony \
  -i openapi-generator-specs/petshop.yaml \
  -o /tmp/symfony-poc

# Check syntax
find /tmp/symfony-poc -name "*.php" -exec php -l {} \;
```

**Gap Checklist:**

| Component | Status | Notes |
|-----------|--------|-------|
| Controllers | ⬜ | |
| Models | ⬜ | |
| Handler Interfaces | ⬜ | |
| Request Validation | ⬜ | |
| Response DTOs | ⬜ | |
| Security Middleware | ⬜ | |
| Routes | ⬜ | |
| Services DI | ⬜ | |

---

### 13.6 POC 5: Slim DI Container Selection

**Question:** Which DI container for Slim?

**Options:**

| Container | Autowiring | Slim Support | Template Complexity |
|-----------|------------|--------------|---------------------|
| **PHP-DI** | ✅ Yes | ✅ Native | ✅ Simple |
| Pimple | ❌ No | ✅ Native | ⚠️ Verbose |
| League | ✅ Yes | ✅ PSR-11 | ⚠️ Medium |

**Recommendation:** PHP-DI (autowiring reduces boilerplate)

**Validation:**
```php
// Test PHP-DI with generated handler
$container = (new ContainerBuilder())
    ->addDefinitions([
        PetApiInterface::class => autowire(PetHandler::class),
    ])
    ->build();

$app = AppFactory::createFromContainer($container);
```

---

### 13.7 POC 6: Test Project Structure

**Question:** Shared vs independent test projects?

**Decision: Independent** (matches existing pattern)

```
projects/
├── laravel-api--php-max--fork-test/   # Self-contained
├── symfony-api--php-max--fork-test/   # Self-contained
└── slim-api--php-max--fork-test/      # Self-contained
```

**Rationale:**
- Each framework has unique requirements
- No coupling between frameworks
- Easier onboarding
- Matches existing project structure

---

### 13.8 POC Execution Order

| # | POC | Priority | Est. Time | Blocks |
|---|-----|----------|-----------|--------|
| 1 | Fork tests | **Critical** | 1h | Everything |
| 2 | Generator integration | **Critical** | 30m | Generation |
| 3 | Variable availability | High | 15m | Templates |
| 4 | Symfony gaps | Medium | 30m | Symfony work |
| 5 | Slim DI | Low | 15m | Slim work |
| 6 | Project structure | Low | N/A | Decision made |

### 13.9 POC Success Criteria
**All POCs pass if:**
- [ ] Fork tests: >99% pass rate
- [ ] Generator: Builds and generates without errors
- [ ] Variables: All 6 variable types present in output
- [ ] Symfony: Clear list of gaps with effort estimates
- [ ] Slim: DI container selected and validated
- [ ] Structure: Decision documented

| # | Decision | Choice | Rationale | Alternatives Rejected |
|---|----------|--------|-----------|----------------------|
| AD-01 | Generator dependency | Local Maven install | Fork not published; local install ensures version match | Published JAR (not available) |
| AD-02 | Template location | Embedded default + External override | Laravel embedded, Symfony/Slim external via `-t` flag | All embedded (inflexible), All external (no defaults) |
| AD-03 | Test project isolation | Fully independent projects | No coupling, framework-specific Docker configs | Shared base (too complex) |
| AD-04 | Generated code location | `generated/{framework}/{spec}/` | Clear separation by framework and spec | Single directory (conflicts) |
| AD-05 | Slim DI container | PHP-DI | Autowiring, Slim 4 native support | Pimple (manual), League (less common) |
| AD-06 | Test framework | PHPUnit for all | Standard, IDE support, CI integration | Pest (Laravel only), Codeception (heavy) |
| AD-07 | Static analysis | PHPStan level 6 | Catches type errors without being too strict | Level 8 (too strict), Level 4 (too lenient) |

### 14.2 Directory Structure

```
openapi-generator-demos/
├── openapi-generator/                    # Fork (submodule)
│   └── [upstream + our changes]
│
├── openapi-generator-generators/
│   └── php-max/                          # Custom generator
│       ├── src/main/java/                # Java code
│       ├── src/main/resources/php-max/   # Embedded Laravel templates (DEFAULT)
│       └── pom.xml
│
├── openapi-generator-server-templates/
│   ├── openapi-generator-server-php-max-symfony/   # External Symfony templates
│   │   ├── controller.mustache
│   │   ├── model.mustache
│   │   ├── files.json
│   │   └── README.md
│   └── openapi-generator-server-php-max-slim/      # External Slim templates
│       ├── controller.mustache
│       ├── model.mustache
│       ├── files.json
│       └── README.md
│
├── openapi-generator-specs/
│   ├── petshop.yaml                      # ~300 lines
│   └── tictactoe.yaml                    # ~500 lines
│
├── generated/                            # Generated libraries (gitignored)
│   ├── php-max-laravel/
│   │   ├── petshop/
│   │   └── tictactoe/
│   ├── php-max-symfony/
│   │   ├── petshop/
│   │   └── tictactoe/
│   └── php-max-slim/
│       ├── petshop/
│       └── tictactoe/
│
└── projects/                             # Integration test projects
    ├── laravel-api--php-max--fork-test/
    │   ├── app/Handlers/                 # Handler implementations
    │   ├── tests/Feature/                # Integration tests
    │   ├── docker-compose.yml
    │   ├── phpstan.neon
    │   └── Makefile
    ├── symfony-api--php-max--fork-test/
    │   ├── src/Handler/
    │   ├── tests/Functional/
    │   ├── docker-compose.yml
    │   ├── phpstan.neon
    │   └── Makefile
    └── slim-api--php-max--fork-test/
        ├── src/Handler/
        ├── tests/
        ├── docker-compose.yml
        ├── phpstan.neon
        └── Makefile
```

### 14.3 Size Limits & Constraints

#### Template Files

| Template Type | Max Lines | Max Complexity | Notes |
|---------------|-----------|----------------|-------|
| `controller.mustache` | 150 | Single class | One per-operation controller |
| `model.mustache` | 200 | Single class | DTO with fromArray/toArray |
| `api-interface.mustache` | 100 | Interface only | Handler contract per tag |
| `form-request.mustache` | 100 | Validation rules | Laravel only |
| `routes.mustache` | 150 | Route definitions | Framework-specific |
| `security-*.mustache` | 300 | Auth middleware | Can be complex |

#### Generated Code Per Spec

| Spec | Operations | Expected Files | Max Total Lines |
|------|------------|----------------|-----------------|
| petshop.yaml | 4 | ~25 files | ~2,000 |
| tictactoe.yaml | 10 | ~50 files | ~4,000 |

#### Test Projects

| Component | Max Files | Max Lines/File | Notes |
|-----------|-----------|----------------|-------|
| Handler implementations | 1 per tag | 200 | Business logic |
| Feature tests | 1 per operation | 150 | HTTP tests |
| Unit tests | As needed | 100 | Model tests |
| Docker config | 1 compose file | 100 | Services only |
| Makefile | 1 | 100 | Common commands |

### 14.4 Component Boundaries

```
┌─────────────────────────────────────────────────────────────────────┐
│                        GENERATION LAYER                              │
├─────────────────────────────────────────────────────────────────────┤
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────┐          │
│  │ OpenAPI Spec │───►│  php-max     │───►│  Generated   │          │
│  │ (YAML)       │    │  Generator   │    │  Library     │          │
│  └──────────────┘    └──────┬───────┘    └──────────────┘          │
│                             │                                        │
│                    ┌────────┴────────┐                              │
│                    ▼                 ▼                              │
│            ┌──────────────┐  ┌──────────────┐                       │
│            │ Embedded     │  │ External     │                       │
│            │ Templates    │  │ Templates    │                       │
│            │ (Laravel)    │  │ (Sym/Slim)   │                       │
│            └──────────────┘  └──────────────┘                       │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                      INTEGRATION LAYER                               │
├─────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐     │
│  │ Laravel Project │  │ Symfony Project │  │ Slim Project    │     │
│  ├─────────────────┤  ├─────────────────┤  ├─────────────────┤     │
│  │ • Generated lib │  │ • Generated lib │  │ • Generated lib │     │
│  │ • Handlers      │  │ • Handlers      │  │ • Handlers      │     │
│  │ • Tests         │  │ • Tests         │  │ • Tests         │     │
│  │ • Docker        │  │ • Docker        │  │ • Docker        │     │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘     │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                      AUTOMATION LAYER                                │
├─────────────────────────────────────────────────────────────────────┤
│  Root Makefile                                                       │
│  ├── make generate-all      (regenerate all libs)                   │
│  ├── make test-all          (run all framework tests)               │
│  ├── make test-laravel      (Laravel tests only)                    │
│  ├── make test-symfony      (Symfony tests only)                    │
│  └── make test-slim         (Slim tests only)                       │
└─────────────────────────────────────────────────────────────────────┘
```

### 14.5 Integration Patterns

#### Pattern 1: Generated Library as Composer Dependency

```json
// projects/laravel-api--php-max--fork-test/composer.json
{
    "repositories": [
        {
            "type": "path",
            "url": "../../generated/php-max-laravel/petshop"
        }
    ],
    "require": {
        "php-max/petshop": "*"
    }
}
```

#### Pattern 2: Handler Interface Implementation

```php
// Generated (library)
interface PetApiHandlerInterface {
    public function createPet(CreatePetRequest $request): CreatePetResponse;
    public function findPets(FindPetsQueryParams $params): FindPetsResponse;
}

// Implemented (project)
class PetHandler implements PetApiHandlerInterface {
    public function createPet(CreatePetRequest $request): CreatePetResponse {
        // Business logic here
        return CreatePetResponse::created($pet);
    }
}
```

#### Pattern 3: Service Registration

```php
// Laravel: AppServiceProvider
$this->app->bind(PetApiHandlerInterface::class, PetHandler::class);

// Symfony: services.yaml
services:
    App\Handler\PetHandler: ~
    PetshopApi\Api\PetApiHandlerInterface: '@App\Handler\PetHandler'

// Slim: dependencies.php
$container->set(PetApiHandlerInterface::class, autowire(PetHandler::class));
```

### 14.6 Naming Conventions

| Component | Convention | Example |
|-----------|------------|---------|
| Generated namespace | `{Spec}Api` | `PetshopApi`, `TictactoeApi` |
| Handler interface | `{Tag}ApiHandlerInterface` | `PetApiHandlerInterface` |
| Handler implementation | `{Tag}Handler` | `PetHandler` |
| Controller | `{OperationId}Controller` | `CreatePetController` |
| Form Request | `{OperationId}FormRequest` | `CreatePetFormRequest` |
| Resource | `{OperationId}{Status}Resource` | `CreatePet201Resource` |
| Model | `{SchemaName}` | `Pet`, `NewPet`, `Error` |
| Test class | `{OperationId}Test` | `CreatePetTest` |

### 14.7 Constraints Summary
| Constraint | Limit | Rationale |
|------------|-------|-----------|
| Max template file size | 300 lines | Maintainability |
| Max generated file size | 500 lines | Readability |
| Max test file size | 150 lines | Focus |
| Max handler method size | 50 lines | Single responsibility |
| PHPStan level | 6 | Balance strictness/practicality |
| PHP version | 8.1+ | Type system features |
| Test coverage target | 80% | Reasonable goal |
| Docker compose services | 4 max | app, db, redis, web |

| # | Gap | Question | Resolution |
|---|-----|----------|------------|
| C-01 | Fork test scope | Run ALL upstream tests or subset? | **Subset first** - core + generator modules only (~300 tests), skip client generators |
| C-02 | Existing vs new projects | Use existing test projects or create new? | **Use existing** - `laravel-api--laravel-max--integration-tests`, etc. already exist |
| C-03 | Petshop spec version | Which petshop.yaml to use? | **petshop-extended.yaml** - has more operations for thorough testing |
| C-04 | Template override behavior | Override all or merge with embedded? | **Override all** - `-t` flag replaces entire template set, no merging |
| C-05 | Generated lib versioning | Version in composer.json? | **`dev-main`** - using path repository, version doesn't matter |
| C-06 | Test database | Real DB or SQLite? | **SQLite in-memory** - faster, no Docker DB needed for most tests |
| C-07 | Security testing | Test auth middleware? | **Stub implementations** - verify interface contracts, not real auth |
| C-08 | Error response testing | Test all error codes? | **Core errors only** - 400, 404, 422, 500; skip framework-specific |

### 15.2 Scope Boundaries

#### In Scope

| Item | Details |
|------|---------|
| Fork backward compatibility | Core + generator module tests |
| Per-operation generation | Verify new `templateType: Operation` works |
| Template variables | All new vendorExtensions available |
| Laravel full integration | Both specs, full test coverage |
| Symfony full integration | Both specs, full test coverage |
| Slim full integration | Both specs, full test coverage |
| PHPStan validation | Level 6 for all generated code |
| Make automation | `generate-all`, `test-all`, per-framework commands |

#### Out of Scope

| Item | Rationale |
|------|-----------|
| Upstream PR creation | Separate task after validation |
| CI/CD pipeline setup | Future enhancement |
| Performance benchmarking | Not critical for validation |
| Other PHP frameworks (CodeIgniter, Laminas) | Separate tickets exist |
| Client code generation | Server-side only |
| Documentation site | README files sufficient |
| Code coverage reporting | PHPStan sufficient for now |

### 15.3 Edge Cases & Special Handling

#### OpenAPI Spec Edge Cases

| Case | Handling |
|------|----------|
| Operations without operationId | Generator auto-generates from path+method |
| Empty request body | `hasBodyParam = false`, no FormRequest generated |
| Multiple response codes | Generate Resource per status code |
| Array query parameters | Use `array` type hint, not `string[]` |
| Nullable properties | Use `?Type` syntax in PHP |
| Enum values | Generate PHP 8.1 enum classes |
| allOf/oneOf/anyOf | Flatten to single model (limitation) |

#### Framework-Specific Edge Cases

| Framework | Case | Handling |
|-----------|------|----------|
| Laravel | Route model binding | Not supported, use explicit ID params |
| Laravel | Policy authorization | Out of scope, use middleware |
| Symfony | ParamConverter | Not used, manual parameter extraction |
| Symfony | Voter authorization | Out of scope, use security config |
| Slim | Route arguments | Extract via `$request->getAttribute()` |
| Slim | Error handling | Use Slim's error middleware |

### 15.4 Default Values & Assumptions

| Item | Default | Assumption |
|------|---------|------------|
| PHP version | 8.1 | Minimum for enum support |
| Laravel version | 10.x | LTS, widely used |
| Symfony version | 6.4 | LTS |
| Slim version | 4.x | Current major |
| invokerPackage | `{Spec}Api` | e.g., `PetshopApi` |
| srcBasePath | `app` (Laravel), `src` (Symfony/Slim) | Framework convention |
| Test parallelization | Disabled | Simpler debugging |
| Docker network | Bridge (default) | No custom network needed |

### 15.5 Open Questions (Deferred)

| # | Question | Impact | Decision Deadline |
|---|----------|--------|-------------------|
| Q-01 | Should we publish fork to private Maven repo? | Low | After validation |
| Q-02 | Support for OpenAPI 3.1 features? | Medium | Future enhancement |
| Q-03 | Generate API documentation (OpenAPI UI)? | Low | Future enhancement |
| Q-04 | Multi-file spec support ($ref external)? | Medium | Test with current specs first |

### 15.6 Acceptance Test Scenarios

#### Scenario 1: Basic CRUD Operations

```gherkin
Given a generated Petshop library for Laravel
When I implement PetApiHandler with stub responses
And I call POST /pets with valid JSON
Then I receive 201 Created with Pet object
And the response matches OpenAPI schema
```

#### Scenario 2: Validation Errors

```gherkin
Given a generated Petshop library for Symfony
When I call POST /pets with missing required field "name"
Then I receive 422 Unprocessable Entity
And the response contains validation errors
```

#### Scenario 3: Query Parameters

```gherkin
Given a generated Petshop library for Slim
When I call GET /pets?limit=10&tags=cat,dog
Then the handler receives FindPetsQueryParams with limit=10 and tags=["cat","dog"]
```

#### Scenario 4: Path Parameters

```gherkin
Given a generated TicTacToe library for any framework
When I call GET /games/{gameId}
Then the handler receives gameId extracted from path
```

#### Scenario 5: Error Responses

```gherkin
Given a generated library for any framework
When the handler throws NotFoundException
Then I receive 404 Not Found with Error object
```

### 15.7 Definition of Done

A framework integration is **complete** when:

- [ ] Both specs (petshop, tictactoe) generate without errors
- [ ] All generated PHP files pass `php -l` syntax check
- [ ] PHPStan level 6 passes with 0 errors
- [ ] Handler interfaces can be implemented
- [ ] Routes are registered and accessible
- [ ] Request validation works for required fields
- [ ] Response transformation works via Resources/DTOs
- [ ] At least 10 integration tests pass per spec
- [ ] `make test-{framework}` runs successfully
- [ ] README documents setup and usage

### 15.8 Glossary
| Term | Definition |
|------|------------|
| **Fork** | Our modified copy of openapi-generator with per-operation support |
| **php-max** | Our custom OpenAPI generator for PHP frameworks |
| **Embedded templates** | Templates bundled inside php-max JAR (Laravel default) |
| **External templates** | Templates provided via `-t` flag (Symfony, Slim) |
| **Handler** | Business logic implementation class |
| **Handler Interface** | Generated contract that handlers must implement |
| **per-operation** | One file generated per OpenAPI operation (vs per-tag) |
| **per-tag** | One file generated per OpenAPI tag grouping |
| **vendorExtensions** | Custom variables added to template context |

| # | Task | Est. | Depends | Deliverable |
|---|------|------|---------|-------------|
| 1.1 | Run `mvn test -pl modules/openapi-generator-core` | 15m | - | Test report |
| 1.2 | Run `mvn test -pl modules/openapi-generator` | 45m | 1.1 | Test report |
| 1.3 | Document any test failures | 15m | 1.2 | Issue list |
| 1.4 | Fix critical test failures (if any) | 1-2h | 1.3 | Passing tests |
| 1.5 | Install fork to local Maven: `mvn install -DskipTests` | 10m | 1.4 | Local JAR |

**Exit Criteria:** >99% tests pass, fork installed locally

---

### 16.2 Phase 2: Generator Verification (1h)

| # | Task | Est. | Depends | Deliverable |
|---|------|------|---------|-------------|
| 2.1 | Rebuild php-max with fork: `mvn clean package` | 10m | 1.5 | Generator JAR |
| 2.2 | Generate petshop with Laravel templates | 5m | 2.1 | Generated files |
| 2.3 | Verify per-operation files created (one controller per op) | 10m | 2.2 | Checklist |
| 2.4 | Verify vendorExtensions variables present | 10m | 2.2 | Checklist |
| 2.5 | Run `php -l` on all generated files | 5m | 2.2 | Syntax OK |
| 2.6 | Generate tictactoe with Laravel templates | 5m | 2.1 | Generated files |
| 2.7 | Verify tictactoe generation | 10m | 2.6 | Checklist |

**Exit Criteria:** Both specs generate valid PHP with per-operation files

---

### 16.3 Phase 3: Laravel Integration (3-4h)

| # | Task | Est. | Depends | Deliverable |
|---|------|------|---------|-------------|
| 3.1 | Update `generated/php-max-laravel/` with fresh generation | 10m | 2.7 | Fresh libs |
| 3.2 | Update composer.json path repositories | 5m | 3.1 | Updated config |
| 3.3 | Run `composer update` in test project | 5m | 3.2 | Dependencies |
| 3.4 | Create/update Petshop handler implementations | 30m | 3.3 | Handler classes |
| 3.5 | Create/update TicTacToe handler implementations | 30m | 3.3 | Handler classes |
| 3.6 | Register handlers in AppServiceProvider | 10m | 3.4, 3.5 | DI bindings |
| 3.7 | Run existing tests: `make test` | 10m | 3.6 | Test results |
| 3.8 | Add Petshop integration tests (5 tests min) | 45m | 3.7 | Test files |
| 3.9 | Add TicTacToe integration tests (5 tests min) | 45m | 3.7 | Test files |
| 3.10 | Run PHPStan level 6 | 10m | 3.9 | Analysis report |
| 3.11 | Fix PHPStan warnings (if any) | 30m | 3.10 | Clean report |

**Exit Criteria:** All tests pass, PHPStan clean, both specs working

---

### 16.4 Phase 4: Symfony Integration (7-10h)

| # | Task | Est. | Depends | Deliverable |
|---|------|------|---------|-------------|
| 4.1 | Review current Symfony template gaps | 30m | 2.7 | Gap list |
| 4.2 | Add missing `handler-interface.mustache` | 30m | 4.1 | Template |
| 4.3 | Update `controller.mustache` for proper DI | 45m | 4.2 | Template |
| 4.4 | Add `form-request.mustache` (Symfony validation) | 45m | 4.1 | Template |
| 4.5 | Add `response-dto.mustache` | 30m | 4.1 | Template |
| 4.6 | Update `files.json` with new templates | 15m | 4.2-4.5 | Config |
| 4.7 | Generate petshop with Symfony templates | 10m | 4.6 | Generated files |
| 4.8 | Run `php -l` syntax check | 5m | 4.7 | Syntax OK |
| 4.9 | Generate tictactoe with Symfony templates | 10m | 4.6 | Generated files |
| 4.10 | Update test project composer.json | 5m | 4.9 | Config |
| 4.11 | Create Petshop handler implementations | 30m | 4.10 | Handler classes |
| 4.12 | Create TicTacToe handler implementations | 30m | 4.10 | Handler classes |
| 4.13 | Configure services.yaml DI | 15m | 4.11, 4.12 | Config |
| 4.14 | Add Petshop functional tests (5 min) | 45m | 4.13 | Test files |
| 4.15 | Add TicTacToe functional tests (5 min) | 45m | 4.13 | Test files |
| 4.16 | Configure PHPStan for Symfony | 15m | 4.15 | phpstan.neon |
| 4.17 | Run PHPStan and fix issues | 45m | 4.16 | Clean report |

**Exit Criteria:** Both specs generate, tests pass, PHPStan clean

---

### 16.5 Phase 5: Slim Integration (8-10h)

| # | Task | Est. | Depends | Deliverable |
|---|------|------|---------|-------------|
| 5.1 | Review current Slim template gaps | 30m | 2.7 | Gap list |
| 5.2 | Complete `controller.mustache` (Slim action) | 45m | 5.1 | Template |
| 5.3 | Complete `model.mustache` with validation | 30m | 5.1 | Template |
| 5.4 | Add `handler-interface.mustache` | 30m | 5.1 | Template |
| 5.5 | Update `routes.mustache` for Slim 4 | 30m | 5.1 | Template |
| 5.6 | Update `dependencies.mustache` for PHP-DI | 30m | 5.1 | Template |
| 5.7 | Add `middleware.mustache` for validation | 45m | 5.1 | Template |
| 5.8 | Update `files.json` | 15m | 5.2-5.7 | Config |
| 5.9 | Generate petshop with Slim templates | 10m | 5.8 | Generated files |
| 5.10 | Run `php -l` syntax check | 5m | 5.9 | Syntax OK |
| 5.11 | Generate tictactoe with Slim templates | 10m | 5.8 | Generated files |
| 5.12 | Setup test project from scratch or update existing | 45m | 5.11 | Project structure |
| 5.13 | Configure PHP-DI container | 30m | 5.12 | dependencies.php |
| 5.14 | Create Petshop handler implementations | 30m | 5.13 | Handler classes |
| 5.15 | Create TicTacToe handler implementations | 30m | 5.13 | Handler classes |
| 5.16 | Add Petshop tests (5 min) | 45m | 5.15 | Test files |
| 5.17 | Add TicTacToe tests (5 min) | 45m | 5.15 | Test files |
| 5.18 | Configure PHPStan for Slim | 15m | 5.17 | phpstan.neon |
| 5.19 | Run PHPStan and fix issues | 45m | 5.18 | Clean report |

**Exit Criteria:** Both specs generate, tests pass, PHPStan clean

---

### 16.6 Phase 6: Automation (2-3h)

| # | Task | Est. | Depends | Deliverable |
|---|------|------|---------|-------------|
| 6.1 | Create/update root Makefile with unified commands | 30m | 3.11, 4.17, 5.19 | Makefile |
| 6.2 | Add `make generate-all` target | 15m | 6.1 | Make target |
| 6.3 | Add `make test-all` target | 15m | 6.1 | Make target |
| 6.4 | Add `make test-laravel` target | 10m | 6.1 | Make target |
| 6.5 | Add `make test-symfony` target | 10m | 6.1 | Make target |
| 6.6 | Add `make test-slim` target | 10m | 6.1 | Make target |
| 6.7 | Test all make commands | 30m | 6.2-6.6 | Verification |
| 6.8 | Update README with commands | 20m | 6.7 | Documentation |
| 6.9 | Final full test run: `make test-all` | 15m | 6.8 | Final report |

**Exit Criteria:** All make commands work, README complete

---

### 16.7 Task Summary

| Phase | Tasks | Est. Time | Cumulative |
|-------|-------|-----------|------------|
| Phase 1: Fork Validation | 5 | 2-3h | 2-3h |
| Phase 2: Generator Verification | 7 | 1h | 3-4h |
| Phase 3: Laravel Integration | 11 | 3-4h | 6-8h |
| Phase 4: Symfony Integration | 17 | 7-10h | 13-18h |
| Phase 5: Slim Integration | 19 | 8-10h | 21-28h |
| Phase 6: Automation | 9 | 2-3h | 23-31h |
| **Total** | **68** | **23-31h** | |

### 16.8 Critical Path

```
Phase 1 ──► Phase 2 ──► Phase 3 ──┐
                                  ├──► Phase 6
            Phase 4 ──────────────┤
            Phase 5 ──────────────┘
```

**Note:** Phases 3, 4, 5 can run in parallel after Phase 2 completes.

### 16.9 Checkpoints

| Checkpoint | After Task | Validation |
|------------|------------|------------|
| CP-1 | 1.5 | Fork installed, tests pass |
| CP-2 | 2.7 | Generator works with fork |
| CP-3 | 3.11 | Laravel fully working |
| CP-4 | 4.17 | Symfony fully working |
| CP-5 | 5.19 | Slim fully working |
| CP-6 | 6.9 | All automation working |

### 16.10 Risk Mitigation Tasks

| Risk | Mitigation Task | When |
|------|-----------------|------|
| Fork tests fail | Task 1.4 (fix failures) | Phase 1 |
| Template gaps larger than expected | Tasks 4.1, 5.1 (gap review) | Phase 4, 5 |
| PHPStan issues | Tasks 3.11, 4.17, 5.19 (fix issues) | Each phase |