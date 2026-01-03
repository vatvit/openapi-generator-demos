---
code: GENDE-028
status: Won't Do
dateCreated: 2026-01-02T16:05:56.166Z
type: Feature Enhancement
priority: Medium
relatedTickets: GENDE-011,GENDE-002
closedReason: Already supported OOTB. OpenAPI Generator supports config files via `-c config.json`. All php-max additionalProperties (controllerPackage, handlerPackage, etc.) work in config files. Just need to create example configs and update Makefiles to use them.
---

# GENDE-022: Extract php-max Generator CLI Parameters to Configuration File

> ⚠️ **STATUS: NEEDS CLARIFICATION** - Config file format and parameter scope need refinement.

## 1. Description

### Problem Statement
The `php-max` generator accepts additional parameters via CLI arguments. This approach has limitations:
- Long command lines are hard to read and maintain
- Parameters not version-controlled with the project
- Difficult to share configurations across team
- Easy to make typos in repeated CLI invocations
- No validation until runtime

### Current State
- Generator parameters passed via CLI: `--additional-properties=key=value`
- Configuration scattered across Makefiles and shell scripts
- No centralized configuration file for generator options

### Desired State
- Additional parameters defined in a dedicated config file
- CLI can reference config file: `--config-file=php-max-config.yaml`
- Config file version-controlled with project
- Clear documentation of available options
- Validation of config file format

## 2. Rationale

- **Maintainability**: Config files easier to read than long CLI commands
- **Version Control**: Configuration tracked with project history
- **Reproducibility**: Same config = same output
- **Documentation**: Config file serves as self-documentation
- **Flexibility**: Override specific values via CLI when needed
- **Related to GENDE-002**: Supports flexible generator configuration goal

## 3. Solution Analysis

### Questions to Clarify

1. **Config Format**: YAML, JSON, or TOML?
2. **Merge Strategy**: How do CLI params interact with config file?
   - CLI overrides config file?
   - Config file overrides CLI?
   - Merge with precedence?
3. **Config Location**: Project root? Dedicated directory?
4. **Multiple Configs**: Support for environment-specific configs?
5. **Validation**: Schema validation? Required vs optional fields?

### Current CLI Parameters (to extract)

*To be documented - audit current php-max generator parameters:*

| Parameter | Type | Description | Default |
|-----------|------|-------------|--------|
| `framework` | string | Target framework (laravel/symfony) | ? |
| `packageName` | string | Generated package name | ? |
| `invokerPackage` | string | Root namespace | ? |
| `modelPackage` | string | Models namespace | ? |
| `apiPackage` | string | API namespace | ? |
| ... | ... | ... | ... |

### Config File Format Options

**Option A: YAML (Recommended)**
```yaml
# php-max-config.yaml
generator:
  framework: laravel
  phpVersion: "8.3"

package:
  name: petstore-api
  namespace: PetStoreApi\Server
  
namespaces:
  models: Models
  api: Api
  controllers: Http\Controllers
  
features:
  generateTests: true
  generateDocs: true
  strictTypes: true
```

**Option B: JSON**
```json
{
  "generator": {
    "framework": "laravel",
    "phpVersion": "8.3"
  },
  "package": {
    "name": "petstore-api"
  }
}
```

**Option C: Extend existing OpenAPI Generator config**
```json
{
  "generatorName": "php-max",
  "outputDir": "./generated",
  "inputSpec": "./spec.yaml",
  "additionalProperties": {
    "framework": "laravel",
    "phpVersion": "8.3"
  },
  "phpMaxConfig": {
    "features": {
      "generateTests": true
    }
  }
}
```

### Merge Strategy Options

1. **CLI wins**: Config file as defaults, CLI overrides
2. **Config wins**: Config file is authoritative, CLI ignored
3. **Explicit merge**: `--merge-config` flag to combine
4. **Layered**: base.yaml → env.yaml → CLI

**Recommended**: CLI wins (matches common tool behavior)

## 4. Implementation Specification

### Phase 1: Audit Current Parameters
1. [ ] List all current CLI parameters for php-max
2. [ ] Document types, defaults, descriptions
3. [ ] Categorize: required vs optional, framework-specific

### Phase 2: Design Config Schema
1. [ ] Choose format (YAML recommended)
2. [ ] Design config structure with logical groupings
3. [ ] Define JSON Schema for validation
4. [ ] Document all options

### Phase 3: Implement Config Loading
1. [ ] Add config file parsing to generator
2. [ ] Implement merge logic (CLI overrides config)
3. [ ] Add validation against schema
4. [ ] Error handling for invalid config

### Phase 4: Update Generator
1. [ ] Add `--config-file` CLI option
2. [ ] Load and parse config file
3. [ ] Merge with CLI parameters
4. [ ] Pass to generator logic

### Phase 5: Documentation & Migration
1. [ ] Create example config files
2. [ ] Document all config options
3. [ ] Update existing projects to use config files
4. [ ] Update Makefiles to reference config files

## 5. Acceptance Criteria

- [ ] Config file format chosen and documented
- [ ] All CLI additional-properties extractable to config file
- [ ] `--config-file` option implemented in generator
- [ ] CLI parameters override config file values
- [ ] Invalid config produces clear error messages
- [ ] Example config files created for laravel and symfony
- [ ] Existing projects migrated to use config files
- [ ] Documentation updated with config file reference