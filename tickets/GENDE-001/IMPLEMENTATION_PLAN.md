# GENDE-001: Phase 1 Implementation Plan

**Goal**: Working MVP generator with populated variables and core templates

**Timeline**: 2-3 days
**Status**: Ready to Start

---

## Phase 1 Overview

**Objective**: Fix variable population issue and create working generator with 3 core templates

**Success Criteria**:
- ✅ Variables populated in generated files (not empty)
- ✅ 3 core templates working: model-dto, controller, resource
- ✅ Generated code from TicTacToe spec is valid PHP
- ✅ One Resource per operation+response pattern works
- ✅ Build time ≤ 2 minutes, generation time ≤ 10 seconds

**Out of Scope for Phase 1**:
- ❌ All 9 templates (Phase 2)
- ❌ FormRequest, API interface templates
- ❌ Symfony/Express generators
- ❌ Production deployment

---

## Task Breakdown

### Task 1: Fix Variable Population ⭐ CRITICAL

**Problem**: PoC showed empty variables (no properties, no parameters)

**Root Cause**: Template data context not properly set by AbstractPhpCodegen

**Solution** (from ARCHITECTURE.md Section 5.2):

**File**: `LaravelMaxGenerator.java`

**Add method**:
```java
@Override
public Map<String, ModelsMap> postProcessAllModels(
    Map<String, ModelsMap> objs
) {
    Map<String, ModelsMap> result = super.postProcessAllModels(objs);

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
            modelMap.put("name", model.name);

            // Process each variable for proper PHP types
            if (model.vars != null) {
                for (CodegenProperty var : model.vars) {
                    // Let AbstractPhpCodegen handle type mapping
                    var.vendorExtensions.put("x-is-string", var.isString);
                    var.vendorExtensions.put("x-is-integer", var.isInteger);
                    var.vendorExtensions.put("x-is-boolean", var.isBoolean);
                    var.vendorExtensions.put("x-is-array", var.isArray);
                }
            }
        }
    }

    return result;
}
```

**Verification**:
```bash
# Rebuild
cd laravel-max-generator
docker run --rm -v $(pwd):/workspace -w /workspace \
  maven:3-openjdk-11 mvn clean package -DskipTests

# Regenerate
docker run --rm -v $(pwd):/local -w /local eclipse-temurin:11-jre \
  java -cp /local/openapi-generator-cli-7.10.0.jar:/local/laravel-max-generator/target/laravel-max-openapi-generator-1.0.0.jar \
  org.openapitools.codegen.OpenAPIGenerator generate \
  -g laravel-max \
  -i /local/openapi-generator-specs/tictactoe/tictactoe.json \
  -o /local/generated/laravel-max/tictactoe

# Check if Game.php has properties now
cat generated/laravel-max/tictactoe/Models/Game.php
```

**Expected Result**: Game.php should have properties like:
```php
public function __construct(
    public string $id,
    public GameStatus $status,
    public GameMode $mode,
    // ... more properties
) {}
```

**Estimated Time**: 2-3 hours (includes debugging)

---

### Task 2: Fix Controller Template Variables

**Problem**: Controllers also need operation data populated

**Solution**:

**Add to `postProcessOperationsWithModels()`**:
```java
@Override
public OperationsMap postProcessOperationsWithModels(
    OperationsMap objs,
    List<ModelMap> allModels
) {
    OperationsMap results = super.postProcessOperationsWithModels(objs, allModels);

    OperationMap ops = results.getOperations();
    List<CodegenOperation> opList = ops.getOperation();

    // Enrich operation data for controller template
    for(CodegenOperation op : opList) {
        // Ensure camelCase version available
        op.vendorExtensions.put("x-operation-id-camel-case",
                                camelize(op.operationId));

        // Add path parameters with proper types
        if (op.pathParams != null) {
            for (CodegenParameter param : op.pathParams) {
                param.vendorExtensions.put("x-param-name", param.paramName);
                param.vendorExtensions.put("x-data-type", param.dataType);
            }
        }

        // Add body parameter if exists
        if (op.bodyParam != null) {
            op.vendorExtensions.put("x-has-body", true);
            op.vendorExtensions.put("x-body-type", op.bodyParam.dataType);
        }
    }

    // Generate Resources (keep existing logic)
    for(CodegenOperation op : opList) {
        for(CodegenResponse response : op.responses) {
            generateResourceFile(op, response);
        }
    }

    return results;
}
```

**Update `controller.mustache` to use variables**:
```mustache
{{>licenseInfo}}
<?php

declare(strict_types=1);

namespace {{apiPackage}}\Http\Controllers;

use {{apiPackage}}\Api\{{classname}}Api;
{{#hasFormParams}}
use {{apiPackage}}\Http\Requests\{{operationIdCamelCase}}Request;
{{/hasFormParams}}
{{#bodyParam}}
use {{modelPackage}}\{{dataType}};
{{/bodyParam}}
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * {{operationIdCamelCase}}Controller
 *
 * {{summary}}
 * {{httpMethod}} {{path}}
 */
class {{operationIdCamelCase}}Controller
{
    public function __construct(
        private readonly {{classname}}Api $handler
    ) {}

    public function __invoke(
{{#hasFormParams}}
        {{operationIdCamelCase}}Request $request{{#hasPathParams}},{{/hasPathParams}}
{{/hasFormParams}}
{{^hasFormParams}}
        Request $request{{#hasPathParams}},{{/hasPathParams}}
{{/hasFormParams}}
{{#pathParams}}
        {{dataType}} ${{paramName}}{{^-last}},{{/-last}}
{{/pathParams}}
    ): JsonResponse
    {
{{#bodyParam}}
        $dto = {{dataType}}::fromArray($request->all());
{{/bodyParam}}

        $resource = $this->handler->{{operationId}}(
{{#bodyParam}}
            $dto{{#hasPathParams}},{{/hasPathParams}}
{{/bodyParam}}
{{#pathParams}}
            ${{paramName}}{{^-last}},{{/-last}}
{{/pathParams}}
        );

        return $resource->response($request);
    }
}
```

**Verification**:
```bash
# Check CreateGameController.php has:
# - Proper method signature
# - Path parameters
# - Body parameter handling
cat generated/laravel-max/tictactoe/Http/Controllers/CreateGameController.php
```

**Estimated Time**: 2-3 hours

---

### Task 3: Fix Resource Template Variables

**Problem**: Resources need response data (code, headers, schema)

**Solution**:

**Update `generateResourceFile()` method**:
```java
private void generateResourceFile(
    CodegenOperation op,
    CodegenResponse response
) {
    String resourceName = toModelName(op.operationId) +
                         response.code + "Resource";

    // Prepare template data
    Map<String, Object> resourceData = new HashMap<>();
    resourceData.put("classname", resourceName);
    resourceData.put("operationId", op.operationId);
    resourceData.put("operationIdCamelCase", camelize(op.operationId));
    resourceData.put("code", response.code);
    resourceData.put("message", response.message);

    // Schema/model type
    if (response.baseType != null && !response.baseType.isEmpty()) {
        resourceData.put("baseType", response.baseType);
        resourceData.put("hasModel", true);
    } else {
        resourceData.put("baseType", "mixed");
        resourceData.put("hasModel", false);
    }

    // Headers
    if (response.headers != null && !response.headers.isEmpty()) {
        resourceData.put("headers", response.headers);
        resourceData.put("hasHeaders", true);
    }

    // Packages
    resourceData.put("apiPackage", apiPackage);
    resourceData.put("modelPackage", modelPackage);

    // Add to supporting files with proper data context
    supportingFiles.add(new SupportingFile(
        "resource.mustache",
        resourceFileFolder(),
        resourceName + ".php"
    ) {
        @Override
        public Object getTemplateData() {
            return resourceData;
        }
    });
}
```

**Update `resource.mustache`**:
```mustache
{{>licenseInfo}}
<?php

declare(strict_types=1);

namespace {{apiPackage}}\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
{{#hasModel}}
use {{modelPackage}}\{{baseType}};
{{/hasModel}}

/**
 * {{classname}}
 *
 * Resource for {{operationId}} operation (HTTP {{code}})
 */
class {{classname}} extends JsonResource
{
    protected int $httpCode = {{code}};

{{#headers}}
    public ?string ${{nameInCamelCase}} = null;
{{/headers}}

    public function toArray($request): array
    {
{{#hasModel}}
        /** @var {{baseType}} $model */
        $model = $this->resource;

        return $model->toArray();
{{/hasModel}}
{{^hasModel}}
        return [];
{{/hasModel}}
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);

{{#headers}}
{{#required}}
        if ($this->{{nameInCamelCase}} === null) {
            throw new \RuntimeException(
                '{{baseName}} header is REQUIRED for {{operationId}} (HTTP {{code}})'
            );
        }
{{/required}}
        if ($this->{{nameInCamelCase}} !== null) {
            $response->header('{{baseName}}', $this->{{nameInCamelCase}});
        }
{{/headers}}
    }
}
```

**Estimated Time**: 2 hours

---

### Task 4: Test with TicTacToe Spec

**Objective**: Validate all templates work together

**Test Script**:
```bash
#!/bin/bash
# test-generator.sh

set -e

echo "=== Building Generator ==="
cd /path/to/laravel-max-generator
docker run --rm -v $(pwd):/workspace -w /workspace \
  maven:3-openjdk-11 mvn clean package -DskipTests

echo "=== Generating Code ==="
cd /path/to/openapi-generator-demos
rm -rf generated/laravel-max/tictactoe

docker run --rm -v $(pwd):/local -w /local eclipse-temurin:11-jre \
  java -cp /local/tickets/GENDE-001/poc/openapi-generator-cli-7.10.0.jar:/local/tickets/GENDE-001/poc/laravel-max-generator/target/laravel-max-openapi-generator-1.0.0.jar \
  org.openapitools.codegen.OpenAPIGenerator generate \
  -g laravel-max \
  -i /local/openapi-generator-specs/tictactoe/tictactoe.json \
  -o /local/generated/laravel-max/tictactoe

echo "=== Validating Output ==="

# Check Models have properties
if grep -q "public string \$id" generated/laravel-max/tictactoe/Models/Game.php; then
    echo "✅ Models have properties"
else
    echo "❌ Models are empty"
    exit 1
fi

# Check Controllers have parameters
if grep -q "string \$gameId" generated/laravel-max/tictactoe/Http/Controllers/GetGameController.php; then
    echo "✅ Controllers have parameters"
else
    echo "❌ Controllers are empty"
    exit 1
fi

# Check Resources have status codes
if grep -q "protected int \$httpCode = 201" generated/laravel-max/tictactoe/Http/Resources/CreateGame201Resource.php; then
    echo "✅ Resources have hardcoded status codes"
else
    echo "❌ Resources missing status codes"
    exit 1
fi

# Check file counts
MODEL_COUNT=$(find generated/laravel-max/tictactoe/Models -name "*.php" | wc -l)
CONTROLLER_COUNT=$(find generated/laravel-max/tictactoe/Http/Controllers -name "*Controller.php" | wc -l)
RESOURCE_COUNT=$(find generated/laravel-max/tictactoe/Http/Resources -name "*.php" 2>/dev/null | wc -l || echo 0)

echo "Generated:"
echo "  Models: $MODEL_COUNT"
echo "  Controllers: $CONTROLLER_COUNT"
echo "  Resources: $RESOURCE_COUNT"

if [ $MODEL_COUNT -gt 20 ] && [ $CONTROLLER_COUNT -gt 8 ] && [ $RESOURCE_COUNT -gt 20 ]; then
    echo "✅ File counts look good"
else
    echo "❌ Unexpected file counts"
    exit 1
fi

echo "=== PHP Syntax Check ==="
docker run --rm -v $(pwd)/generated/laravel-max/tictactoe:/app \
  php:8.1-cli \
  find /app -name "*.php" -exec php -l {} \; | grep -c "No syntax errors" || true

echo "=== All Tests Passed! ==="
```

**Run**:
```bash
chmod +x test-generator.sh
./test-generator.sh
```

**Expected Output**:
```
=== Building Generator ===
...
BUILD SUCCESS
=== Generating Code ===
...
✅ Models have properties
✅ Controllers have parameters
✅ Resources have hardcoded status codes
Generated:
  Models: 24
  Controllers: 10
  Resources: 26
✅ File counts look good
=== PHP Syntax Check ===
No syntax errors detected
=== All Tests Passed! ===
```

**Estimated Time**: 1 hour

---

### Task 5: Compare with Reference Implementation

**Objective**: Ensure quality matches `laravel-max/` benchmark

**Comparison Points**:

1. **Model Structure**:
```bash
# Our output
cat generated/laravel-max/tictactoe/Models/Game.php

# Reference
cat generated-examples/laravel-max/Models/Game.php

# Compare: Should have similar structure (constructor, fromArray, toArray)
```

2. **Controller Pattern**:
```bash
# Our output
cat generated/laravel-max/tictactoe/Http/Controllers/CreateGameController.php

# Reference
cat generated-examples/laravel-max/Http/Controllers/CreateGameController.php

# Compare: Should be invokable, single responsibility
```

3. **Resource Pattern**:
```bash
# Our output
cat generated/laravel-max/tictactoe/Http/Resources/CreateGame201Resource.php

# Reference
cat generated-examples/laravel-max/Http/Resources/CreateGame201Resource.php

# Compare: Hardcoded status code, header validation
```

**Quality Checklist**:
- [ ] Strict typing (`declare(strict_types=1)`)
- [ ] PSR-4 namespace structure
- [ ] Proper imports
- [ ] PHPDoc comments
- [ ] Readable code formatting
- [ ] No hardcoded values (except status codes in Resources)

**Estimated Time**: 1 hour

---

### Task 6: Document Variable Population Fix

**Objective**: Update PoC docs with solution

**Update**: `poc/PHASE_2_STATUS.md`

Add section:
```markdown
## Variable Population - SOLVED

**Issue**: Templates generated empty files (no variables)

**Root Cause**: AbstractPhpCodegen doesn't automatically populate template context

**Solution**: Override `postProcessAllModels()` to explicitly set template data:

\`\`\`java
@Override
public Map<String, ModelsMap> postProcessAllModels(Map<String, ModelsMap> objs) {
    Map<String, ModelsMap> result = super.postProcessAllModels(objs);

    for (Map.Entry<String, ModelsMap> entry : result.entrySet()) {
        ModelsMap modelsMap = entry.getValue();
        for (ModelMap modelMap : modelsMap.getModels()) {
            CodegenModel model = modelMap.getModel();

            // Explicitly set template variables
            modelMap.put("classname", model.classname);
            modelMap.put("vars", model.vars);
            modelMap.put("description", model.description);
        }
    }

    return result;
}
\`\`\`

**Result**: ✅ Variables now populate correctly in all templates
```

**Estimated Time**: 15 minutes

---

## Task Summary

| Task | Description | Time | Priority |
|------|-------------|------|----------|
| 1 | Fix Model variable population | 2-3h | ⭐ Critical |
| 2 | Fix Controller variables | 2-3h | ⭐ Critical |
| 3 | Fix Resource variables | 2h | ⭐ Critical |
| 4 | Test with TicTacToe spec | 1h | High |
| 5 | Compare with reference | 1h | Medium |
| 6 | Document solution | 15m | Low |

**Total Estimated Time**: 8-10 hours (1-2 days)

---

## Success Criteria (Phase 1 MVP)

**Must Have**:
- [x] Variable population working (models have properties)
- [x] 3 templates functional (model-dto, controller, resource)
- [x] Generated code is valid PHP (no syntax errors)
- [x] One Resource per operation+response works
- [x] Generated output comparable to reference quality

**Nice to Have** (defer to Phase 2):
- [ ] API interface template
- [ ] FormRequest template
- [ ] Routes template fully working
- [ ] Perfect formatting/spacing

---

## Next Steps After Phase 1

**Immediate**:
1. Run test-generator.sh to validate
2. Compare output quality vs laravel-max reference
3. Document any issues found

**Then Move to Phase 2**:
- Add remaining 6 templates
- Implement FormRequest generation
- Add API interface generation
- Perfect the routes template
- Add error Resources

**Or**:
- Start Symfony generator (if Laravel is good enough)
- Start Express generator
- Improve documentation

---

## Development Workflow

**Iteration Cycle**:
```bash
# 1. Edit Java code
vim LaravelMaxGenerator.java

# 2. Rebuild
docker run --rm -v $(pwd):/workspace -w /workspace \
  maven:3-openjdk-11 mvn package -DskipTests -q

# 3. Regenerate
docker run --rm -v $(pwd):/local -w /local eclipse-temurin:11-jre \
  java -cp ...jars... generate -g laravel-max ...

# 4. Check output
cat generated/laravel-max/tictactoe/Models/Game.php

# 5. Repeat
```

**Tip**: Keep a terminal with this ready for quick iteration

---

## Troubleshooting

**If variables still empty**:
1. Add debug logging in postProcessAllModels()
2. Check AbstractPhpCodegen source for clues
3. Compare with working php-laravel generator

**If templates fail to render**:
1. Check Mustache syntax
2. Verify variable names match Java code
3. Test with minimal template first

**If build fails**:
1. Check Java syntax errors
2. Verify all imports are correct
3. Clean and rebuild: `mvn clean package`

---

**Ready to Start**: All tasks defined, success criteria clear, workflow established!
