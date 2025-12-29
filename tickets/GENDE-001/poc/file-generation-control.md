# File Generation Control - Complete Guide

## Summary

**YES, you have complete control over file generation granularity!**

You can generate:
- ✅ One file for all operations OR one file per operation
- ✅ One file per HTTP verb OR combined
- ✅ One file per response code OR combined
- ✅ Separate files per model OR combined
- ✅ Any custom file structure you want

**How**: Configure in Java CodegenConfig class, NOT Mustache templates.

---

## Key Concepts

### 1. Template Files vs Generated Files

**Template Files** (what you write):
```
src/main/resources/my-generator/
├── api.mustache              # Template for API files
├── model.mustache            # Template for model files
├── controller.mustache       # Template for controllers
└── operation.mustache        # Template per operation
```

**Generated Files** (what you get):
```
Controlled by:
- apiTemplateFiles map  → What template + what extension
- modelTemplateFiles map → Same for models
- supportingFiles list  → One-time files (README, config, etc.)
```

### 2. File Generation Granularity Control

#### Option A: One File Per API (Tag)

**Default Behavior** - Groups operations by tag:

```java
// In constructor:
apiTemplateFiles.put("api.mustache", ".php");

// Result: petshop.yaml with tags "pets", "store"
// ├── PetsApi.php         // All /pets/* operations
// └── StoreApi.php        // All /store/* operations
```

#### Option B: One File Per Operation

**Custom Implementation** - Separate file for each operation:

```java
// Override this method:
@Override
public String apiFilename(String templateName, String tag) {
    // Instead of using tag (API grouping), use operationId
    // You need to track current operation in postProcessOperationsWithModels

    if (currentOperationId != null) {
        return apiFileFolder() + "/" + toApiFilename(currentOperationId);
    }
    return super.apiFilename(templateName, tag);
}

// In postProcessOperationsWithModels:
for(CodegenOperation op : opList) {
    // Store operation ID for filename
    this.currentOperationId = op.operationId;

    // You can also generate file directly here:
    supportingFiles.add(new SupportingFile(
        "operation.mustache",
        apiFileFolder(),
        op.operationId + ".php"
    ));
}

// Result:
// ├── addPet.php
// ├── deletePet.php
// ├── findPetsByStatus.php
// └── getPetById.php
```

#### Option C: One File Per HTTP Verb

**Group by HTTP method**:

```java
@Override
public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {
    OperationsMap results = super.postProcessOperationsWithModels(objs, allModels);
    OperationMap ops = results.getOperations();
    List<CodegenOperation> opList = ops.getOperation();

    // Group operations by HTTP method
    Map<String, List<CodegenOperation>> byMethod = new HashMap<>();
    for(CodegenOperation op : opList) {
        byMethod.computeIfAbsent(op.httpMethod, k -> new ArrayList<>()).add(op);
    }

    // Generate one file per method
    for(Map.Entry<String, List<CodegenOperation>> entry : byMethod.entrySet()) {
        String method = entry.getKey();
        List<CodegenOperation> methodOps = entry.getValue();

        // Create file for this HTTP method
        supportingFiles.add(new SupportingFile(
            "method-api.mustache",
            apiFileFolder(),
            method.toUpperCase() + "Operations.php"
        ));

        // Pass operations to template
        additionalProperties.put(method + "Operations", methodOps);
    }

    return results;
}

// Result:
// ├── GETOperations.php        // All GET endpoints
// ├── POSTOperations.php       // All POST endpoints
// ├── PUTOperations.php        // All PUT endpoints
// └── DELETEOperations.php     // All DELETE endpoints
```

#### Option D: One File Per Response Code

**Organize by response codes**:

```java
@Override
public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {
    OperationsMap results = super.postProcessOperationsWithModels(objs, allModels);
    OperationMap ops = results.getOperations();
    List<CodegenOperation> opList = ops.getOperation();

    for(CodegenOperation op : opList) {
        // Each operation has responses
        for(CodegenResponse response : op.responses) {
            String code = response.code;  // "200", "404", etc.

            // Generate separate file for each response code
            supportingFiles.add(new SupportingFile(
                "response.mustache",
                apiFileFolder() + "/responses",
                op.operationId + "_" + code + "Response.php"
            ));

            // Pass response data to template
            Map<String, Object> responseData = new HashMap<>();
            responseData.put("operationId", op.operationId);
            responseData.put("code", code);
            responseData.put("response", response);
            additionalProperties.put(op.operationId + "_" + code, responseData);
        }
    }

    return results;
}

// Result:
// responses/
// ├── addPet_200Response.php
// ├── addPet_405Response.php
// ├── getPetById_200Response.php
// ├── getPetById_400Response.php
// └── getPetById_404Response.php
```

#### Option E: Separate Files Per Model

**Default behavior** - one file per model:

```java
// In constructor:
modelTemplateFiles.put("model.mustache", ".php");

// Result: petshop.yaml with models "Pet", "NewPet", "Error"
// ├── Pet.php
// ├── NewPet.php
// └── Error.php
```

#### Option F: Multiple Files Per Model

**Generate DTO + Interface + Builder for each model**:

```java
// In constructor:
modelTemplateFiles.put("model-class.mustache", ".php");        // Class file
modelTemplateFiles.put("model-interface.mustache", "Interface.php");  // Interface
modelTemplateFiles.put("model-builder.mustache", "Builder.php");      // Builder

// Result:
// ├── Pet.php
// ├── PetInterface.php
// ├── PetBuilder.php
// ├── NewPet.php
// ├── NewPetInterface.php
// └── NewPetBuilder.php
```

---

## Advanced Examples

### Example 1: Laravel "One Controller Per Operation" Pattern

Your `laravel-max/` reference implementation likely wants this:

```java
public class LaravelMaxGenerator extends DefaultCodegen {

    @Override
    public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {
        OperationsMap results = super.postProcessOperationsWithModels(objs, allModels);
        OperationMap ops = results.getOperations();
        List<CodegenOperation> opList = ops.getOperation();

        for(CodegenOperation op : opList) {
            // Generate one controller per operation
            supportingFiles.add(new SupportingFile(
                "controller.mustache",
                "app/Http/Controllers/Api",
                op.operationId + "Controller.php"
            ));

            // Pass operation data to template
            additionalProperties.put(op.operationId + "Operation", op);
        }

        return results;
    }
}

// Result:
// app/Http/Controllers/Api/
// ├── AddPetController.php
// ├── DeletePetController.php
// ├── FindPetsByStatusController.php
// └── GetPetByIdController.php
```

### Example 2: Separate Files by Parameter Location

Generate validation rules based on where parameters come from:

```java
for(CodegenOperation op : opList) {
    // Group parameters by location
    List<CodegenParameter> queryParams = new ArrayList<>();
    List<CodegenParameter> pathParams = new ArrayList<>();
    List<CodegenParameter> headerParams = new ArrayList<>();
    List<CodegenParameter> bodyParams = new ArrayList<>();

    for(CodegenParameter param : op.allParams) {
        if (param.isQueryParam) queryParams.add(param);
        if (param.isPathParam) pathParams.add(param);
        if (param.isHeaderParam) headerParams.add(param);
        if (param.isBodyParam) bodyParams.add(param);
    }

    // Generate separate validation file for each location
    if (!queryParams.isEmpty()) {
        supportingFiles.add(new SupportingFile(
            "query-validation.mustache",
            "app/Http/Requests/" + op.operationId,
            "QueryValidation.php"
        ));
        additionalProperties.put(op.operationId + "QueryParams", queryParams);
    }

    if (!pathParams.isEmpty()) {
        supportingFiles.add(new SupportingFile(
            "path-validation.mustache",
            "app/Http/Requests/" + op.operationId,
            "PathValidation.php"
        ));
        additionalProperties.put(op.operationId + "PathParams", pathParams);
    }

    // ... same for headers, body
}

// Result:
// app/Http/Requests/AddPet/
// ├── QueryValidation.php
// ├── PathValidation.php
// ├── HeaderValidation.php
// └── BodyValidation.php
```

### Example 3: Security Requirements Per File

Generate authentication/authorization files based on security requirements:

```java
for(CodegenOperation op : opList) {
    // Check if operation has security requirements
    if (op.authMethods != null && !op.authMethods.isEmpty()) {
        for(CodegenSecurity authMethod : op.authMethods) {
            // Generate middleware for each auth method
            supportingFiles.add(new SupportingFile(
                "auth-middleware.mustache",
                "app/Http/Middleware",
                op.operationId + "_" + authMethod.name + "Middleware.php"
            ));

            Map<String, Object> authData = new HashMap<>();
            authData.put("operationId", op.operationId);
            authData.put("authMethod", authMethod);
            authData.put("scopes", authMethod.scopes);
            additionalProperties.put(op.operationId + "_" + authMethod.name, authData);
        }
    }
}

// Result:
// app/Http/Middleware/
// ├── AddPet_BearerAuthMiddleware.php
// ├── DeletePet_BearerAuthMiddleware.php
// └── UpdatePet_OAuth2Middleware.php
```

---

## Configuration Summary

| Want to Generate | Configure Where | Method |
|------------------|-----------------|--------|
| One file per API (tag) | Constructor | `apiTemplateFiles.put()` (default) |
| One file per operation | `postProcessOperationsWithModels` | Add to `supportingFiles` |
| One file per HTTP verb | `postProcessOperationsWithModels` | Group by `op.httpMethod` |
| One file per response code | `postProcessOperationsWithModels` | Iterate `op.responses` |
| One file per model | Constructor | `modelTemplateFiles.put()` (default) |
| Multiple files per model | Constructor | Multiple `modelTemplateFiles.put()` |
| Custom file structure | `postProcessOperationsWithModels` | Full control via `supportingFiles` |

---

## Key Methods Reference

### Constructor Configuration

```java
public MyGenerator() {
    super();

    // Model templates (one entry per file type per model)
    modelTemplateFiles.put("model.mustache", ".php");
    modelTemplateFiles.put("model.mustache", "Interface.php");  // Second file

    // API templates (one entry per file type per API)
    apiTemplateFiles.put("api.mustache", "Api.php");

    // Supporting files (one-time generation)
    supportingFiles.add(new SupportingFile(
        "composer.json.mustache",  // template name
        "",                        // destination folder (relative to output)
        "composer.json"            // output filename
    ));
}
```

### Runtime File Generation

```java
@Override
public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {
    // Access operation data
    OperationMap ops = objs.getOperations();
    List<CodegenOperation> opList = ops.getOperation();

    // Generate files dynamically
    for(CodegenOperation op : opList) {
        supportingFiles.add(new SupportingFile(
            "template.mustache",
            "output/folder",
            op.operationId + ".php"
        ));

        // Pass data to template
        additionalProperties.put("myData", someData);
    }

    return objs;
}
```

---

## Recommendations for Your Project

Based on your `laravel-max/` reference and the goal of "flexible level of customization":

### Recommended Approach

1. **Default: One controller per operation** (matches `laravel-max/`)
2. **Optional: Group by tag** (via generator flag)
3. **Optional: Custom grouping** (via additional properties)

### Implementation

```java
public class LaravelMaxGenerator extends DefaultCodegen {

    private boolean oneControllerPerOperation = true;  // Default

    public LaravelMaxGenerator() {
        super();

        // CLI option to control grouping
        cliOptions.add(CliOption.newBoolean(
            "oneControllerPerOperation",
            "Generate one controller per operation (default: true)"
        ));
    }

    @Override
    public void processOpts() {
        super.processOpts();

        if (additionalProperties.containsKey("oneControllerPerOperation")) {
            oneControllerPerOperation = Boolean.parseBoolean(
                additionalProperties.get("oneControllerPerOperation").toString()
            );
        }
    }

    @Override
    public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {
        if (oneControllerPerOperation) {
            // Generate one controller per operation
            // ... (see Example 1 above)
        } else {
            // Use default (one API file per tag)
            return super.postProcessOperationsWithModels(objs, allModels);
        }
    }
}
```

**Usage:**
```bash
# One controller per operation (default)
docker run ... generate -g laravel-max -i spec.yaml -o output/

# One API file per tag
docker run ... generate -g laravel-max -i spec.yaml -o output/ \
  --additional-properties=oneControllerPerOperation=false
```

---

## Conclusion

**You have COMPLETE flexibility!** The Java CodegenConfig class gives you full control over:
- File structure
- Naming conventions
- Granularity levels
- Custom organization

**Next Steps:**
1. Decide on default file structure for `laravel-max` generator
2. Implement in Java CodegenConfig
3. Create Mustache templates for each file type
4. Test with real OpenAPI specs
