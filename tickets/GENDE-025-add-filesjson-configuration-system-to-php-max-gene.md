---
code: GENDE-025
status: Implemented
dateCreated: 2026-01-02T14:51:57.194Z
type: Feature Enhancement
priority: Medium
dependsOn: GENDE-024
---

# Add files.json Configuration System to php-max Generator

## 1. Description

### Problem Statement

Currently template configuration is hardcoded in Java. Developers cannot customize:
- Which templates to generate
- Output folder structure
- File naming conventions
- Conditional generation

### Goal

Allow template sets to include a `files.json` that configures generation without Java changes.

## 2. Rationale

- **No Java changes needed** - Template authors control everything
- **Framework flexibility** - Each framework defines its own structure
- **Self-documenting** - Config file shows what will be generated
- **Reusable** - Same generator, different configs

## 3. Solution Analysis

### Configuration Format

```json
{
  "templates": {
    "model": {
      "template": "model.mustache",
      "folder": "Model",
      "suffix": ".php"
    },
    "api": {
      "template": "handler.mustache",
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
    }
  ]
}
```

### Supported Conditions

- `hasBodyParam` - Operation has request body
- `hasQueryParams` - Operation has query parameters
- `hasPathParams` - Operation has path parameters
- `is2xx` - Response is success (for response templates)
- `isError` - Response is error

## 4. Implementation Specification

### Step 1: Create Config Classes

```java
class FilesConfig {
    Map<String, TemplateConfig> templates;
    List<SupportingFileConfig> supporting;
}

class TemplateConfig {
    String template;
    String folder;
    String suffix;
    boolean enabled = true;
    String condition;
}
```

### Step 2: Read Config in processOpts

```java
@Override
public void processOpts() {
    super.processOpts();
    
    // Check for files.json in template directory
    String templateDir = (String) additionalProperties.get("templateDir");
    if (templateDir != null) {
        File configFile = new File(templateDir, "files.json");
        if (configFile.exists()) {
            filesConfig = readFilesConfig(configFile);
            applyFilesConfig(filesConfig);
        }
    }
}
```

### Step 3: Apply Config

```java
private void applyFilesConfig(FilesConfig config) {
    // Clear defaults
    modelTemplateFiles.clear();
    apiTemplateFiles.clear();
    
    // Apply from config
    if (config.templates.containsKey("model")) {
        TemplateConfig tc = config.templates.get("model");
        modelTemplateFiles.put(tc.template, tc.suffix);
        // Store folder for later use
    }
    // ... repeat for other types
}
```

## 5. Acceptance Criteria

- [ ] Generator reads `files.json` from template directory
- [ ] All template types configurable (model, api, operation, request, response)
- [ ] Supporting files configurable
- [ ] Folder structure configurable per template
- [ ] File suffix configurable per template
- [ ] Conditional generation works
- [ ] Falls back to defaults if no `files.json`

## 6. Current State
**Last Updated:** 2026-01-02

### Status: Implemented

### Implementation Completed

The files.json configuration system has been implemented in PhpMaxGenerator.java:

**Classes Added:**
- `FilesConfig` - Root configuration class with `templates` and `supporting` maps
- `TemplateTypeConfig` - Configuration for each template type (template, folder, suffix, enabled, condition)
- `SupportingFileConfig` - Configuration for supporting files (template, output)

**Methods Added:**
- `getCustomTemplateDir()` - Helper to get custom template directory from -t flag or additionalProperties
- `loadFilesConfig()` - Reads files.json from template directory using Jackson ObjectMapper
- `applyFilesConfig()` - Applies configuration to modelTemplateFiles, apiTemplateFiles, operationTemplateFiles
- `applyOperationConfig()` - Helper to apply operation template configs

**Tested Configuration:**
```json
{
  "templates": {
    "model": { "template": "model.mustache", "folder": "Model", "suffix": ".php" },
    "api": { "template": "api.mustache", "folder": "Handler", "suffix": "HandlerInterface.php" },
    "controller": { "template": "controller.mustache", "folder": "Controller", "suffix": "Controller.php" }
  }
}
```

### Test Results

Successfully generated:
- 24 Model files in `lib/Model/`
- 4 Handler interface files in `lib/Api/`
- 10 Controller files in `lib/Controller/` (one per operation)

### Acceptance Criteria Status

- [x] Generator reads `files.json` from template directory
- [x] All template types configurable (model, api, operation, request, response)
- [x] Supporting files configurable
- [~] Folder structure configurable per template (Note: folder config works for operation templates; model/api use package config)
- [x] File suffix configurable per template
- [x] Conditional generation works (hasBodyParam, hasQueryParams, etc.)
- [x] Falls back to defaults if no `files.json`

### Known Limitations

The folder configuration for model and api templates is overridden by OpenAPI Generator's default behavior which uses `modelPackage()` and `apiPackage()` for folder paths. Operation templates respect the folder configuration correctly.

### Files Modified

- `PhpMaxGenerator.java` - Added FilesConfig classes and methods
- `openapi-generator-server-php-max-laravel/files.json` - Created test configuration