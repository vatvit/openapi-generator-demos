---
code: GENDE-068
status: Implemented
dateCreated: 2026-01-07T09:08:32.018Z
type: Documentation
priority: Low
---

# Document php-max generator template customization workflow

## 1. Description

Create documentation explaining how to customize php-max generator for different PHP frameworks using external templates.

## 2. Rationale

- Users need to understand the template override mechanism
- Document the default (Laravel) vs custom framework workflow
- Provide examples for Symfony, Slim, and other frameworks

## 3. Solution Analysis
Create documentation covering:
1. Default templates (Laravel) - what's included
2. How to use external templates (`-t` option)
3. How to create custom framework templates
4. Template variable reference

- Generator purpose and philosophy
- Framework-agnostic design principle

## Quick Start
- Minimal generation command
- Default output structure

## Template Customization                    # NEW SECTION
### Using External Templates
- Available template sets (default, slim, symfony)
- Usage with -t flag
- Where to find templates

### Creating Custom Templates
- Starting from existing templates
- Required files (minimum set)
- files.json configuration

### Template Override Precedence
1. -t flag (highest priority)
2. Embedded templates (default)

## Configuration Options
- CLI options reference
- additionalProperties

## Generated Code Structure
- Directory layout
- File naming conventions

## Limitations
- Link to LIMITATIONS.md
```

#### Size Limits

| Metric | Limit | Rationale |
|--------|-------|-----------|
| README.md total size | 5-15 KB | Comprehensive but scannable |
| New section size | 2-4 KB | Focused on customization |
| Code examples | 3-5 | Cover common use cases |
| External links | 3-5 | To template READMEs |
## 4. Implementation Specification
### Create/update:
- `openapi-generator-generators/php-max/README.md` - generator usage
- `openapi-generator-server-templates/README.md` - template customization guide

### Content:
1. Quick start with defaults
2. Using Symfony templates
3. Using Slim templates  
4. Creating custom templates
5. Available template variables

### Code Fitness Assessment

**Assessment Date:** 2026-01-07

#### Existing Documentation
| File | Location | Size | Status |
|------|----------|------|--------|
| `README.md` | `php-max/` | EXISTS | Basic generator info, needs workflow section |
| `LIMITATIONS.md` | `php-max/` | EXISTS | Known limitations documented |

#### php-max Generator README Analysis
- Contains generator description
- Contains basic usage instructions
- **Missing:** Template customization workflow section
- **Missing:** External template override examples

#### External Template READMEs
- `php-max-default/README.md`: 8275 bytes - comprehensive
- `php-max-slim/README.md`: 3112 bytes - adequate
- `php-max-symfony/README.md`: MISSING (addressed by GENDE-067)

#### Required Documentation Updates
1. Add "Template Customization Workflow" section to generator README
2. Add examples showing `-t` flag usage for each framework
3. Document template override precedence
4. Link to external template directories

#### Risk Analysis
- **Complexity:** LOW - Documentation only
- **Dependencies:** Should be done AFTER GENDE-066 and GENDE-067

### POC Validation

**Objective:** Verify documented workflow is accurate and complete by following it step-by-step.

#### Technical Uncertainties
1. Is the template override mechanism correctly understood?
2. Are all customization options documented?
3. Does the workflow produce expected results?

#### POC Steps

**Step 1: Document the expected workflow**
Write draft documentation covering:
- Default template usage (no `-t` flag)
- External template override (`-t` flag)
- Creating custom templates from scratch
- Modifying existing templates

**Step 2: Follow documented workflow**
Execute each documented step manually:
1. Generate with default templates
2. Generate with external templates
3. Create minimal custom template set
4. Verify override precedence

**Step 3: Validate against actual behavior**
- Compare documented behavior with actual generator behavior
- Identify any discrepancies
- Update documentation to match reality

#### Success Criteria
- [ ] All documented commands execute successfully
- [ ] Expected output matches documented examples
- [ ] No undocumented configuration options discovered
- [ ] Workflow is reproducible by new users

### Clarifications

#### Q1: What's the target audience?
**Answer:** Two audiences:
1. **Primary:** Developers who want to use php-max with a different framework (Slim, Symfony)
2. **Secondary:** Developers who want to customize generated output for their specific needs

Assume familiarity with OpenAPI Generator basics but not php-max internals.

#### Q2: Should documentation include troubleshooting?
**Answer:** Yes, brief troubleshooting section covering:
- "Template not found" errors
- Missing variables in output
- files.json syntax errors

Keep to 3-5 common issues. Detailed troubleshooting goes in LIMITATIONS.md.

#### Q3: How detailed should examples be?
**Answer:** Examples should be:
- Complete (copy-paste runnable)
- Use real paths relative to project structure
- Show expected output structure
- Include both success and common error cases

#### Q4: Where does this documentation live?
**Answer:** 
- **Primary:** `php-max/README.md` (generator directory)
- **Cross-references:** Links to external template READMEs
- **Not duplicated:** Don't copy content from external READMEs

#### Q5: Should we document internal architecture?
**Answer:** No. This ticket focuses on USER-FACING documentation:
- How to USE templates
- How to CUSTOMIZE templates
- How to CREATE new templates

Internal architecture (Java code, template processing) is out of scope.

### Task Breakdown

| # | Task | Constraint | Est. Size |
|---|------|------------|-----------|
| 1 | Draft "Using External Templates" subsection | 500-800 words | ~1.5 KB |
| 2 | Draft "Creating Custom Templates" subsection | 400-600 words | ~1.2 KB |
| 3 | Add code examples | 3-5 examples, runnable | ~1 KB |
| 4 | Add troubleshooting subsection | 3-5 common issues | ~0.5 KB |
| 5 | Review and integrate into README.md | Total addition 2-4 KB | N/A |

#### Task Details

**Task 1: Using External Templates**
Content to cover:
- What external templates are
- Available template sets (default, slim, symfony)
- How to use `-t` flag
- Where templates are located
- Example command

**Task 2: Creating Custom Templates**
Content to cover:
- Starting from existing templates
- Minimum required files
- files.json configuration (optional)
- Testing custom templates

**Task 3: Code Examples**
Examples needed:
1. Generate with default (no -t flag)
2. Generate with external slim templates
3. Generate with external symfony templates
4. Generate with custom templates
5. Verify generated output

Format:
```bash
# Description of what this does
openapi-generator generate -g php-max [options]
```

**Task 4: Troubleshooting**
Issues to document:
1. "Template not found" - check -t path
2. Empty output files - check template syntax
3. Missing variables - check OpenAPI spec
4. files.json errors - validate JSON syntax

**Task 5: Integration**
- Insert new section after "Quick Start"
- Update table of contents if present
- Verify markdown renders correctly

#### Dependencies
- Tasks 1-4: Independent, can be written in parallel
- Task 5: Depends on 1-4
## 5. Acceptance Criteria
- [ ] README in php-max generator explains basic usage
- [ ] Documentation covers template override workflow
- [ ] Examples for at least 2 frameworks (Symfony, Slim)
- [ ] Template variables documented

### 6.1 Functional Requirements

**FR-068-01: Generator README**
The `openapi-generator-generators/php-max/README.md` shall document basic generator usage including CLI commands.

**FR-068-02: Default Usage Documentation**
The documentation shall explain how to generate Laravel code using default templates.

**FR-068-03: Template Override Documentation**
The documentation shall explain how to use `-t` option to specify external templates for other frameworks.

**FR-068-04: Framework Examples**
The documentation shall include working examples for at least Symfony and Slim frameworks.

**FR-068-05: Custom Template Guide**
The documentation shall explain how to create custom templates for new frameworks.

**FR-068-06: Variable Reference**
The documentation shall list available template variables with descriptions and examples.

### 6.2 Non-Functional Requirements

**NFR-068-01: Clarity**
Documentation shall be understandable by developers unfamiliar with the php-max generator.

**NFR-068-02: Completeness**
Documentation shall cover all common use cases without requiring users to read source code.

**NFR-068-03: Examples**
Each major feature shall include at least one copy-paste ready example.

### 6.3 Constraints

**CON-068-01: Markdown Format**
All documentation shall be in Markdown format compatible with GitHub rendering.

**CON-068-02: No External Dependencies**
Documentation shall not require access to external resources (all examples self-contained).