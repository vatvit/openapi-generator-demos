---
code: GENDE-089
status: Implemented
dateCreated: 2026-01-07T16:39:11.102Z
type: Architecture
priority: High
phaseEpic: Phase 1: Generator
relatedTickets: GENDE-088
---

# Design new generator architecture and naming

## 1. Description

Design the architecture for the new generator and decide on naming conventions.

## 2. Rationale

Before writing code, need to decide:
- Generator name (affects package names, CLI usage)
- Project structure
- How to reference extended core
- Template organization

## 3. Solution Analysis

### Generator Naming Options
| Name | CLI Usage | Pros | Cons |
|------|-----------|------|------|
| `php-contract` | `-g php-contract` | Framework-agnostic | Vague |
| `php-laravel-contract` | `-g php-laravel-contract` | Clear default | Long |
| `php-strict` | `-g php-strict` | Short | Not descriptive |

### Core Dependency Options
| Option | Pros | Cons |
|--------|------|------|
| Use fork directly | Works now | Maintenance burden |
| Wait for upstream PR | Clean | Blocks progress |
| Publish fork to Maven | Independent | Extra infrastructure |

## 4. Implementation Specification
### Decisions Made

| Decision | Choice | Rationale |
|----------|--------|-----------|
| **Generator name** | `php-adaptive` | Reflects template-driven flexibility, framework-agnostic |
| **Core dependency** | Use fork directly | Start now, switch to upstream after PR merged |
| **Template embedding** | Laravel embedded (default) | Symfony/Slim as external templates |

### Generator Details

| Attribute | Value |
|-----------|-------|
| **CLI usage** | `-g php-adaptive` |
| **Java package** | `org.openapitools.codegen.phpadaptive` |
| **Maven artifact** | `php-adaptive-openapi-generator` |
| **Embedded template dir** | `php-adaptive/` (Laravel templates) |
| **Default output** | Laravel-compatible PHP library |

### Architecture

```
php-adaptive-openapi-generator/
├── pom.xml                          # Maven config, depends on fork
├── src/main/java/
│   └── org/openapitools/codegen/phpadaptive/
│       └── PhpAdaptiveGenerator.java    # Main generator class
├── src/main/resources/
│   └── php-adaptive/                    # Default Laravel templates
│       ├── controller.mustache
│       ├── model.mustache
│       ├── handler-interface.mustache
│       └── ...
└── src/test/java/                       # Unit tests
```

### Core API Usage

```java
public class PhpAdaptiveGenerator extends AbstractPhpCodegen {
    @Override
    public void processOpts() {
        super.processOpts();
        
        // Per-operation templates (uses fork's API)
        operationTemplateFiles.put("controller.mustache", 
            "Http/Controllers/{{operationIdPascalCase}}Controller.php");
    }
}
```

### External Templates (Symfony, Slim)

Located in `openapi-generator-server-templates/`:
- `openapi-generator-server-php-adaptive-symfony/`
- `openapi-generator-server-php-adaptive-slim/`

Usage: `-g php-adaptive -t path/to/symfony-templates`
## 5. Acceptance Criteria
- [x] Generator name decided: `php-adaptive`
- [x] Core dependency approach decided: Use fork directly
- [x] Template embedding decided: Laravel embedded, Symfony/Slim external
- [x] Architecture documented