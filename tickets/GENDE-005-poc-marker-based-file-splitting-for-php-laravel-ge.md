---
code: GENDE-005
status: Implemented
dateCreated: 2025-12-31T20:31:29.624Z
type: Architecture
priority: Medium
---

# POC: Marker-Based File Splitting for php-laravel Generator

## 1. Description
### Problem Statement

OpenAPI Generator's `files` configuration mechanism only supports three granularity levels:
- Per API class (tag)
- Per model (schema)
- Once per spec (supporting files)

This prevents generating **per-operation files** (one controller per operation) using pure template configuration. The `laravel-max` custom generator solves this with Java code, but this requires maintaining a custom generator.

### Hypothesis

We can achieve per-operation file generation using the **standard php-laravel generator** by:
1. Generating all classes in one file per tag (using `files` config)
2. Adding special markers between classes in templates
3. Using OpenAPI Generator's **built-in post-processing hook** (`PHP_POST_PROCESS_FILE` + `--enable-post-process-file`) to automatically split the combined file into separate files

### Key Insight

OpenAPI Generator has a built-in feature for post-processing generated files:
```bash
export PHP_POST_PROCESS_FILE="/path/to/split-script.php"
openapi-generator-cli generate ... --enable-post-process-file
```

The generator automatically runs the specified script on each generated PHP file. This means:
- **No manual steps** - splitting happens as part of generation
- **Transparent to users** - just run the generator command
- **No custom Java code** - only templates + a PHP script

### Goal

Prove (or disprove) that this approach works with a standard generator, enabling per-operation files without custom Java code and without manual post-processing steps.

### Scope

- Use standard `php-laravel` generator (no Java modifications)
- Custom templates with markers
- Post-processing script triggered by OpenAPI Generator's built-in hook
- Integration test project to validate
## 2. Rationale

### Why Try This?

1. **No custom Java generator needed** - Use standard OpenAPI Generator
2. **Template-driven customization** - All customization via `-t` flag
3. **Simpler maintenance** - No JAR to build/maintain
4. **Reusable pattern** - If it works, applicable to other generators

### Comparison with laravel-max

| Aspect | laravel-max | Marker Approach |
|--------|-------------|------------------|
| Generator | Custom Java | Standard php-laravel |
| Per-operation files | Java code | Template + script |
| Customization | Rebuild JAR | Edit templates |
| Maintenance | Java + templates | Templates + script |
| Complexity | High (Java) | Medium (script) |

### Risk Assessment

| Risk | Mitigation |
|------|------------|
| Markers in output | Use unique string unlikely in code |
| Script complexity | Start simple, iterate |
| Edge cases | Comprehensive test cases |
| Performance | Acceptable for code generation |

## 3. Solution Analysis

### Marker Format

```
---SPLIT:{{operationIdCamelCase}}Controller.php---
```

This marker includes the target filename, making splitting straightforward.

### Template Structure

```mustache
{{#operations}}
{{#operation}}
<?php declare(strict_types=1);

namespace {{apiPackage}}\Http\Controllers;

class {{operationIdCamelCase}}Controller
{
    // Controller implementation
}

---SPLIT:{{operationIdCamelCase}}Controller.php---
{{/operation}}
{{/operations}}
```

### Post-Processing Script

```bash
#!/bin/bash
# split-files.sh

INPUT_FILE=$1
OUTPUT_DIR=$2

# Split by marker and write to separate files
csplit -f "$OUTPUT_DIR/part_" "$INPUT_FILE" '/---SPLIT:/' '{*}'

# Rename parts based on marker content
# ... extraction logic
```

### Alternative: PHP Script

```php
<?php
$content = file_get_contents($argv[1]);
$parts = preg_split('/---SPLIT:([^-]+)---/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
// Write each part to its filename
```

## 4. Implementation Specification

### Directory Structure

```
openapi-generator-demos/
├── openapi-generator-generators/
│   └── php-laravel-split/           # NEW: Scripts and docs
│       ├── README.md
│       ├── Makefile
│       └── scripts/
│           └── split-files.sh       # Post-processing script
├── openapi-generator-server-templates/
│   └── php-laravel-split/            # NEW: Custom templates
│       ├── controller.mustache
│       ├── resource.mustache
│       └── ... (other templates)
├── generated/
│   └── php-laravel-split/            # NEW: Generated output
│       └── tictactoe/
└── projects/
    └── laravel-api--php-laravel-split--integration-tests/  # NEW: Test project
```

### Phase 1: Setup

**Task 1.1**: Create directory structure
- `openapi-generator-generators/php-laravel-split/`
- `openapi-generator-server-templates/php-laravel-split/`

**Task 1.2**: Extract default php-laravel templates
```bash
openapi-generator-cli author template -g php-laravel -o php-laravel-split/
```

**Task 1.3**: Create Makefile with generation and split commands

### Phase 2: Template Modification

**Task 2.1**: Modify `api.mustache` (or controller template) to add markers

**Task 2.2**: Test that markers appear in generated output

### Phase 3: Split Script

**Task 3.1**: Create split script (bash or PHP)

**Task 3.2**: Test split script on generated output

**Task 3.3**: Integrate split into Makefile

### Phase 4: Integration Test

**Task 4.1**: Create Laravel test project

**Task 4.2**: Configure autoloading for split files

**Task 4.3**: Write tests to verify generated code works

### Phase 5: Evaluation

**Task 5.1**: Document findings
- Does it work?
- What are the limitations?
- Is it better than laravel-max approach?

**Task 5.2**: Decide next steps
- Adopt this approach?
- Abandon and stick with laravel-max?
- Hybrid approach?

## 5. Acceptance Criteria
- [x] Custom templates with split markers created
- [x] Post-processing script created
- [x] Tested with OpenAPI Generator's built-in hook
- [x] Documented limitation with Docker-based workflows
- [x] Recommendation provided
## 6. Current State
**Last Updated:** 2026-01-01

### Status: POC Complete - Not Viable for Docker Workflows

### Summary

The marker-based file splitting approach using OpenAPI Generator's built-in post-processing hook (`PHP_POST_PROCESS_FILE` + `--enable-post-process-file`) **does not work with Docker-based workflows**.

### Root Cause

1. OpenAPI Generator runs inside Docker container (`openapitools/openapi-generator-cli`)
2. Post-process script must execute inside that same container
3. The openapi-generator Docker image does not include PHP or sufficient tools for file splitting
4. Error: `Cannot run program "/scripts/post-process-split.php": error=13, Permission denied`

### What Was Tested

1. ✅ Custom templates with `---SPLIT:filename---` markers - **works**
2. ✅ Manual post-processing script to split files - **works**
3. ❌ Built-in `PHP_POST_PROCESS_FILE` hook with Docker - **does not work**

### Limitation

The post-processing hook feature is designed for **host-based generation** where:
- Generator runs directly on the host (not in Docker)
- Host has PHP/tools installed
- Script can execute in host environment

For **Docker-based workflows** (which this project uses), the hook cannot execute custom scripts because the generator container lacks the required runtime.

### Conclusion

**The approach is not viable for this project** because:
1. Project mandates Docker-based development (no local PHP/npm/node)
2. Post-processing hook requires tools not available in generator container
3. Manual post-processing step defeats the purpose (not transparent)

### Recommendation

**Continue using `laravel-max` custom generator** which:
- Generates per-operation files natively (no post-processing)
- Works with Docker-based workflows
- Provides full control over generated code structure

### Alternative for Other Projects

For projects that run openapi-generator on the host (not Docker), the post-processing hook approach could work:

```bash
export PHP_POST_PROCESS_FILE="/path/to/split-script.php"
openapi-generator-cli generate ... --enable-post-process-file
```

### Artifacts Created (for reference)

| Artifact | Path |
|----------|------|
| Templates with markers | `openapi-generator-server-templates/openapi-generator-server-php-laravel-split/` |
| Split script (manual) | `openapi-generator-generators/php-laravel-split/scripts/split-files.php` |
| Makefile | `openapi-generator-generators/php-laravel-split/Makefile` |