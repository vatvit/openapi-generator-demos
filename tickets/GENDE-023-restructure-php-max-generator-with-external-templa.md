---
code: GENDE-023
status: Implemented
dateCreated: 2026-01-02T14:34:20.377Z
type: Architecture
priority: High
relatedTickets: GENDE-011, GENDE-024, GENDE-025, GENDE-026
---

# Restructure php-max Generator with External Template System

## 1. Description
### Overview Ticket

This is the **parent ticket** for restructuring php-max generator with external template system.

### Child Tickets

| Ticket | Title | Priority | Status |
|--------|-------|----------|--------|
| GENDE-024 | Per-Operation File Generation | High | Proposed |
| GENDE-025 | files.json Configuration System | Medium | Proposed |
| GENDE-026 | Complete Laravel Template Set | High | Proposed |

### Architecture Goal

```
openapi-generator-generators/php-max/
└── PhpMaxGenerator.java           # Framework-agnostic generator

openapi-generator-server-templates/
├── openapi-generator-server-php-max-default/    # Minimal defaults
├── openapi-generator-server-php-max-laravel/    # Laravel templates
├── openapi-generator-server-php-max-symfony/    # Symfony templates
└── openapi-generator-server-php-max-slim/       # Slim templates
```

### Key Principle

**Generator is framework-agnostic. All framework specifics in templates.**

Developers configure everything via:
1. Template files (`.mustache`)
2. Configuration file (`files.json`)
3. Generator options (`--additional-properties`)
# Default templates (embedded)
openapi-generator generate -g php-max -o output/

# Laravel templates
openapi-generator generate -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-laravel \
  -o output/

# Symfony templates  
openapi-generator generate -g php-max \
  -t openapi-generator-server-templates/openapi-generator-server-php-max-symfony \
  -o output/
```

## 2. Rationale

- **Separation of Concerns**: Generator handles PHP code generation logic; templates handle framework specifics
- **Flexibility**: Developers can create custom template sets without modifying the generator
- **Maintainability**: Framework updates only require template changes, not generator releases
- **Reusability**: Same generator for all PHP frameworks
- **Standards Compliance**: Follows OpenAPI Generator's `-t` template override pattern

## 3. Solution Analysis

### Generator Responsibilities

1. **Expose Raw Data** - Provide template variables:
   - Model properties (name, type, required, nullable)
   - Constraints (minLength, maxLength, pattern, minimum, maximum)
   - Enum values
   - Operation details (path, method, parameters, responses)
   - Security schemes

2. **Configuration Options** - Support additionalProperties:
   - `invokerPackage`, `apiPackage`, `modelPackage`
   - `controllerPackage`, `handlerPackage`, `requestPackage`
   - `srcBasePath` for directory structure
   - Custom flags for template conditionals

3. **No Framework Logic** - Templates decide:
   - Validation syntax (Laravel rules, Symfony annotations, Respect methods)
   - Directory structure (app/Http vs src/Controller)
   - Base classes (JsonResource vs SerializerInterface)
   - File naming conventions

### Template Set Contents

Each template set should contain:

```
openapi-generator-server-php-max-{framework}/
├── model.mustache           # DTOs/Entities
├── api.mustache             # Service interfaces
├── controller.mustache      # HTTP controllers (optional)
├── request.mustache         # Request DTOs/FormRequests (optional)
├── response.mustache        # Response DTOs/Resources (optional)
├── routes.mustache          # Route definitions (optional)
├── README.md                # Template documentation
└── config.json              # Recommended generator config
```

## 4. Implementation Specification
### Core Requirement

**Developers must be able to configure everything via templates** - no Java code changes needed for different file structures.

### Template Loop Types

The generator must support these configurable template loops:

| Loop Type | Iterates Over | Use Case |
|-----------|---------------|----------|
| `model` | Each schema | DTOs, Entities, Enums |
| `api` | Each tag | Handler interfaces |
| `operation` | Each operation | Controllers (one per endpoint) |
| `request` | Each operation with body | FormRequest, Request DTOs |
| `response` | Each response | Resources, Response DTOs |
| `supporting` | Once | Routes, composer.json, providers |

### Configuration via `files.json`

Each template set can include a `files.json` to configure generation:

```json
{
  "templates": {
    "model": {
      "template": "model.mustache",
      "folder": "Model",
      "suffix": ".php"
    },
    "api": {
      "template": "api.mustache",
      "folder": "Handlers",
      "suffix": "HandlerInterface.php"
    },
    "operation": {
      "template": "controller.mustache",
      "folder": "Http/Controllers",
      "suffix": "Controller.php",
      "enabled": true
    },
    "request": {
      "template": "formrequest.mustache",
      "folder": "Http/Requests",
      "suffix": "FormRequest.php",
      "condition": "hasBodyParam"
    },
    "response": {
      "template": "resource.mustache",
      "folder": "Http/Resources",
      "suffix": "Resource.php",
      "condition": "is2xx"
    }
  },
  "supporting": [
    {
      "template": "routes.mustache",
      "output": "routes/api.php"
    },
    {
      "template": "composer.json.mustache",
      "output": "composer.json"
    },
    {
      "template": "provider.mustache",
      "output": "Providers/GeneratedServiceProvider.php"
    }
  ]
}
```

### Generator Changes Required

1. **Read `files.json`** from template directory if present
2. **Per-operation loop** - Iterate operations and generate files
3. **Per-response loop** - Iterate responses and generate files
4. **Conditional generation** - Skip files based on conditions
5. **Flexible naming** - Configure folder/suffix per template type

### Implementation Phases

#### Phase 1: Per-Operation Support
- Add operation iteration in `PhpMaxGenerator.java`
- Support `operation` template type
- Enable one-controller-per-endpoint pattern

#### Phase 2: Configuration File
- Read `files.json` from template directory
- Configure which templates to generate
- Configure output paths and naming

#### Phase 3: Per-Response Support
- Add response iteration
- Support `response` template type
- Enable one-resource-per-response pattern

#### Phase 4: Conditional Generation
- Add condition evaluation
- Skip templates based on operation/response properties
- e.g., only generate FormRequest if operation has body

### Default Templates (Minimal)

Default `files.json`:
```json
{
  "templates": {
    "model": {
      "template": "model.mustache",
      "folder": "Model",
      "suffix": ".php"
    },
    "api": {
      "template": "api.mustache",
      "folder": "Api",
      "suffix": "Interface.php"
    }
  },
  "supporting": []
}
```

### Laravel Templates (Full)

Laravel `files.json`:
```json
{
  "templates": {
    "model": { "template": "model.mustache", "folder": "Models", "suffix": ".php" },
    "api": { "template": "handler.mustache", "folder": "Handlers", "suffix": "HandlerInterface.php" },
    "operation": { "template": "controller.mustache", "folder": "Http/Controllers", "suffix": "Controller.php" },
    "request": { "template": "formrequest.mustache", "folder": "Http/Requests", "suffix": "FormRequest.php", "condition": "hasBodyParam" },
    "response": { "template": "resource.mustache", "folder": "Http/Resources", "suffix": "Resource.php" }
  },
  "supporting": [
    { "template": "routes.mustache", "output": "routes/api.php" },
    { "template": "provider.mustache", "output": "Providers/ApiServiceProvider.php" }
  ]
}
```
## 5. Acceptance Criteria
### Generator Capabilities
- [ ] Supports per-model file generation (existing)
- [ ] Supports per-tag/api file generation (existing)
- [ ] Supports per-operation file generation (NEW)
- [ ] Supports per-response file generation (NEW)
- [ ] Supports supporting files generation (NEW)
- [ ] Reads `files.json` configuration from template directory
- [ ] Configurable output folder per template type
- [ ] Configurable file suffix per template type
- [ ] Conditional generation based on operation properties

### Template Sets
- [ ] Default templates work standalone
- [ ] Laravel template set generates complete library
- [ ] Symfony template set generates complete library
- [ ] Each template set has `files.json` configuration
- [ ] Each template set has README documentation

### Developer Experience
- [ ] No Java code changes needed for new file structures
- [ ] Templates fully control output structure
- [ ] Clear documentation of available template variables
- [ ] Example configurations for common patterns

## 6. Current State
**Last Updated:** 2026-01-02

### Status: EPIC COMPLETE ✅

All child tickets have been implemented:

| Ticket | Title | Status |
|--------|-------|--------|
| GENDE-024 | Per-Operation File Generation | ✅ Implemented |
| GENDE-025 | files.json Configuration System | ✅ Implemented |
| GENDE-026 | Complete Laravel Template Set | ✅ Implemented |

### Completed Features

**Generator Capabilities:**
- ✅ Per-model file generation (model.mustache)
- ✅ Per-tag/api file generation (api.mustache)
- ✅ Per-operation file generation (controller.mustache, formrequest.mustache)
- ✅ Supporting files generation (routes.mustache, provider.mustache, composer.json.mustache)
- ✅ Reads `files.json` configuration from template directory
- ✅ Configurable output folder per template type
- ✅ Configurable file suffix per template type
- ✅ Conditional generation based on operation properties (hasBodyParam, etc.)

**Template Sets:**
- ✅ Default templates in `openapi-generator-server-php-max-default/`
- ✅ Laravel template set in `openapi-generator-server-php-max-laravel/`

### Laravel Template Set Contents

```
openapi-generator-server-php-max-laravel/
├── model.mustache           # DTOs with typed properties
├── api.mustache             # Handler interfaces
├── controller.mustache      # HTTP controllers (per-operation)
├── formrequest.mustache     # Request validation (conditional)
├── routes.mustache          # Route definitions
├── provider.mustache        # Service provider
├── composer.json.mustache   # Package configuration
├── files.json               # Template configuration
└── README.md                # Documentation
```

### Generated Output Structure

```
output/
├── composer.json
├── Providers/ApiServiceProvider.php
├── routes/api.php
└── lib/
    ├── Model/              # DTOs and Enums
    ├── Api/                # Handler interfaces
    └── Http/
        ├── Controllers/    # One controller per operation
        └── Requests/       # FormRequests (conditional)
```

### Remaining Enhancements (Future)

- [ ] Resource/Response templates (per-response generation)
- [ ] PHPStan validation testing
- [ ] Integration test with real Laravel app
- [ ] Symfony template set
- [ ] Slim template set