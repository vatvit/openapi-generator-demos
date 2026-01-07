---
code: GENDE-066
status: Implemented
dateCreated: 2026-01-07T09:08:31.834Z
type: Technical Debt
priority: High
---

# Restructure php-max generator to use single default template set

## 1. Description

The php-max generator currently bundles multiple framework-specific template directories inside the generator JAR. This defeats the purpose of having a flexible, template-driven generator.

**Current (Wrong):**
```
php-max/src/main/resources/
├── php-max/        # 2 files (incomplete)
├── laravel-max/    # 16 Laravel templates
├── slim-max/       # 13 Slim templates
└── symfony-max/    # 14 Symfony templates
```

**Expected:**
```
php-max/src/main/resources/
└── php-max/        # Full Laravel templates as DEFAULT
```

Other frameworks should use external template directories via `-t` CLI option.

## 2. Rationale

- Generator should have ONE default template set (Laravel)
- Framework flexibility comes from EXTERNAL templates, not bundled ones
- Reduces JAR size and complexity
- Follows OpenAPI Generator conventions for template customization

## 3. Solution Analysis
**Option A: Move and delete** (Recommended)
- Move `laravel-max/` content → `php-max/`
- Delete `laravel-max/`, `slim-max/`, `symfony-max/` directories
- Simple, clean result

**Option B: Rename only**
- Rename `laravel-max/` to `php-max/`
- Still need to delete slim-max, symfony-max

### Architecture

#### Key Decisions

| Decision | Choice | Rationale |
|----------|--------|-----------|
| Default framework | Laravel | Most common PHP framework, best documentation, reference implementation exists |
| Template location | `php-max/` embedded in JAR | Standard OpenAPI Generator convention, works without `-t` flag |
| Other frameworks | External via `-t` flag | Keeps JAR size minimal, allows independent template versioning |
| Template naming | Framework-agnostic | `controller.mustache` not `laravel-controller.mustache` |

#### Directory Structure (After Restructure)

```
php-max/src/main/resources/
├── META-INF/
│   └── services/
│       └── org.openapitools.codegen.CodegenConfig
└── php-max/                    # DEFAULT templates (Laravel)
    ├── api.mustache
    ├── api-interface.mustache
    ├── controller.mustache
    ├── error-resource.mustache
    ├── form-request.mustache
    ├── licenseInfo.mustache
    ├── middleware-stub.mustache
    ├── model.mustache
    ├── model-debug.mustache
    ├── myFile.mustache
    ├── query-params.mustache
    ├── resource.mustache
    ├── resource-collection.mustache
    ├── routes.mustache
    ├── security-interface.mustache
    └── security-validator.mustache

# DELETED directories:
# - laravel-max/  (merged into php-max/)
# - slim-max/     (external only)
# - symfony-max/  (external only)
```

#### Size Limits

| Metric | Limit | Current |
|--------|-------|---------|
| Embedded template directories | 1 | 4 (needs fix) |
| Files in php-max/ | 15-20 | 16 after merge |
| JAR size increase | 0 KB | -30 KB (removing duplicates) |
| Java code changes | 0 lines | 0 lines |
## 4. Implementation Specification
### Steps:
1. Copy all files from `laravel-max/` to `php-max/`
2. Delete `laravel-max/` directory
3. Delete `slim-max/` directory  
4. Delete `symfony-max/` directory
5. Update generator Java code if it references these directories
6. Test generation with default templates
7. Test generation with external template override (`-t` option)

### Files affected:
- `php-max/src/main/resources/php-max/` - add templates
- `php-max/src/main/resources/laravel-max/` - delete
- `php-max/src/main/resources/slim-max/` - delete
- `php-max/src/main/resources/symfony-max/` - delete
- `PhpMaxGenerator.java` - verify/update template references

### Code Fitness Assessment

**Assessment Date:** 2026-01-07

#### PhpMaxGenerator.java Analysis (Line 126)
```java
embeddedTemplateDir = templateDir = "php-max";
```
- **Finding:** Generator already correctly configured to use `php-max` as default template directory
- **Impact:** NO Java code changes required
- **Risk:** LOW - Pure file operations only

#### Current Directory Structure
| Directory | Files | Status |
|-----------|-------|--------|
| `php-max/` | 2 (api.mustache, model.mustache) | INCOMPLETE - missing 14 files |
| `laravel-max/` | 16 templates | COMPLETE - should be the default |
| `slim-max/` | 13 templates | TO DELETE |
| `symfony-max/` | 15 templates | TO DELETE |

#### Required Actions (No Code Changes)
1. Copy all 16 files from `laravel-max/` to `php-max/`
2. Delete `laravel-max/` directory
3. Delete `slim-max/` directory (13 files)
4. Delete `symfony-max/` directory (15 files)
5. Run Maven build to verify compilation

#### Risk Analysis
- **Complexity:** LOW - Simple file copy/delete operations
- **Breaking Changes:** None if external template users already use `-t` flag
- **Rollback:** Easy - git checkout to restore deleted files

### POC Validation

**Objective:** Verify generator produces identical output before and after template restructure.

#### Technical Uncertainties
1. Will generator find templates in `php-max/` directory after restructure?
2. Will generated output be identical to current `laravel-max/` output?
3. Will Maven build succeed with restructured resources?

#### POC Steps

**Step 1: Capture baseline output**
```bash

### Clarifications

#### Q1: What happens to users currently using `-t laravel-max`?
**Answer:** This is an internal restructure. External users should use:
- No `-t` flag → uses embedded `php-max/` templates (Laravel)
- `-t path/to/external/templates` → uses external templates

The internal `laravel-max/` directory was never intended for external use. Users who referenced it directly were using undocumented behavior.

#### Q2: Should `target/classes/` be cleaned too?
**Answer:** No. The `target/` directory is generated by Maven build. After restructuring `src/main/resources/`, running `mvn clean package` will regenerate `target/classes/` correctly.

#### Q3: What about files.json in embedded templates?
**Answer:** The embedded `php-max/` templates do NOT need `files.json`. The `files.json` configuration is optional and primarily useful for external templates to customize which files are generated. The generator has hardcoded defaults that work without it.

#### Q4: Is this a breaking change?
**Answer:** No. The generator's public interface remains unchanged:
- `-g php-max` still works
- Default output structure unchanged
- All CLI options unchanged

Only internal resource organization changes.

#### Q5: Order of operations?
**Answer:** 
1. Copy `laravel-max/*` → `php-max/` (merge, overwrite existing 2 files)
2. Delete `laravel-max/`
3. Delete `slim-max/`
4. Delete `symfony-max/`
5. `mvn clean package` to rebuild
6. Test generation

### Task Breakdown

| # | Task | Constraint | Est. Size |
|---|------|------------|-----------|
| 1 | Copy `laravel-max/*` to `php-max/` | 16 files, overwrite existing 2 | ~30 KB |
| 2 | Delete `laravel-max/` directory | 16 files | -30 KB |
| 3 | Delete `slim-max/` directory | 13 files | -20 KB |
| 4 | Delete `symfony-max/` directory | 15 files | -25 KB |
| 5 | Run `mvn clean package -DskipTests` | Must succeed | ~30s |
| 6 | Test generation without `-t` flag | Output must match baseline | ~10s |

#### Task Details

**Task 1: Copy laravel-max to php-max**
```bash
cp -v laravel-max/* php-max/
```
Files to copy: api-interface.mustache, api.mustache, controller.mustache, error-resource.mustache, form-request.mustache, licenseInfo.mustache, middleware-stub.mustache, model-debug.mustache, model.mustache, myFile.mustache, query-params.mustache, resource-collection.mustache, resource.mustache, routes.mustache, security-interface.mustache, security-validator.mustache

**Task 2-4: Delete framework directories**
```bash
rm -rf laravel-max/
rm -rf slim-max/
rm -rf symfony-max/
```

**Task 5: Build**
```bash
mvn clean package -DskipTests
```
Success criteria: BUILD SUCCESS

**Task 6: Verify**
```bash
java -cp target/... org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max -i test-spec.yaml -o /tmp/test-output
```
Success criteria: Files generated, no errors

#### Dependencies
- Tasks 1-4: Independent, can run in sequence
- Task 5: Depends on 1-4
- Task 6: Depends on 5
# Generate with current structure (uses laravel-max via library option or -t flag)
cd openapi-generator-generators/php-max
mvn clean package -DskipTests
java -cp target/php-max-openapi-generator-1.0.0.jar:... \
  org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max -t src/main/resources/laravel-max \
  -i ../../openapi-generator-specs/tictactoe.yaml \
  -o /tmp/poc-baseline
```

**Step 2: Perform restructure**
- Copy laravel-max/* → php-max/
- Delete laravel-max/, slim-max/, symfony-max/

**Step 3: Verify identical output**
```bash
mvn clean package -DskipTests
java -cp target/php-max-openapi-generator-1.0.0.jar:... \
  org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max \
  -i ../../openapi-generator-specs/tictactoe.yaml \
  -o /tmp/poc-restructured

# Compare outputs
diff -r /tmp/poc-baseline /tmp/poc-restructured
```

#### Success Criteria
- [ ] Maven build succeeds
- [ ] Generator runs without `-t` flag (uses embedded php-max/ templates)
- [ ] Output files are identical (ignoring timestamps)
- [ ] No Java code changes required
## 5. Acceptance Criteria
- [ ] `php-max/` contains full Laravel template set (16+ files)
- [ ] No `laravel-max/`, `slim-max/`, `symfony-max/` directories in resources
- [ ] Generator builds successfully
- [ ] Default generation produces Laravel code
- [ ] External template override works with `-t` option

### 6.1 Functional Requirements

**FR-066-01: Default Template Location**
The php-max generator shall load default templates from `php-max/` directory within resources.

**FR-066-02: Complete Template Set**
The `php-max/` directory shall contain all templates required for Laravel code generation (minimum 16 files).

**FR-066-03: Single Embedded Template Set**
The generator resources shall contain only ONE template directory (`php-max/`), with no framework-specific directories.

**FR-066-04: External Template Override**
When the user specifies `-t <path>` option, the generator shall use templates from the external path instead of embedded defaults.

**FR-066-05: Template Resolution**
When a template file exists in external path, the generator shall use the external version; otherwise it shall fall back to embedded default.

### 6.2 Non-Functional Requirements

**NFR-066-01: Backward Compatibility**
The generator shall produce identical Laravel output before and after restructuring when no `-t` option is specified.

**NFR-066-02: JAR Size Reduction**
The generator JAR size shall decrease by removing ~40 redundant template files (slim-max + symfony-max).

**NFR-066-03: Build Success**
The generator shall compile and pass all existing tests after restructuring.

### 6.3 Constraints

**CON-066-01: No Framework Logic in Generator**
The generator Java code shall NOT contain framework-specific logic; all framework differences shall be handled via templates.

**CON-066-02: Template Naming**
Template files in `php-max/` shall use generic names (e.g., `controller.mustache`, not `laravel-controller.mustache`).