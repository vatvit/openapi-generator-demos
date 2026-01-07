---
code: GENDE-067
status: Implemented
dateCreated: 2026-01-07T09:08:31.929Z
type: Technical Debt
priority: Medium
---

# Verify and organize external php-max template directories

## 1. Description

After restructuring the php-max generator (GENDE-066), verify that external template directories in `openapi-generator-server-templates/` are properly organized and follow naming conventions.

**Expected structure:**
```
openapi-generator-server-templates/
├── openapi-generator-server-php-max-default/   # Extracted defaults for reference
├── openapi-generator-server-php-max-symfony/   # Symfony templates
└── openapi-generator-server-php-max-slim/      # Slim templates
```

## 2. Rationale

- Consistent naming convention: `openapi-generator-server-php-max-{variant}`
- Default templates extracted for reference/customization
- Framework-specific templates as complete override sets
- Users can easily find and customize templates

## 3. Solution Analysis
Review existing directories and ensure:
1. Names follow convention
2. Each has complete template set for its framework
3. README explains usage

Brief description of framework variant.

## Usage
\`\`\`bash
openapi-generator generate -g php-max -t path/to/templates ...
\`\`\`

## Generated Structure
Directory tree of output.

## Requirements
PHP version, framework version, dependencies.
```

#### Size Limits

| Metric | Limit | Rationale |
|--------|-------|-----------|
| External template directories | 3-5 | Major PHP frameworks only |
| Files per template set | 8-20 | Complete but focused |
| README.md size | 2-10 KB | Comprehensive but concise |
| files.json entries | 5-15 | One per generated file type |
## 4. Implementation Specification
### Verify existing:
- `openapi-generator-server-php-max-default/` - should have Laravel templates
- `openapi-generator-server-php-max-symfony/` - should have Symfony templates
- `openapi-generator-server-php-max-slim/` - should have Slim templates

### For each directory:
1. Verify all necessary templates exist
2. Add README.md explaining usage
3. Test generation with `-t` pointing to directory

### Code Fitness Assessment

**Assessment Date:** 2026-01-07

#### External Template Directories Status

| Directory | Files | README | Status |
|-----------|-------|--------|--------|
| `openapi-generator-server-php-max-default/` | 9 | ✅ EXISTS (8275 bytes) | OK but outdated |
| `openapi-generator-server-php-max-slim/` | 8 | ✅ EXISTS (3112 bytes) | OK |
| `openapi-generator-server-php-max-symfony/` | 9 | ❌ MISSING | Needs README |

#### php-max-default Directory Contents
```
api.mustache           (682 bytes)
composer.json.mustache (1011 bytes)
controller.mustache    (1314 bytes)
files.json             (948 bytes)
formrequest.mustache   (1921 bytes)
model.mustache         (2047 bytes)
provider.mustache      (992 bytes)
routes.mustache        (1100 bytes)
README.md              (8275 bytes)
```

#### php-max-slim Directory Contents
```
api.mustache              (798 bytes)
composer.json.mustache    (808 bytes)
controller.mustache       (2453 bytes)
dependencies.mustache     (725 bytes)
files.json                (725 bytes)
model.mustache            (2345 bytes)
routes.mustache           (1199 bytes)
README.md                 (3112 bytes)
```

#### php-max-symfony Directory Contents
```
api.mustache              (682 bytes)
composer.json.mustache    (791 bytes)
controller.mustache       (1958 bytes)
files.json                (745 bytes)
model.mustache            (186 bytes)
model_enum.mustache       (206 bytes)
model_generic.mustache    (2817 bytes)
routes.yaml.mustache      (851 bytes)
services.yaml.mustache    (723 bytes)
```
**Missing:** README.md

#### Required Actions
1. Verify `php-max-default` templates are synchronized with embedded `php-max/` after GENDE-066
2. Create `README.md` for `php-max-symfony` directory
3. Verify all directories follow naming convention

#### Risk Analysis
- **Complexity:** LOW - Mostly documentation work
- **Dependencies:** Should be done AFTER GENDE-066 to ensure consistency

### POC Validation

**Objective:** Verify external template directories work correctly with `-t` flag override.

#### Technical Uncertainties
1. Do external templates produce valid PHP code?
2. Are all required templates present in each external directory?
3. Does files.json configuration work correctly?

#### POC Steps

**Step 1: Test php-max-default templates**
```bash
java -cp ... org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-default \
  -i openapi-generator-specs/tictactoe.yaml \
  -o /tmp/poc-default
```

**Step 2: Test php-max-slim templates**
```bash
java -cp ... org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-slim \
  -i openapi-generator-specs/tictactoe.yaml \
  -o /tmp/poc-slim
```

**Step 3: Test php-max-symfony templates**
```bash
java -cp ... org.openapitools.codegen.OpenAPIGenerator generate \
  -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-symfony \
  -i openapi-generator-specs/tictactoe.yaml \
  -o /tmp/poc-symfony
```

**Step 4: Validate generated code**
- Check PHP syntax validity
- Verify expected file structure
- Confirm no missing template errors

#### Success Criteria
- [ ] All three external template sets generate without errors
- [ ] Generated PHP files have valid syntax
- [ ] files.json configurations are respected
- [ ] No "template not found" warnings

### Clarifications

#### Q1: Should `php-max-default` be identical to embedded `php-max/`?
**Answer:** Not necessarily. The external `php-max-default` serves as:
- A starting point for customization
- A reference implementation
- An alternative that can diverge from embedded

The embedded templates are the "official" default. External `php-max-default` may lag behind or include experimental features.

#### Q2: What's the minimum required file set for external templates?
**Answer:** Minimum viable external template set:
```
model.mustache      # Required - generates DTOs
api.mustache        # Required - generates API classes  
controller.mustache # Required - generates controllers
routes.mustache     # Required - generates routing
README.md           # Required - documents usage
```
Optional but recommended: `files.json`, `composer.json.mustache`

#### Q3: How to handle template version synchronization?
**Answer:** No automatic synchronization. Each external template directory is independently versioned. The README should document:
- Compatible php-max generator version
- Last sync date with embedded templates
- Known differences from embedded

#### Q4: What if external templates reference non-existent variables?
**Answer:** Mustache silently ignores missing variables. Templates should be tested against sample specs. README should document required OpenAPI spec features.

#### Q5: Should we delete obsolete external directories?
**Answer:** No deletions in this ticket. Only:
- Verify existing directories work
- Add missing README.md to php-max-symfony
- Document any issues found

Symfony framework templates for php-max generator.

## Usage
[generation command]

## Generated Structure
[directory tree]

## Requirements
- PHP 8.1+
- Symfony 6.x or 7.x
```

**Task 5: Document findings**
Update ticket with:
- Test results (pass/fail)
- Any errors encountered
- Recommendations

#### Dependencies
- Tasks 1-3: Independent, can run in parallel
- Task 4: Independent
- Task 5: Depends on 1-4
## 5. Acceptance Criteria
- [ ] All directories follow naming convention `openapi-generator-server-php-max-{variant}`
- [ ] Each directory contains complete template set
- [ ] Each directory has README.md with usage instructions
- [ ] Generation works with each template set via `-t` option

### 6.1 Functional Requirements

**FR-067-01: Naming Convention**
All external php-max template directories shall follow the pattern `openapi-generator-server-php-max-{variant}`.

**FR-067-02: Default Templates Directory**
The `openapi-generator-server-php-max-default/` directory shall contain extracted Laravel templates matching the generator's embedded defaults.

**FR-067-03: Symfony Templates Directory**
The `openapi-generator-server-php-max-symfony/` directory shall contain complete Symfony-specific templates.

**FR-067-04: Slim Templates Directory**
The `openapi-generator-server-php-max-slim/` directory shall contain complete Slim-specific templates.

**FR-067-05: README Presence**
Each template directory shall contain a README.md explaining usage and listing included templates.

**FR-067-06: Generation Compatibility**
When the user specifies `-t openapi-generator-server-php-max-{variant}`, the generator shall produce valid {variant} framework code.

### 6.2 Non-Functional Requirements

**NFR-067-01: Template Completeness**
Each framework template directory shall contain ALL templates required for complete code generation (no missing files causing generation errors).

**NFR-067-02: Consistency**
Template file names shall be consistent across all framework directories where functionality overlaps.

### 6.3 Constraints

**CON-067-01: No Generator Modification**
External template directories shall work with the php-max generator WITHOUT requiring generator code changes.

**CON-067-02: Independent Directories**
Each template directory shall be self-contained and not depend on files from other template directories.