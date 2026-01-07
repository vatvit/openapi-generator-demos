---
code: GENDE-091
status: Proposed
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

- [ ] Generator class compiles
- [ ] Generator registered in META-INF/services
- [ ] `java -jar ... list` shows the generator
- [ ] Basic generation works (even with empty templates)