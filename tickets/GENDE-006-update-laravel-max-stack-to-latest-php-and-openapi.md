---
code: GENDE-006
status: Implemented
dateCreated: 2025-12-31T21:03:05.239Z
type: Technical Debt
priority: Medium
implementationDate: 2025-12-31
---

# GENDE-005: Update laravel-max Stack to Latest PHP and OpenAPI Generator Versions

> ⚠️ **STATUS: NEEDS CLARIFICATION** - Target versions and scope need confirmation.

## 1. Description
### Problem Statement
The laravel-max generator, generated library, and integration project may be using outdated versions of PHP and OpenAPI Generator. Staying current ensures:
- Security patches
- Performance improvements
- Access to new language/framework features
- Compatibility with modern tooling

### Components Updated

| Component | Location | Previous | Updated |
|-----------|----------|----------|---------|
| **Generator** (Java) | `openapi-generator-generators/laravel-max/` | OpenAPI 7.10.0, Java 8 | OpenAPI 7.18.0, Java 11 |
| **Integration Project** | `projects/laravel-api--example--laravel-max/` | PHP 8.2, Laravel 11 | PHP 8.3, Laravel 12 |

### Version Summary

| Dependency | Previous | Updated | Notes |
|------------|----------|---------|-------|
| OpenAPI Generator | 7.10.0 | **7.18.0** | 8 minor versions updated |
| Java source/target | 1.8 | **11** | Minimum for OpenAPI Generator 7.x |
| PHP | ^8.2 | **^8.3** | Laravel 12 compatible |
| Laravel | ^11.0 | **^12.0** | Latest stable (v12.44.0) |
| PHPUnit | ^11.0 | ^11.0 | Already current |
## 2. Rationale

- **Security**: Older versions may have unpatched vulnerabilities
- **Features**: PHP 8.3/8.4 offers readonly classes, typed constants, etc.
- **Compatibility**: Newer Laravel versions require newer PHP
- **Maintenance**: Easier to maintain when not too far behind
- **Best Practice**: Regular dependency updates reduce upgrade pain

## 3. Solution Analysis

### Questions to Clarify

1. **Target PHP Version**: 8.3 (stable) or 8.4 (latest)?
2. **Target Laravel Version**: 11.x or 12.x?
3. **Breaking Changes Tolerance**: Accept breaking changes in generated code?
4. **OpenAPI Generator Version**: Stay on 7.x or evaluate 8.x if available?
5. **Backwards Compatibility**: Must generated library support older PHP?

### Update Areas

#### A. Generator Updates (`laravel-max-generator/`)
- [ ] Update `pom.xml` OpenAPI Generator dependency version
- [ ] Update Java source compatibility if needed
- [ ] Test generator builds with new version
- [ ] Update templates for new PHP features if desired

#### B. Generated Library Updates (`examples/laravel-max/`)
- [ ] Update `composer.json` PHP version constraint
- [ ] Update Laravel framework version
- [ ] Update other dependencies (phpunit, etc.)
- [ ] Regenerate library with updated generator
- [ ] Fix any deprecations or breaking changes
- [ ] Run tests and fix failures

#### C. Integration Project Updates
- [ ] Update Docker PHP image version
- [ ] Update `composer.json` dependencies
- [ ] Update Laravel configuration if needed
- [ ] Test full integration

### Potential Challenges

1. **OpenAPI Generator Breaking Changes**
   - Template variable changes
   - Generator option changes
   - Output structure changes

2. **PHP Breaking Changes**
   - Deprecated functions removed
   - Type system changes
   - New required syntax

3. **Laravel Breaking Changes**
   - Middleware changes
   - Service provider changes
   - Configuration format changes

## 4. Implementation Specification

### Phase 1: Version Audit
1. Document current versions of all components
2. Identify target versions
3. Review changelogs for breaking changes
4. Create upgrade checklist

### Phase 2: Generator Update
1. Update `pom.xml` with new OpenAPI Generator version
2. Build and test generator
3. Fix any Java compilation issues
4. Update templates if needed for new features

### Phase 3: Library Regeneration
1. Regenerate `examples/laravel-max/` with updated generator
2. Update `composer.json` version constraints
3. Run `composer update`
4. Fix deprecations and breaking changes
5. Run full test suite

### Phase 4: Integration Project Update
1. Update Docker configuration (PHP version)
2. Update project dependencies
3. Test full application
4. Update documentation

### Phase 5: Documentation
1. Update version requirements in README
2. Update CLAUDE.md if needed
3. Document any migration notes

## 5. Acceptance Criteria
- [x] All components updated to target versions
- [x] Generator builds successfully with new OpenAPI Generator version
- [x] Generated library passes all tests on target PHP version
- [x] Integration project runs successfully
- [x] No deprecation warnings in generated code
- [x] Documentation reflects new version requirements
- [x] Docker images updated to new PHP version

**Completed:** 2025-01-01

### Changes Made

**Generator (`openapi-generator-generators/laravel-max/`):**
- `pom.xml`: Updated `openapi-generator-version` from 7.10.0 to 7.18.0
- `pom.xml`: Updated Java source/target from 1.8 to 11
- `Makefile`: Updated `OPENAPI_GENERATOR_VERSION` to 7.18.0
- `LaravelMaxGenerator.java`: Fixed ResourceCollection vs JsonResource detection
- `LaravelMaxGenerator.java`: Added queryParams to controller data
- `api-interface.mustache`: Fixed optional parameter handling with nullable types
- All 18 generator tests pass with new versions

**Integration Project (`projects/laravel-api--example--laravel-max/`):**
- `composer.json`: Updated PHP requirement to ^8.3
- `composer.json`: Updated Laravel to ^12.0
- `composer.json`: Fixed autoload to point to generated library
- `routes/api.php`: Updated path to generated routes
- `Makefile`: Updated volume mounts for generated library path
- `TictactoeApiHandler.php`: Implemented all per-operation handler interfaces
- `AppServiceProvider.php`: Bound per-operation handler interfaces
- Laravel 12.44.0 installed and running on PHP 8.4

### Test Results

| Component | Tests | Status |
|-----------|-------|--------|
| Generator (Java) | 18/18 | ✅ All passed |
| Integration (PHPUnit) | 25/25 | ✅ All passed (66 assertions) |

### Generator Bug Fixes

1. **ResourceCollection vs JsonResource** - Fixed detection to only use ResourceCollection for actual array responses
2. **Optional Query Parameters** - Handler interfaces now generate nullable types with defaults for optional params
3. **Query Params in Controllers** - Added missing queryParams to controller data map

### Files Modified

```
openapi-generator-generators/laravel-max/pom.xml
openapi-generator-generators/laravel-max/Makefile
openapi-generator-generators/laravel-max/src/main/java/.../LaravelMaxGenerator.java
openapi-generator-generators/laravel-max/src/main/resources/laravel-max/api-interface.mustache
projects/laravel-api--example--laravel-max/composer.json
projects/laravel-api--example--laravel-max/Makefile
projects/laravel-api--example--laravel-max/routes/api.php
projects/laravel-api--example--laravel-max/app/Api/TictactoeApiHandler.php
projects/laravel-api--example--laravel-max/app/Providers/AppServiceProvider.php
projects/laravel-api--example--laravel-max/tests/Feature/GameApiTest.php
```