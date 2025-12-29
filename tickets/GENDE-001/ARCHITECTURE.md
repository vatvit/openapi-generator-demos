# GENDE-001: Architecture Design

**Custom OpenAPI Generator with Template-Based Framework Support**

**Status**: Draft
**Author**: Based on PoC findings (PHASE_2_STATUS.md)
**Date**: 2025-12-28

---

## 1. Executive Summary

This architecture defines a custom OpenAPI Generator implementation that produces high-quality, contract-enforced API libraries for multiple frameworks (Laravel, Symfony, Node.js Express) using template-based code generation.

**Key Architectural Decisions**:
- ✅ One generator per framework (not single universal generator)
- ✅ Extend language-specific base classes (AbstractPhpCodegen, AbstractTypeScriptCodegen)
- ✅ Templates control output format, Java controls file generation strategy
- ✅ One Resource per operation+response (compile-time type safety)
- ✅ Docker-only development workflow

**PoC Validation**: All critical technical uncertainties resolved (see PHASE_2_STATUS.md)

---

## 2. System Architecture

### 2.1 High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    OpenAPI Specification                     │
│                     (tictactoe.json)                         │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│              OpenAPI Generator CLI (7.10.0)                  │
│         (openapi-generator-cli-7.10.0.jar)                   │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        │ Loads custom generator
                        ▼
┌─────────────────────────────────────────────────────────────┐
│           Custom Framework Generator (JAR)                   │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │  LaravelMaxGenerator extends AbstractPhpCodegen        │ │
│  │  - processOpts()                                       │ │
│  │  - postProcessOperationsWithModels()                   │ │
│  │  - postProcessModels()                                 │ │
│  │  - toApiName(), toModelName(), etc.                    │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │  Template Resources (src/main/resources/laravel-max/)  │ │
│  │  - model-dto.mustache                                  │ │
│  │  - controller.mustache                                 │ │
│  │  - resource.mustache                                   │ │
│  │  - api-interface.mustache                              │ │
│  │  - form-request.mustache                               │ │
│  │  - routes.mustache                                     │ │
│  └────────────────────────────────────────────────────────┘ │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        │ Generates
                        ▼
┌─────────────────────────────────────────────────────────────┐
│                    Generated Code                            │
│                                                              │
│  Models/                 Http/Controllers/    Http/Resources/│
│  ├── Game.php            ├── CreateGameController.php       │
│  ├── Player.php          ├── GetGameController.php          │
│  └── ...                 └── ...              └── ...       │
│                                                              │
│  Api/                    routes/                             │
│  ├── GameManagementApi.php   └── api.php                    │
│  └── ...                                                     │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 Generator Per Framework Strategy

**Architecture Decision**: Separate generator for each framework

```
generators/
├── laravel-max-openapi-generator/
│   ├── pom.xml
│   ├── src/main/java/.../LaravelMaxGenerator.java
│   └── src/main/resources/laravel-max/
│       ├── model-dto.mustache
│       ├── controller.mustache
│       └── ...
│
├── symfony-max-openapi-generator/
│   ├── pom.xml
│   ├── src/main/java/.../SymfonyMaxGenerator.java
│   └── src/main/resources/symfony-max/
│       ├── entity.mustache
│       ├── controller.mustache
│       └── ...
│
└── express-max-openapi-generator/
    ├── pom.xml
    ├── src/main/java/.../ExpressMaxGenerator.java
    └── src/main/resources/express-max/
        ├── model.mustache
        ├── controller.mustache
        └── ...
```

**Rationale**:
- ✅ Clean separation of concerns
- ✅ Framework-specific optimizations
- ✅ Independent versioning and release
- ✅ Easier testing and maintenance
- ❌ Some code duplication (acceptable trade-off)

**Alternative Considered**: Single generator with `--framework` flag
- ❌ Complex conditionals in Java code
- ❌ Harder to test all framework combinations
- ❌ Tighter coupling between frameworks

---

## 3. Generator Class Design

### 3.1 Class Hierarchy

```java
AbstractPhpCodegen (OpenAPI Generator core)
    ↑
    │ extends
    │
LaravelMaxGenerator
    ↓
    implements CodegenConfig
```

### 3.2 LaravelMaxGenerator Structure

```java
package org.openapitools.codegen.laravelmax;

import org.openapitools.codegen.languages.AbstractPhpCodegen;
import org.openapitools.codegen.CodegenConfig;

public class LaravelMaxGenerator extends AbstractPhpCodegen
                                 implements CodegenConfig {

    // === CONSTRUCTOR ===
    public LaravelMaxGenerator() {
        super();

        // Configure output folders
        outputFolder = "generated-code/laravel-max";

        // Clear parent defaults
        modelTemplateFiles.clear();
        apiTemplateFiles.clear();
        supportingFiles.clear();

        // Register our templates
        modelTemplateFiles.put("model-dto.mustache", ".php");
        apiTemplateFiles.put("controller.mustache", ".php");
        apiTemplateFiles.put("api-interface.mustache", "Api.php");

        // Set template directory
        embeddedTemplateDir = templateDir = "laravel-max";

        // Laravel namespaces
        apiPackage = "App";
        modelPackage = "App\\Models";
        invokerPackage = "App";

        // Disable unwanted generation
        modelDocTemplateFiles.clear();
        apiDocTemplateFiles.clear();
        apiTestTemplateFiles.clear();
        modelTestTemplateFiles.clear();

        // Add routes file
        supportingFiles.add(new SupportingFile(
            "routes.mustache", "", "routes/api.php"
        ));
    }

    // === METADATA ===
    @Override
    public CodegenType getTag() {
        return CodegenType.SERVER;
    }

    @Override
    public String getName() {
        return "laravel-max";
    }

    @Override
    public String getHelp() {
        return "Generates Laravel API with contract enforcement";
    }

    // === FILE PATH CUSTOMIZATION ===
    @Override
    public String modelFileFolder() {
        return outputFolder + "/Models";
    }

    @Override
    public String apiFileFolder() {
        return outputFolder + "/Http/Controllers";
    }

    public String resourceFileFolder() {
        return "Http/Resources";
    }

    // === POST-PROCESSING ===
    @Override
    public OperationsMap postProcessOperationsWithModels(
        OperationsMap objs,
        List<ModelMap> allModels
    ) {
        OperationsMap results = super.postProcessOperationsWithModels(
            objs, allModels
        );

        OperationMap ops = results.getOperations();
        List<CodegenOperation> opList = ops.getOperation();

        // Generate one Resource per operation+response
        for(CodegenOperation op : opList) {
            for(CodegenResponse response : op.responses) {
                generateResourceFile(op, response);
            }

            // Generate FormRequest if operation has body
            if (op.getHasBodyParam()) {
                generateFormRequestFile(op);
            }
        }

        return results;
    }

    @Override
    public Map<String, ModelsMap> postProcessAllModels(
        Map<String, ModelsMap> objs
    ) {
        // Enrich model data for templates
        return super.postProcessAllModels(objs);
    }

    // === HELPER METHODS ===
    private void generateResourceFile(
        CodegenOperation op,
        CodegenResponse response
    ) {
        String resourceName = toModelName(op.operationId) +
                             response.code + "Resource";

        // Create data for template
        Map<String, Object> data = new HashMap<>();
        data.put("classname", resourceName);
        data.put("operationId", op.operationId);
        data.put("operationIdCamelCase", camelize(op.operationId));
        data.put("code", response.code);
        data.put("message", response.message);
        data.put("baseType", response.baseType);
        data.put("apiPackage", apiPackage);
        data.put("modelPackage", modelPackage);

        if (response.headers != null && !response.headers.isEmpty()) {
            data.put("headers", response.headers);
        }

        // Add to supporting files
        supportingFiles.add(new SupportingFile(
            "resource.mustache",
            resourceFileFolder(),
            resourceName + ".php"
        ));

        // Store data for template access
        additionalProperties.put(resourceName, data);
    }

    private void generateFormRequestFile(CodegenOperation op) {
        String requestName = toModelName(op.operationId) + "Request";

        supportingFiles.add(new SupportingFile(
            "form-request.mustache",
            "Http/Requests",
            requestName + ".php"
        ));
    }
}
```

---

## 4. Template Organization

### 4.1 Directory Structure

```
src/main/resources/laravel-max/
├── licenseInfo.mustache          # Partial: License header
├── model-dto.mustache             # Models with fromArray/toArray
├── controller.mustache            # Invokable controllers
├── resource.mustache              # Resources (one per op+response)
├── api-interface.mustache         # Handler interfaces
├── form-request.mustache          # Laravel validation
├── routes.mustache                # API routes
├── error-resource.mustache        # Error response resources
└── partials/
    ├── validation-rules.mustache  # Reusable validation
    └── type-hints.mustache        # Reusable type hints
```

### 4.2 Template Responsibilities

| Template | Purpose | Generated Count | Key Variables |
|----------|---------|-----------------|---------------|
| `model-dto.mustache` | Type-safe DTOs | 1 per schema | `{{classname}}`, `{{vars}}`, `{{description}}` |
| `controller.mustache` | Invokable controllers | 1 per operation | `{{operationId}}`, `{{path}}`, `{{httpMethod}}` |
| `resource.mustache` | Response resources | 1 per operation+response | `{{code}}`, `{{headers}}`, `{{baseType}}` |
| `api-interface.mustache` | Handler contracts | 1 per API tag | `{{operations}}`, `{{responses}}` |
| `form-request.mustache` | Request validation | 1 per operation with body | `{{bodyParam}}`, `{{vars}}` |
| `routes.mustache` | Route definitions | 1 per spec | `{{apiInfo}}`, `{{operations}}` |

---

## 5. Data Flow and Variable Mapping

### 5.1 OpenAPI → CodegenModel Flow

```
OpenAPI Spec
    │
    ├──> Schemas
    │       └──> CodegenModel
    │               ├─> classname
    │               ├─> description
    │               ├─> vars (List<CodegenProperty>)
    │               │     ├─> name
    │               │     ├─> dataType
    │               │     ├─> required
    │               │     └─> description
    │               └─> imports
    │
    └──> Paths/Operations
            └──> CodegenOperation
                    ├─> operationId
                    ├─> httpMethod
                    ├─> path
                    ├─> summary
                    ├─> allParams (List<CodegenParameter>)
                    ├─> bodyParam
                    └─> responses (List<CodegenResponse>)
                           ├─> code
                           ├─> message
                           ├─> baseType
                           └─> headers
```

### 5.2 Variable Population Strategy

**Problem**: PoC showed empty variables despite extending AbstractPhpCodegen

**Root Cause**: Template data context not properly configured

**Solution**:

```java
@Override
public Map<String, ModelsMap> postProcessAllModels(
    Map<String, ModelsMap> objs
) {
    Map<String, ModelsMap> result = super.postProcessAllModels(objs);

    // Ensure vars are properly mapped for templates
    for (Map.Entry<String, ModelsMap> entry : result.entrySet()) {
        ModelsMap modelsMap = entry.getValue();
        List<ModelMap> models = modelsMap.getModels();

        for (ModelMap modelMap : models) {
            CodegenModel model = modelMap.getModel();

            // Explicitly set template data
            modelMap.put("classname", model.classname);
            modelMap.put("description", model.description);
            modelMap.put("vars", model.vars);
            modelMap.put("imports", model.imports);

            // Process each variable
            for (CodegenProperty var : model.vars) {
                // Ensure proper PHP type mapping
                var.dataType = getTypeDeclaration(var);
                var.defaultValue = toDefaultValue(var);
            }
        }
    }

    return result;
}
```

---

## 6. Critical Pattern: One Resource Per Operation+Response

### 6.1 Architecture Rationale

**Standard Approach** (php-laravel):
```php
// One Response class, runtime status code
new CreateGameResponse(statusCode: 201, data: $game);
new CreateGameResponse(statusCode: 400, data: $error);
```

**Our Approach** (laravel-max):
```php
// Multiple Resource classes, compile-time status code
new CreateGame201Resource($game);   // ✅ Compiler knows this is HTTP 201
new CreateGame400Resource($error);  // ✅ Compiler knows this is HTTP 400
```

### 6.2 Implementation Strategy

**In Java Generator**:
```java
@Override
public OperationsMap postProcessOperationsWithModels(...) {
    for(CodegenOperation op : opList) {
        for(CodegenResponse response : op.responses) {
            // Generate CreateGame201Resource, CreateGame400Resource, etc.
            String resourceName = toModelName(op.operationId) +
                                 response.code + "Resource";

            supportingFiles.add(new SupportingFile(
                "resource.mustache",
                "Http/Resources",
                resourceName + ".php"
            ));
        }
    }
}
```

**In Template** (`resource.mustache`):
```mustache
class {{classname}}Resource extends JsonResource
{
    protected int $httpCode = {{code}};  // ← Hardcoded at generation time!

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);
        // Header validation...
    }
}
```

**Result**: Compile-time type safety + runtime enforcement

---

## 7. Multi-Framework Support

### 7.1 Framework Comparison

| Aspect | Laravel | Symfony | Express |
|--------|---------|---------|---------|
| **Base Class** | `AbstractPhpCodegen` | `AbstractPhpCodegen` | `AbstractTypeScriptCodegen` |
| **Routing** | Laravel routes | Symfony annotations | Express router |
| **Validation** | FormRequest | Symfony Validator | express-validator |
| **DI** | Constructor injection | Autowiring | Dependency injection |
| **Response** | JsonResource | JsonResponse | res.json() |

### 7.2 Shared Patterns

**Common Across All Frameworks**:
1. One Resource/Response per operation+response
2. Handler interface with union return types
3. Invokable controllers/handlers
4. Contract enforcement through types

**Framework-Specific**:
1. Template syntax (PHP vs TypeScript)
2. File organization (Laravel vs Symfony vs Express conventions)
3. Validation approach (FormRequest vs Validator vs middleware)

---

## 8. Implementation Phases

### Phase 1: Core Generator (MVP)
**Goal**: Working generator with basic templates

**Deliverables**:
- [ ] LaravelMaxGenerator Java class
- [ ] 3 core templates: model-dto, controller, resource
- [ ] Variable population working
- [ ] Build/test workflow in Docker

**Success Criteria**:
- Generates valid PHP code from TicTacToe spec
- Variables populated correctly
- One Resource per operation+response works

**Estimated Effort**: 2-3 days

### Phase 2: Complete Laravel Templates
**Goal**: All 9 templates from laravel-max-analysis.md

**Deliverables**:
- [ ] api-interface.mustache with union types
- [ ] form-request.mustache with validation
- [ ] routes.mustache with middleware
- [ ] error-resource.mustache for 4xx/5xx
- [ ] security-interface.mustache
- [ ] request-dto.mustache (if different from model)

**Success Criteria**:
- Generated code matches laravel-max quality
- All tests pass
- Documentation complete

**Estimated Effort**: 3-4 days

### Phase 3: Symfony Generator
**Goal**: Symfony-specific generator

**Deliverables**:
- [ ] SymfonyMaxGenerator extends AbstractPhpCodegen
- [ ] Symfony templates (entity, controller, etc.)
- [ ] Symfony-specific patterns

**Estimated Effort**: 4-5 days

### Phase 4: Express Generator
**Goal**: Node.js/TypeScript support

**Deliverables**:
- [ ] ExpressMaxGenerator extends AbstractTypeScriptCodegen
- [ ] Express templates (model, controller, routes)
- [ ] TypeScript type safety

**Estimated Effort**: 4-5 days

---

## 9. Technical Decisions

### TD-1: Extend AbstractPhpCodegen vs DefaultCodegen
**Decision**: Extend `AbstractPhpCodegen`
**Rationale**: Provides PHP-specific type mapping, variable processing, naming conventions
**Trade-off**: Inherits some unwanted behavior (need to clear defaults)

### TD-2: One Generator vs Multi-Framework Generator
**Decision**: Separate generator per framework
**Rationale**: Clean separation, easier maintenance, independent versioning
**Trade-off**: Some code duplication

### TD-3: Mustache vs Alternative Template Engine
**Decision**: Use Mustache (OpenAPI Generator standard)
**Rationale**: Required by OpenAPI Generator, well-supported
**Trade-off**: Limited logic in templates (acceptable - logic goes in Java)

### TD-4: Resources Per Schema vs Per Operation+Response
**Decision**: One Resource per operation+response
**Rationale**: Compile-time type safety, explicit HTTP codes
**Trade-off**: More files generated

### TD-5: Docker-Only vs Local Java/Maven
**Decision**: Docker-only workflow
**Rationale**: Consistent environment, no local setup required
**Trade-off**: Slightly slower iteration (acceptable)

---

## 10. Risk Assessment

### Risk 1: Variable Population Complexity
**Likelihood**: Medium
**Impact**: High
**Mitigation**: Reference php-laravel generator source code, OpenAPI Generator docs
**Contingency**: Fallback to DefaultCodegen + manual type mapping

### Risk 2: AbstractPhpCodegen Breaking Changes
**Likelihood**: Low
**Impact**: Medium
**Mitigation**: Pin to specific OpenAPI Generator version (7.10.0)
**Contingency**: Override affected methods

### Risk 3: Template Complexity
**Likelihood**: Medium
**Impact**: Medium
**Mitigation**: Keep logic in Java, templates for formatting only
**Contingency**: Split complex templates into smaller partials

### Risk 4: Multi-Framework Divergence
**Likelihood**: Medium
**Impact**: Low
**Mitigation**: Document shared patterns, regular sync between generators
**Contingency**: Accept divergence, optimize per-framework

---

## 11. Success Metrics

**Phase 1 Success**:
- [ ] Generator builds successfully in Docker
- [ ] Generates valid code for TicTacToe spec
- [ ] Variables populated (not empty)
- [ ] Build time ≤ 2 minutes
- [ ] Generation time ≤ 10 seconds

**Phase 2 Success**:
- [ ] All 9 templates implemented
- [ ] Generated code passes PHP linting
- [ ] Matches laravel-max quality benchmark
- [ ] Documentation complete

**Overall Success**:
- [ ] All acceptance criteria met (see GENDE-001)
- [ ] Multi-framework support proven
- [ ] Template authoring guide complete
- [ ] Peer review passed

---

## 12. Next Steps

1. **Approve Architecture** - Review and approve this design
2. **Create Implementation Tasks** - Break down Phase 1 into tasks
3. **Set Up Development Environment** - Prepare Docker workflow
4. **Begin Phase 1 Implementation** - Start with variable population fix
5. **Iterate and Refine** - Adjust based on learnings

---

## Appendix A: File Manifest

**PoC Artifacts**:
- `poc/laravel-max-analysis.md` - Reference analysis (9 templates)
- `poc/file-generation-control.md` - File generation patterns
- `poc/PHASE_2_STATUS.md` - PoC results and findings
- `poc/laravel-max-generator/` - Working PoC generator

**Generated Outputs**:
- `/generated/php-laravel/tictactoe/` - Standard generator output
- `/generated/laravel-max/tictactoe/` - Our generator output
- `/generated-examples/laravel-max/` - Reference implementation

---

**Architecture Status**: Draft → Ready for Review
**Next**: Implementation planning and task breakdown
