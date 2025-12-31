---
code: GENDE-004
status: Approved
dateCreated: 2025-12-30T23:07:05.790Z
type: Documentation
priority: Medium
---

# GENDE-004: Compare laravel-max Generator with OpenAPI php-laravel Generator

## 1. Description
### Problem Statement
We have two approaches for generating Laravel libraries:
1. **laravel-max** - Custom Java-based generator extending AbstractPhpCodegen
2. **php-laravel** - OpenAPI Generator's built-in generator with custom templates

A formal comparison is needed to justify architectural decisions and guide future investment.

### Current State
- **laravel-max generator** exists at `openapi-generator-generators/laravel-max/`
  - Achieved GOAL_MAX.md compliance (18/18 tests passing)
  - Generates: Controllers, FormRequests, Resources, DTOs, Security interfaces
- **php-laravel + templates** exists at `openapi-generator-server-templates/openapi-generator-server-php-laravel/`
  - Custom templates on top of built-in generator
  - Demo project at `projects/laravel-api--php-laravel--replaced-tags/`

### Desired Outcome
Detailed feature-by-feature comparison document showing:
- Generated code quality against GOAL_MAX.md requirements
- Feature gaps in each approach
- Clear recommendation for future investment direction

### Scope Decisions (Finalized)

| Question | Decision |
|----------|----------|
| **Comparison Depth** | Detailed feature-by-feature |
| **Focus** | Generated code quality only (not generator maintainability) |
| **Benchmark Specs** | Both PetStore and TicTacToe |
| **Audience** | Internal decision-making |
## 2. Rationale
### Why Re-Evaluate?

The laravel-max custom generator was built because php-laravel appeared to have structural limitations. However:

1. **Assumptions may be wrong**: Initial limitations assessment may have missed workarounds or newer features
2. **Template-only is simpler**: If php-laravel + templates CAN achieve GOAL_MAX.md, that's valuable to know
3. **Community support**: Built-in generators get updates and bug fixes from OpenAPI Generator community

### Key Questions to Answer

1. **Can php-laravel generate one file per operation?**
   - Initial belief: No (templates iterate per-tag)
   - Re-investigate: `files` config, vendor extensions, template tricks?

2. **Can php-laravel generate per-response Resources?**
   - Initial belief: No (no per-response loop in templates)
   - Re-investigate: Custom supporting files? Post-processing?

3. **Can php-laravel compute union return types?**
   - Initial belief: No (Mustache is logic-less)
   - Re-investigate: Pre-computed in generator config? Vendor extensions?

4. **What CAN php-laravel do with maximal template customization?**
   - Push templates to their limit before concluding "impossible"

### Deliverable

**Research documentation only** - document php-laravel capabilities and limitations with evidence. No recommendation required.
## 3. Solution Analysis
### Comparison Framework

Since focus is on **generated code quality** for **internal decision-making**, the comparison will evaluate each approach against GOAL_MAX.md requirements.

### GOAL_MAX.md Feature Matrix

| Feature | laravel-max | php-laravel + Templates | Notes |
|---------|:-----------:|:-----------------------:|-------|
| **Controllers** | | | |
| One controller per operation | ? | ? | Invokable controllers |
| Constructor injection | ? | ? | DI for API interfaces |
| Type-safe request handling | ? | ? | FormRequest injection |
| **Request Handling** | | | |
| FormRequest generation | ? | ? | Auto-validation from schema |
| Query parameter DTOs | ? | ? | Typed GET params |
| Body parameter DTOs | ? | ? | Typed POST/PUT bodies |
| **Response Handling** | | | |
| One Resource per response code | ? | ? | CreateGame201Resource |
| HTTP status code hardcoded | ? | ? | Compile-time enforcement |
| Required headers validation | ? | ? | Location header etc. |
| ResourceCollection support | ? | ? | Array responses |
| **Type Safety** | | | |
| Typed DTO properties | ? | ? | PHP 8.1+ types |
| Union return types | ? | ? | `201Resource\|400Resource` |
| Enum support | ? | ? | PHP 8.1 enums |
| DateTime handling | ? | ? | ISO8601 parsing |
| **Security** | | | |
| Security interface per scheme | ? | ? | Contract for auth |
| Security middleware stubs | ? | ? | Example implementations |
| SecurityValidator | ? | ? | Debug-time validation |
| Conditional middleware | ? | ? | `hasMiddlewareGroup()` |
| **API Interfaces** | | | |
| Interface per tag/group | ? | ? | Handler contracts |
| Type-safe method signatures | ? | ? | Request→Response |
| **Models/DTOs** | | | |
| fromArray() factory | ? | ? | Hydration |
| toArray() serialization | ? | ? | JSON output |
| Nullable properties | ? | ? | Optional fields |
| **Routes** | | | |
| Auto-generated routes | ? | ? | From OpenAPI paths |
| Middleware application | ? | ? | Security schemes |
| Route naming | ? | ? | For URL generation |

### Key Architectural Differences

| Aspect | laravel-max | php-laravel + Templates |
|--------|-------------|------------------------|
| **File-per-operation control** | Java code controls file generation | Limited by generator's template loop |
| **Response code resources** | Custom Java logic generates per-response | Template can only iterate available vars |
| **Union type generation** | Java computes union types | Mustache cannot compute dynamically |

### Expected Outcome

Based on GENDE-001 findings, php-laravel templates have **structural limitations**:
1. Cannot generate one file per operation (templates iterate per-tag)
2. Cannot generate one Resource per response code (no per-response loop)
3. Cannot compute union return types (Mustache is logic-less)

The comparison will **document these gaps with evidence** from generated code.

### Investigation Approach

For each identified limitation, investigate:

#### 1. One File Per Operation
**Potential solutions to investigate:**
- `files` configuration in generator config JSON
- Custom `supportingFiles` configuration
- `x-]` vendor extensions in OpenAPI spec
- Post-generation script to split files
- Different generator (php-slim, php-symfony) as base

#### 2. Per-Response Resources
**Potential solutions to investigate:**
- `responses` variable in operation context
- Nested loops in Mustache (`{{#responses}}`)
- Supporting file templates with response iteration
- Vendor extensions to expose response codes

#### 3. Union Return Types
**Potential solutions to investigate:**
- Pre-compute in `additionalProperties` config
- Vendor extensions (`x-union-type`)
- Mustache helpers/lambdas
- Generator-level hooks (if php-laravel supports)

#### 4. General Template Capabilities
**Document what's available:**
- Full list of template variables for php-laravel
- All configuration options
- Vendor extension support
- Supporting files mechanism

### Research Resources
**Generator Source (to download/analyze):**
- OpenAPI Generator GitHub: https://github.com/OpenAPITools/openapi-generator
- PhpLaravelServerCodegen.java: `modules/openapi-generator/src/main/java/org/openapitools/codegen/languages/PhpLaravelServerCodegen.java`
- AbstractPhpCodegen.java: `modules/openapi-generator/src/main/java/org/openapitools/codegen/languages/AbstractPhpCodegen.java`
- Default php-laravel templates: `modules/openapi-generator/src/main/resources/php-laravel/`

**Documentation:**
- Template variable documentation: https://openapi-generator.tech/docs/templating
- Generator customization: https://openapi-generator.tech/docs/customization
- Mustache manual: https://mustache.github.io/mustache.5.html

**Local resources:**
- Existing custom templates: `openapi-generator-server-templates/openapi-generator-server-php-laravel/`
- Default templates (extracted): `openapi-generator-server-templates/openapi-generator-server-php-laravel-default/`
## 4. Implementation Specification
### Phase 1: Document Current php-laravel Capabilities
**1.1 Download and analyze php-laravel generator source**
- Clone/download OpenAPI Generator repository (or fetch specific files)
- Deep analysis of `PhpLaravelServerCodegen.java`:
  - All template variables exposed to Mustache
  - All configuration options (`additionalProperties`)
  - File generation logic (what loops exist: per-model, per-api, per-operation?)
  - Supporting files mechanism
  - Vendor extension support (`x-` properties)
  - Parent class capabilities (`AbstractPhpCodegen`)
- Document findings with code references

**1.2 Extract and analyze default php-laravel templates**
- Extract default templates to `openapi-generator-server-templates/openapi-generator-server-php-laravel-default/`
- Document template structure and variables used
- Identify what's customizable vs hardcoded in Java

**1.3 Analyze existing custom templates**
- Review `openapi-generator-server-templates/openapi-generator-server-php-laravel/`
- Document what's already customized
- Identify gaps vs GOAL_MAX.md
### Phase 2: Investigate Limitation Workarounds

**2.1 One file per operation**
- Test `files` config for per-operation file generation
- Test `supportingFiles` with operation iteration
- Research OpenAPI Generator hooks/callbacks
- Document findings with evidence

**2.2 Per-response Resources**
- Examine `responses` variable availability in templates
- Test nested response iteration in Mustache
- Research vendor extensions approach
- Document findings with evidence

**2.3 Union return types**
- Test pre-computing types via config
- Test vendor extension approach
- Research Mustache lambda capabilities
- Document findings with evidence

### Phase 3: Generate Comparison Output

**3.1 Generate with laravel-max**
```bash
cd openapi-generator-generators/laravel-max
make generate SPEC=tictactoe OUTPUT_DIR=generated/tictactoe
make generate SPEC=petstore OUTPUT_DIR=generated/petstore
```

**3.2 Generate with php-laravel (current templates)**
```bash
make generate-tictactoe
make generate-petshop
```

**3.3 Generate with php-laravel (experimental improvements)**
- Apply any discovered workarounds
- Generate and compare

### Phase 4: Create Comparison Document

**Location**: `docs/GENERATOR-COMPARISON.md`

**Structure**:
1. Executive Summary
2. Feature Matrix (with investigation results)
3. Limitation Analysis (confirmed vs solved)
4. Code Examples (side-by-side)
5. Investment Recommendation

### Output Artifacts

| Artifact | Location |
|----------|----------|
| Comparison document | `docs/GENERATOR-COMPARISON.md` |
| php-laravel capability analysis | In comparison document |
| Workaround research notes | In comparison document |
| Generated output samples | `generated/` directories |

## 5. Acceptance Criteria
- [ ] Both generators produce output from TicTacToe spec
- [ ] Both generators produce output from PetStore spec
- [ ] Feature matrix completed with ✅/⚠️/❌ scores for all GOAL_MAX.md features
- [ ] Side-by-side code examples documented for key differences
- [ ] php-laravel limitations documented with evidence (confirmed limitation or workaround found)
- [ ] Comparison document created at `docs/GENERATOR-COMPARISON.md`