# Security Infrastructure Implementation Plan

## Changes to LaravelMaxGenerator.java

### 1. Add Security Scheme Storage
```java
// Add to class fields (line ~35):
private List<Map<String, Object>> securitySchemes = new ArrayList<>();
private boolean securitySchemesExtracted = false;
```

### 2. Extract Security Schemes from OpenAPI Spec
```java
// Add new method after line 1020:
/**
 * Extract security schemes from OpenAPI specification
 */
private void extractSecuritySchemes() {
    if (securitySchemesExtracted) {
        return; // Already extracted
    }

    securitySchemesExtracted = true;

    if (openAPI == null || openAPI.getComponents() == null) {
        return;
    }

    Map<String, SecurityScheme> schemes = openAPI.getComponents().getSecuritySchemes();
    if (schemes == null || schemes.isEmpty()) {
        return;
    }

    for (Map.Entry<String, SecurityScheme> entry : schemes.entrySet()) {
        String schemeName = entry.getKey();
        SecurityScheme scheme = entry.getValue();

        Map<String, Object> schemeData = new HashMap<>();
        schemeData.put("name", schemeName);
        schemeData.put("type", scheme.getType().toString());
        schemeData.put("description", scheme.getDescription());

        // Generate interface name: bearerHttpAuthentication -> BearerHttpAuthenticationInterface
        String interfaceName = toModelName(schemeName) + "Interface";
        schemeData.put("interfaceName", interfaceName);

        // Type-specific data
        if (scheme.getType() == SecurityScheme.Type.HTTP) {
            schemeData.put("isHttp", true);
            schemeData.put("httpScheme", scheme.getScheme());

            if ("bearer".equalsIgnoreCase(scheme.getScheme())) {
                schemeData.put("isBearerAuth", true);
                schemeData.put("bearerFormat", scheme.getBearerFormat());
            } else if ("basic".equalsIgnoreCase(scheme.getScheme())) {
                schemeData.put("isBasicAuth", true);
            }
        } else if (scheme.getType() == SecurityScheme.Type.APIKEY) {
            schemeData.put("isApiKey", true);
            schemeData.put("apiKeyIn", scheme.getIn().toString());
            schemeData.put("apiKeyName", scheme.getName());
        } else if (scheme.getType() == SecurityScheme.Type.OAUTH2) {
            schemeData.put("isOAuth2", true);
            // Extract flows and scopes if needed
        }

        securitySchemes.add(schemeData);
    }
}
```

### 3. Generate Security Interface Files
```java
// Add new method after extractSecuritySchemes():
/**
 * Write security interface files
 */
private void writeSecurityInterfaceFiles() {
    if (securitySchemes.isEmpty()) {
        return;
    }

    for (Map<String, Object> scheme : securitySchemes) {
        try {
            String interfaceName = (String) scheme.get("interfaceName");
            String fileName = interfaceName + ".php";

            // Add template data
            Map<String, Object> templateData = new HashMap<>(scheme);
            templateData.put("invokerPackage", invokerPackage);
            templateData.put("schemeName", scheme.get("name"));
            templateData.put("schemeType", scheme.get("type"));
            templateData.put("schemeDescription", scheme.get("description"));

            // Generate using mustache template
            String content = processTemplate("security-interface.mustache", templateData);

            // Write file
            File securityDir = new File(outputFolder, "app/Security");
            if (!securityDir.exists()) {
                securityDir.mkdirs();
            }

            File interfaceFile = new File(securityDir, fileName);
            try (FileWriter writer = new FileWriter(interfaceFile)) {
                writer.write(content);
            }
        } catch (Exception e) {
            throw new RuntimeException("Failed to write security interface file", e);
        }
    }
}
```

### 4. Generate SecurityValidator File
```java
// Add new method after writeSecurityInterfaceFiles():
/**
 * Write SecurityValidator file
 */
private void writeSecurityValidatorFile() {
    if (securitySchemes.isEmpty()) {
        return; // No security schemes, no validator needed
    }

    try {
        Map<String, Object> templateData = new HashMap<>();
        templateData.put("invokerPackage", invokerPackage);
        templateData.put("securitySchemes", securitySchemes);
        templateData.put("operations", allOperations);

        // Generate using mustache template
        String content = processTemplate("security-validator.mustache", templateData);

        // Write file
        File securityDir = new File(outputFolder, "app/Security");
        if (!securityDir.exists()) {
            securityDir.mkdirs();
        }

        File validatorFile = new File(securityDir, "SecurityValidator.php");
        try (FileWriter writer = new FileWriter(validatorFile)) {
            writer.write(content);
        }
    } catch (Exception e) {
        throw new RuntimeException("Failed to write SecurityValidator file", e);
    }
}
```

### 5. Update postProcessOperationsWithModels() Method
```java
// Add after line 823 (after super.postProcessOperationsWithModels()):
// Extract security schemes (first time only)
extractSecuritySchemes();
```

### 6. Call New Methods in postProcessOperationsWithModels()
```java
// Replace lines 1003-1017 with:
// Write all collected Resource files
writeResourceFiles();

// Write all collected Controller files
writeControllerFiles();

// Write all collected FormRequest files
writeFormRequestFiles();

// Write security interface files
writeSecurityInterfaceFiles();

// Write SecurityValidator file
writeSecurityValidatorFile();

// Write routes file with all operations
writeRoutesFile();
```

### 7. Update generateRoutesContent() Method
```java
// Replace lines 595-598 (hardcoded auth:sanctum) with:
// Add middleware if auth is required
if (op.authMethods != null && !op.authMethods.isEmpty()) {
    sb.append("\n    ->middleware('api.security.").append(op.operationId).append("')");
}
```

### 8. Add Helper Method for Template Processing
```java
// Add new method:
/**
 * Process mustache template with data
 */
private String processTemplate(String templateName, Map<String, Object> data) throws IOException {
    // Get template file
    String templatePath = "laravel-max/" + templateName;
    InputStream templateStream = this.getClass().getClassLoader().getResourceAsStream(templatePath);

    if (templateStream == null) {
        throw new IOException("Template not found: " + templatePath);
    }

    // Read template content
    String templateContent = new String(templateStream.readAllBytes(), StandardCharsets.UTF_8);

    // Process with mustache
    com.samskivert.mustache.Template template =
        com.samskivert.mustache.Mustache.compiler().compile(templateContent);

    return template.execute(data);
}
```

## Required Imports to Add
```java
import io.swagger.v3.oas.models.security.SecurityScheme;
import java.nio.charset.StandardCharsets;
import java.io.InputStream;
```

## Summary of Changes

**Files Modified:**
- `LaravelMaxGenerator.java` (~200 lines of new code)

**New Templates Created:**
- ✅ `security-interface.mustache` (done)
- ✅ `security-validator.mustache` (done)
- ✅ `routes.mustache` (updated)

**New Generated Files:**
- `app/Security/{SchemeName}Interface.php` - one per security scheme
- `app/Security/SecurityValidator.php` - validator for all schemes
- `routes/api.php` - updated with flexible middleware

**Benefits:**
- ✅ Removes hardcoded `auth:sanctum` dependency
- ✅ Supports any authentication system (Passport, custom JWT, etc.)
- ✅ Per-operation middleware customization
- ✅ Runtime validation in debug mode
- ✅ Clear interfaces matching OpenAPI security schemes
- ✅ SOLID principles: Interface Segregation, Dependency Inversion
