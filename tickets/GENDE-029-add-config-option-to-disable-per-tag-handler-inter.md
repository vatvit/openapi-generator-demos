---
code: GENDE-029
status: Implemented
dateCreated: 2026-01-03T09:06:15.907Z
type: Feature Enhancement
priority: Medium
relatedTickets: GENDE-011,GENDE-027
---

# Add config option to disable per-tag handler interface generation in php-max

## 1. Description
The php-max generator should skip file creation when a template produces empty/whitespace-only output.

**Current state:** Generator always creates output files, even if template is empty
**Desired state:** Empty template content → no file generated

This provides a simple, intuitive way to disable any file generation: just clear the template content.

**Applies to all templates:**
- Per-item: model, api, controller
- Supporting: routes.yaml, services.yaml, composer.json
## 2. Rationale

- Template name `api.mustache` is misleading for generating handler interfaces
- Some users may want to write custom handler interfaces
- Cleaner output when feature is disabled (no files generated vs empty files)
- Maintains backward compatibility (enabled by default)

## 3. Solution Analysis
**Selected Approach: Empty template = no file**

Generator checks template output after rendering:
- If output is empty or whitespace-only → skip file creation
- If output has content → create file as normal

**Benefits:**
- No configuration flags needed
- Intuitive behavior
- Self-documenting (empty template = disabled)
- Universal - works for all template types
- Simpler implementation

**Rejected: `enabled` flag in files.json**
- Extra configuration overhead
- Another thing to document
- Less intuitive than "just empty the template"
## 4. Implementation Specification
### Changes Made

**PhpMaxGenerator.java** - Three changes:

1. **`processOpts()`** - Auto-enable post-process file hook:
```java
// Enable post-process file hook to delete empty files
this.enablePostProcessFile = true;
```

2. **`writeToFile()`** - Skip per-operation files with empty content:
```java
if (content == null || content.trim().isEmpty()) {
    LOGGER.info("Skipping empty file: " + path);
    return;
}
```

3. **`postProcessFile()`** - Delete framework-written empty files:
```java
@Override
public void postProcessFile(File file, String fileType) {
    super.postProcessFile(file, fileType);
    if (file != null && file.exists()) {
        String content = Files.readAllBytes(file.toPath());
        if (content.trim().isEmpty()) {
            file.delete();
            LOGGER.info("Deleted empty file: " + file.getPath());
        }
    }
}
```

### Usage

**To disable any template output**, clear its content:
```mustache
{{! Empty template - no files will be generated }}
```

No flags required - works automatically.

### Affected Templates
All templates - both per-operation and framework-managed:
- model.mustache, api.mustache, controller.mustache
- routes.yaml.mustache, services.yaml.mustache, composer.json.mustache
## 5. Acceptance Criteria
- [x] Generator skips file creation when template output is empty/whitespace
- [x] Works for per-item templates (model, api, controller) via `writeToFile()`
- [x] Works for framework-managed files via `postProcessFile()` override
- [x] No error or warning when skipping (silent skip with INFO log)
- [x] Existing non-empty templates continue to work normally
- [x] Test: empty api.mustache produces no Api/*ServiceInterface.php files
- [x] Auto-enabled `enablePostProcessFile` so no CLI flag required