---
code: GENDE-019
status: Implemented
dateCreated: 2026-01-01T15:58:35.005Z
type: Technical Debt
priority: Medium
---

# GENDE-007: Extract Code Generation from laravel-max Java to Mustache Templates

> ⚠️ **STATUS: NEEDS CLARIFICATION** - Scope of extraction and priority of specific areas need refinement.

## 1. Description

### Problem Statement
The `laravel-max` custom Java generator likely contains code generation logic hardcoded in Java that could be moved to Mustache templates. This makes the generator:
- Harder to customize without Java knowledge
- More difficult to maintain
- Less flexible for different output variations
- Coupled to Java compilation cycle for changes

### Current State
- Generator location: `tickets/GENDE-001/poc/laravel-max-generator/`
- Java source: `src/main/java/org/openapitools/codegen/laravelmax/LaravelMaxGenerator.java`
- Templates: `src/main/resources/laravel-max/*.mustache`
- Unknown ratio of Java logic vs template logic

### Desired State
- Maximum code generation logic in Mustache templates
- Java code limited to:
  - Data preparation and transformation
  - File routing decisions
  - OpenAPI spec parsing
  - Template variable population
- Template changes don't require Java recompilation

## 2. Rationale

- **Accessibility**: Templates editable without Java expertise
- **Faster Iteration**: No recompile needed for output changes
- **Flexibility**: Easier to create template variants
- **Separation of Concerns**: Java handles data, templates handle presentation
- **Maintainability**: Templates are more readable for PHP developers
- **Alignment**: Follows OpenAPI Generator's intended architecture

## 3. Solution Analysis
### Decisions (Clarified 2026-01-01)

| Question | Decision |
|----------|----------|
| **Scope Priority** | All three: Controller (182 lines), Resource (107 lines), FormRequest (76 lines) |
| **Breaking Changes** | No - match current Java output exactly. Improvements in separate ticket |
| **Validation Rules** | Move to templates (adds complexity but increases flexibility) |
| **Success Criteria** | Run existing tests for functional equivalence |

### Extraction Targets

| Component | Java Method | Lines | Template to Update |
|-----------|-------------|-------|-------------------|
| Controller | `generateControllerContent()` | 182 | `controller.mustache` |
| Resource | `generateResourceContent()` | 107 | `resource.mustache` |
| FormRequest | `generateFormRequestContent()` | 76 | `form-request.mustache` |
| Validation Rules | `getLaravelValidationRules()` | 112 | `form-request.mustache` |

**Total: ~477 lines of Java to extract to templates**

### What Should Stay in Java

1. **OpenAPI Spec Parsing** - Reading and interpreting the spec
2. **Data Transformation** - Converting spec to template variables
3. **File Routing** - Deciding which templates generate which files
4. **Task Collection** - `resourceGenerationTasks`, `controllerGenerationTasks`, `formRequestGenerationTasks`

### What Moves to Templates

1. **All PHP Code Structure** - Classes, methods, properties
2. **String Formatting** - License headers, PHPDoc blocks
3. **Validation Rules** - Laravel validation rule strings
4. **Import/Use Statements** - Namespace imports
5. **Default Implementations** - Stub code, placeholders
## 4. Implementation Specification
### Phase 1: Controller Extraction
1. [ ] Analyze `generateControllerContent()` method (lines 417-599)
2. [ ] Update `controller.mustache` to match exact Java output
3. [ ] Modify Java to use template instead of StringBuilder
4. [ ] Regenerate and run tests

### Phase 2: Resource Extraction  
1. [ ] Analyze `generateResourceContent()` method (lines 278-385)
2. [ ] Update `resource.mustache` to match exact Java output
3. [ ] Modify Java to use template for all resources (not just collections)
4. [ ] Regenerate and run tests

### Phase 3: FormRequest Extraction
1. [ ] Analyze `generateFormRequestContent()` method (lines 1138-1214)
2. [ ] Analyze `getLaravelValidationRules()` method (lines 1219-1331)
3. [ ] Update `form-request.mustache` with validation rule logic
4. [ ] Modify Java to use template instead of StringBuilder
5. [ ] Regenerate and run tests

### Phase 4: Validation
1. [ ] Full regeneration of tictactoe API
2. [ ] Run test suite to verify functional equivalence
3. [ ] Document any template customization points added
## 5. Acceptance Criteria
- [x] Audit document created listing all Java-hardcoded generation
- [x] Identified extractions prioritized and documented
- [x] High-priority extractions completed (Controller, Resource, FormRequest)
- [x] Java code focused on data preparation, not string building
- [x] Generated output unchanged (verified via diff)
- [x] All tests pass after refactoring (52 tests, 77 assertions)
- [x] Template customization possible without Java changes (for extracted areas)

## 6. Current State (2026-01-01)

### Completed Extractions

| Component | Java Lines Removed | Template Updated | Status |
|-----------|-------------------|------------------|--------|
| Controller | 182 lines | `controller.mustache` | ✅ Complete |
| Resource | 107 lines | `resource.mustache` | ✅ Complete |
| FormRequest | 76 lines | `form-request.mustache` | ✅ Complete |

**Total: ~365 lines of Java StringBuilder code extracted to Mustache templates**

### Validation Results

- Regenerated tictactoe and petshop APIs
- Diff comparison: All files identical to Java-generated output
- Integration tests: 52 tests, 77 assertions - all pass

### Remaining Java Logic

The `getLaravelValidationRules()` method (~112 lines) remains in Java to compute validation rules from OpenAPI constraints. This follows a hybrid approach:
- Java prepares validation rule data for each property
- Template iterates over pre-computed rules

This keeps complex type inference in Java while allowing template customization of rule formatting.

### Files Modified

**Java:**
- `LaravelMaxGenerator.java`:
  - `writeControllerFiles()` - now uses `controller.mustache`
  - `writeResourceFiles()` - now uses `resource.mustache`
  - `writeFormRequestFiles()` - now uses `form-request.mustache`
  - Removed `generateControllerContent()` (182 lines)
  - Removed `generateResourceContent()` (107 lines)
  - Removed `generateFormRequestContent()` (76 lines)

**Templates:**
- `controller.mustache` - Updated to match exact Java output
- `resource.mustache` - Updated to match exact Java output
- `form-request.mustache` - Updated with validation rules loop