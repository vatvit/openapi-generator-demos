---
code: GENDE-091
status: Implemented
dateCreated: 2026-01-07T16:39:11.241Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 1: Generator
relatedTickets: GENDE-088,GENDE-090
dependsOn: GENDE-090
---

# Implement base generator class

## 1. Description

Implement the base generator class that extends AbstractPhpCodegen and configures per-operation generation.

## 2. Rationale

The generator class is the core that:
- Defines what files to generate
- Configures template variables
- Sets up per-operation generation

## 3. Solution Analysis

### Key Methods to Implement
| Method | Purpose |
|--------|----------|
| `getName()` | Generator name for CLI |
| `getHelp()` | Help text |
| `processOpts()` | Process options |
| `apiFilename()` | Define output filenames |
| `toApiFilename()` | Per-operation filename pattern |

### Per-Operation Configuration
```java
// In files configuration
{
  "templateFile": "controller.mustache",
  "destinationFilename": "{{operationIdPascalCase}}Controller.php",
  "folder": "Http/Controllers",
  "templateType": "Operation"
}
```

## 4. Implementation Specification

### Generator Class
```java
public class {Name}Generator extends AbstractPhpCodegen {
    // Configure per-operation generation
    // Set up Laravel-specific conventions
    // Define template variable enrichment
}
```

## 5. Acceptance Criteria
- [x] Generator class compiles (`mvn compile` succeeds)
- [x] Generator registered in META-INF/services (`org.openapitools.codegen.CodegenConfig`)
- [x] `java -jar ... list` shows `php-adaptive` generator
- [x] Basic generation works with placeholder templates

### Implementation Notes

**Generator Class:** `PhpAdaptiveGenerator.java`
- Extends `AbstractPhpCodegen`
- Configures `operationTemplateFiles()`, `apiTemplateFiles()`, `modelTemplateFiles()`, `supportingFiles`
- Clears parent class defaults before adding custom templates
- Disables doc/test generation with `.clear()` calls

**Key Fixes Applied:**
- Used full path for `camelize()`: `org.openapitools.codegen.utils.StringUtils.camelize()`
- Cleared parent defaults: `apiTemplateFiles().clear()`, `modelTemplateFiles().clear()`, `supportingFiles.clear()`
- Disabled doc generation: `apiDocTemplateFiles().clear()`, `modelDocTemplateFiles().clear()`, etc.

**Test Output:** Successfully generates 10 controllers, 10 requests, 10 responses, 4 handler interfaces, 24 models, and supporting files from TicTacToe spec.