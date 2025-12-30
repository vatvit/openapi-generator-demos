package org.openapitools.codegen.laravelmax;

import org.openapitools.codegen.*;
import org.openapitools.codegen.languages.AbstractPhpCodegen;
import org.openapitools.codegen.model.*;
import org.openapitools.codegen.templating.GeneratorTemplateContentLocator;
import org.openapitools.codegen.templating.MustacheEngineAdapter;
import org.openapitools.codegen.templating.TemplateManagerOptions;
import org.openapitools.codegen.templating.mustache.*;
import io.swagger.models.properties.*;
import io.swagger.v3.oas.models.security.SecurityScheme;

import java.util.*;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.nio.charset.StandardCharsets;

public class LaravelMaxGenerator extends AbstractPhpCodegen implements CodegenConfig {

  // source folder where to write the files
  protected String sourceFolder = "src";
  protected String apiVersion = "1.0.0";

  // Store resource generation tasks for custom processing
  private List<Map<String, Object>> resourceGenerationTasks = new ArrayList<>();

  // Store controller generation tasks for custom processing (one file per operation)
  private List<Map<String, Object>> controllerGenerationTasks = new ArrayList<>();

  // Store FormRequest generation tasks for custom processing
  private List<Map<String, Object>> formRequestGenerationTasks = new ArrayList<>();

  // Store all operations for routes generation
  private List<CodegenOperation> allOperations = new ArrayList<>();

  // Store enum models and their allowable values for validation rules
  private Map<String, List<String>> enumModels = new HashMap<>();

  // Store security schemes from OpenAPI specification
  private List<Map<String, Object>> securitySchemes = new ArrayList<>();

  // Track if security schemes have been extracted
  private boolean securitySchemesExtracted = false;

  /**
   * Configures the type of generator.
   *
   * @return  the CodegenType for this generator
   * @see     org.openapitools.codegen.CodegenType
   */
  public CodegenType getTag() {
    return CodegenType.OTHER;
  }

  /**
   * Configures a friendly name for the generator.  This will be used by the generator
   * to select the library with the -g flag.
   *
   * @return the friendly name for the generator
   */
  public String getName() {
    return "laravel-max";
  }

  /**
   * Process all models to ensure template variables are properly populated.
   * This fixes the empty variables issue discovered in PoC.
   */
  @Override
  public Map<String, ModelsMap> postProcessAllModels(Map<String, ModelsMap> objs) {
    Map<String, ModelsMap> result = super.postProcessAllModels(objs);

    // Ensure vars are properly mapped for templates
    for (Map.Entry<String, ModelsMap> entry : result.entrySet()) {
      ModelsMap modelsMap = entry.getValue();
      List<ModelMap> models = modelsMap.getModels();

      for (ModelMap modelMap : models) {
        CodegenModel model = modelMap.getModel();

        // Detect if this model is actually an enum
        // Enums have isEnum=true and allowableValues with enum values
        if (model.isEnum && model.allowableValues != null) {
          model.vendorExtensions.put("x-is-php-enum", true);

          // Extract enum values for template
          Map<String, Object> allowableValues = model.allowableValues;
          if (allowableValues.containsKey("values")) {
            List<String> enumValues = (List<String>) allowableValues.get("values");
            List<Map<String, String>> phpEnumCases = new ArrayList<>();

            for (String value : enumValues) {
              Map<String, String> enumCase = new HashMap<>();
              // Create valid PHP case name from value
              String caseName = toEnumCaseName(value);
              enumCase.put("name", caseName);
              enumCase.put("value", value);
              phpEnumCases.add(enumCase);
            }

            model.vendorExtensions.put("x-enum-cases", phpEnumCases);

            // Store enum model and values for validation rules
            if (model.classname != null && !enumValues.isEmpty()) {
              enumModels.put(model.classname, enumValues);
            }
          }
        }

        // Process each variable to ensure proper PHP type mapping
        if (model.vars != null) {
          for (CodegenProperty var : model.vars) {
            // Ensure proper PHP type mapping (AbstractPhpCodegen handles this, but verify)
            if (var.dataType == null || var.dataType.isEmpty()) {
              var.dataType = "mixed";
            }

            // Fix array types: Type[] or Type[][] -> array
            // PHP doesn't support typed array syntax like ClassName[]
            if (var.dataType != null && var.dataType.contains("[]")) {
              var.dataType = "array";
            }

            // Fix generic array types: array<string,mixed> -> array
            // PHP doesn't support generic syntax in property type declarations
            if (var.dataType != null && var.dataType.matches("array<.*>")) {
              var.dataType = "array";
            }

            // Fix nullable mixed: ?mixed is invalid because mixed already includes null
            // Set isNullable=false and required=true to prevent ? from being added
            if (var.dataType != null && var.dataType.equals("mixed")) {
              var.isNullable = false;
              var.required = true;
            }
          }
        }
      }
    }

    return result;
  }

  /**
   * Write Resource files with proper template context
   * This is called after all models are processed so we have access to all model vars
   */
  private void writeResourceFiles() {
    for (Map<String, Object> task : resourceGenerationTasks) {
      String fileName = (String) task.get("fileName");
      String outputDir = (String) task.get("outputDir");
      Map<String, Object> data = (Map<String, Object>) task.get("data");

      // Generate Resource PHP code
      String content = generateResourceContent(data);

      // Write file
      File dir = new File(outputDir);
      if (!dir.exists()) {
        dir.mkdirs();
      }

      File file = new File(dir, fileName);
      try (FileWriter writer = new FileWriter(file)) {
        writer.write(content);
      } catch (IOException e) {
        throw new RuntimeException("Failed to write Resource file: " + fileName, e);
      }
    }
  }

  /**
   * Generate Resource PHP content
   */
  private String generateResourceContent(Map<String, Object> data) {
    StringBuilder sb = new StringBuilder();

    // PHP opening tag with strict_types (must be first statement)
    sb.append("<?php declare(strict_types=1);\n\n");

    // License header
    sb.append("/**\n");
    sb.append(" * Auto-generated by OpenAPI Generator (https://openapi-generator.tech)\n");
    sb.append(" * OpenAPI spec version: ").append(data.get("appVersion")).append("\n");
    sb.append(" * API version: ").append(data.get("appVersion")).append("\n");
    sb.append(" *\n");
    sb.append(" * DO NOT EDIT - This file was generated by the laravel-max generator\n");
    sb.append(" */\n\n");

    sb.append("namespace ").append(data.get("apiPackage")).append("\\Http\\Resources;\n\n");
    sb.append("use Illuminate\\Http\\Resources\\Json\\JsonResource;\n");

    String baseType = (String) data.get("baseType");
    if (baseType != null && !baseType.equals("mixed")) {
      sb.append("use ").append(data.get("modelPackage")).append("\\").append(baseType).append(";\n");
    }
    sb.append("\n");

    // Class doc
    sb.append("/**\n");
    sb.append(" * ").append(data.get("classname")).append("\n");
    sb.append(" *\n");
    sb.append(" * Auto-generated Laravel Resource for ").append(data.get("operationId")).append(" operation (HTTP ").append(data.get("code")).append(")\n");
    sb.append(" *\n");
    sb.append(" * OpenAPI Operation: ").append(data.get("operationId")).append("\n");
    sb.append(" * Response: ").append(data.get("code")).append(" ").append(data.get("message")).append("\n");
    sb.append(" * Schema: ").append(baseType).append("\n");

    List<CodegenProperty> headers = (List<CodegenProperty>) data.get("headers");
    if (headers != null) {
      for (CodegenProperty header : headers) {
        sb.append(" * Header: ").append(header.baseName).append(" ");
        sb.append(header.required ? "(REQUIRED)" : "(optional)").append("\n");
      }
    }
    sb.append(" */\n");

    // Class declaration
    sb.append("class ").append(data.get("classname")).append(" extends JsonResource\n");
    sb.append("{\n");

    // HTTP code property
    sb.append("    /**\n");
    sb.append("     * HTTP status code - Hardcoded: ").append(data.get("code")).append("\n");
    sb.append("     */\n");
    sb.append("    protected int $httpCode = ").append(data.get("code")).append(";\n\n");

    // Header properties
    if (headers != null) {
      for (CodegenProperty header : headers) {
        sb.append("    /**\n");
        sb.append("     * ").append(header.baseName).append(" header ");
        sb.append(header.required ? "(REQUIRED)" : "").append("\n");
        sb.append("     */\n");
        sb.append("    public ?string $").append(header.nameInCamelCase).append(" = null;\n\n");
      }
    }

    // toArray method
    sb.append("    /**\n");
    sb.append("     * Transform the resource into an array.\n");
    sb.append("     *\n");
    sb.append("     * @param  \\Illuminate\\Http\\Request  $request\n");
    sb.append("     * @return array<string, mixed>\n");
    sb.append("     */\n");
    sb.append("    public function toArray($request): array\n");
    sb.append("    {\n");

    if (baseType != null && !baseType.equals("mixed")) {
      sb.append("        /** @var ").append(baseType).append(" $model */\n");
      sb.append("        $model = $this->resource;\n\n");
      sb.append("        return [\n");

      List<CodegenProperty> vars = (List<CodegenProperty>) data.get("vars");
      if (vars != null) {
        for (CodegenProperty var : vars) {
          sb.append("            '").append(var.baseName).append("' => $model->").append(var.name).append(",\n");
        }
      }
      sb.append("        ];\n");
    } else {
      sb.append("        return [];\n");
    }

    sb.append("    }\n\n");

    // withResponse method
    sb.append("    /**\n");
    sb.append("     * Customize the outgoing response.\n");
    sb.append("     *\n");
    sb.append("     * Enforces HTTP ").append(data.get("code")).append(" status code");
    if (headers != null && !headers.isEmpty()) {
      sb.append(" and headers");
    }
    sb.append("\n");
    sb.append("     *\n");
    sb.append("     * @param  \\Illuminate\\Http\\Request  $request\n");
    sb.append("     * @param  \\Illuminate\\Http\\Response  $response\n");
    sb.append("     * @return void\n");
    sb.append("     */\n");
    sb.append("    public function withResponse($request, $response)\n");
    sb.append("    {\n");
    sb.append("        // Set hardcoded HTTP ").append(data.get("code")).append(" status\n");
    sb.append("        $response->setStatusCode($this->httpCode);\n\n");

    // Header validation/setting
    if (headers != null) {
      for (CodegenProperty header : headers) {
        if (header.required) {
          sb.append("        // ").append(header.baseName).append(" header is REQUIRED\n");
          sb.append("        if ($this->").append(header.nameInCamelCase).append(" === null) {\n");
          sb.append("            throw new \\RuntimeException(\n");
          sb.append("                '").append(header.baseName).append(" header is REQUIRED for ");
          sb.append(data.get("operationId")).append(" (HTTP ").append(data.get("code")).append(") but was not set'\n");
          sb.append("            );\n");
          sb.append("        }\n");
          sb.append("        $response->header('").append(header.baseName).append("', $this->").append(header.nameInCamelCase).append(");\n\n");
        } else {
          sb.append("        // ").append(header.baseName).append(" header is optional\n");
          sb.append("        if ($this->").append(header.nameInCamelCase).append(" !== null) {\n");
          sb.append("            $response->header('").append(header.baseName).append("', $this->").append(header.nameInCamelCase).append(");\n");
          sb.append("        }\n\n");
        }
      }
    }

    sb.append("    }\n");
    sb.append("}\n");

    return sb.toString();
  }

  /**
   * Write Controller files with custom generation (one file per operation)
   */
  private void writeControllerFiles() {
    for (Map<String, Object> task : controllerGenerationTasks) {
      String fileName = (String) task.get("fileName");
      String outputDir = (String) task.get("outputDir");
      Map<String, Object> data = (Map<String, Object>) task.get("data");

      // Generate Controller PHP code
      String content = generateControllerContent(data);

      // Write file
      File dir = new File(outputDir);
      if (!dir.exists()) {
        dir.mkdirs();
      }

      File file = new File(dir, fileName);
      try (FileWriter writer = new FileWriter(file)) {
        writer.write(content);
      } catch (IOException e) {
        throw new RuntimeException("Failed to write Controller file: " + fileName, e);
      }
    }
  }

  /**
   * Generate Controller PHP content
   */
  private String generateControllerContent(Map<String, Object> data) {
    StringBuilder sb = new StringBuilder();

    // PHP opening tag with strict_types (must be first statement)
    sb.append("<?php declare(strict_types=1);\n\n");

    // License header
    sb.append("/**\n");
    sb.append(" * Auto-generated by OpenAPI Generator (https://openapi-generator.tech)\n");
    sb.append(" * OpenAPI spec version: ").append(data.get("appVersion")).append("\n");
    sb.append(" * API version: ").append(data.get("appVersion")).append("\n");
    sb.append(" *\n");
    sb.append(" * DO NOT EDIT - This file was generated by the laravel-max generator\n");
    sb.append(" */\n\n");

    sb.append("namespace ").append(data.get("apiPackage")).append("\\Http\\Controllers;\n\n");

    // Use statements
    sb.append("use ").append(data.get("apiPackage")).append("\\Api\\").append(data.get("apiClassName")).append(";\n");

    // Add FormRequest or Model import if present
    CodegenParameter bodyParam = (CodegenParameter) data.get("bodyParam");
    String formRequestClassName = (String) data.get("formRequestClassName");

    if (formRequestClassName != null) {
      // Use FormRequest for validation
      sb.append("use ").append(data.get("apiPackage")).append("\\Http\\Requests\\").append(formRequestClassName).append(";\n");

      // Also import the Model DTO for conversion
      String importClassName = (String) bodyParam.vendorExtensions.get("x-importClassName");
      if (importClassName != null) {
        sb.append("use ").append(data.get("modelPackage")).append("\\").append(importClassName).append(";\n");
      }
    }

    sb.append("use Illuminate\\Http\\JsonResponse;\n\n");

    // Class doc
    sb.append("/**\n");
    sb.append(" * ").append(data.get("classname")).append("\n");
    sb.append(" *\n");
    sb.append(" * Auto-generated controller for ").append(data.get("operationId")).append(" operation\n");
    sb.append(" * One controller per operation pattern\n");
    sb.append(" *\n");
    sb.append(" * OpenAPI Operation: ").append(data.get("operationId")).append("\n");
    sb.append(" * HTTP Method: ").append(data.get("httpMethod")).append(" ").append(data.get("path")).append("\n");
    sb.append(" */\n");

    // Class declaration
    sb.append("class ").append(data.get("classname")).append("\n");
    sb.append("{\n");

    // Constructor with dependency injection
    sb.append("    public function __construct(\n");
    sb.append("        private readonly ").append(data.get("apiClassName")).append(" $handler\n");
    sb.append("    ) {}\n\n");

    // __invoke method
    sb.append("    /**\n");
    String summary = (String) data.get("summary");
    if (summary != null && !summary.isEmpty()) {
      sb.append("     * ").append(summary).append("\n");
      sb.append("     *\n");
    }
    String notes = (String) data.get("notes");
    if (notes != null && !notes.isEmpty()) {
      sb.append("     * ").append(notes).append("\n");
      sb.append("     *\n");
    }

    // Parameter docs
    List<CodegenParameter> allParams = (List<CodegenParameter>) data.get("allParams");
    if (allParams != null) {
      for (CodegenParameter param : allParams) {
        sb.append("     * @param ").append(param.dataType).append(" $").append(param.paramName);
        if (param.description != null && !param.description.isEmpty()) {
          sb.append(" ").append(param.description);
        }
        sb.append("\n");
      }
    }
    sb.append("     * @return JsonResponse\n");
    sb.append("     */\n");

    sb.append("    public function __invoke(\n");

    // Inject FormRequest as first parameter if present
    List<CodegenParameter> pathParams = (List<CodegenParameter>) data.get("pathParams");
    boolean hasPathParams = pathParams != null && !pathParams.isEmpty();

    if (formRequestClassName != null) {
      sb.append("        ").append(formRequestClassName).append(" $request");
      if (hasPathParams) {
        sb.append(",\n");
      } else {
        sb.append("\n");
      }
    }

    // Add path parameters
    if (hasPathParams) {
      for (int i = 0; i < pathParams.size(); i++) {
        CodegenParameter param = pathParams.get(i);
        sb.append("        ").append(param.dataType).append(" $").append(param.paramName);
        if (i < pathParams.size() - 1) {
          sb.append(",");
        }
        sb.append("\n");
      }
    }

    sb.append("    ): JsonResponse\n");
    sb.append("    {\n");

    // Method body
    Boolean hasBodyParam = (Boolean) data.get("hasBodyParam");
    if (hasBodyParam != null && hasBodyParam && bodyParam != null) {
      sb.append("        // Convert validated data to DTO\n");
      sb.append("        $dto = ").append(bodyParam.dataType).append("::fromArray($request->validated());\n\n");
    }

    sb.append("        // Delegate to Handler\n");
    sb.append("        $resource = $this->handler->").append(data.get("operationId")).append("(\n");

    // Pass parameters to handler
    if (hasBodyParam != null && hasBodyParam) {
      sb.append("            $dto");
      if (pathParams != null && !pathParams.isEmpty()) {
        sb.append(",\n");
      } else {
        sb.append("\n");
      }
    }

    if (pathParams != null && !pathParams.isEmpty()) {
      for (int i = 0; i < pathParams.size(); i++) {
        CodegenParameter param = pathParams.get(i);
        sb.append("            $").append(param.paramName);
        if (i < pathParams.size() - 1) {
          sb.append(",");
        }
        sb.append("\n");
      }
    }

    sb.append("        );\n\n");

    sb.append("        // Resource enforces HTTP code and headers\n");
    sb.append("        return $resource->response($request);\n");
    sb.append("    }\n");
    sb.append("}\n");

    return sb.toString();
  }

  /**
   * Write FormRequest files with custom generation
   */
  private void writeFormRequestFiles() {
    for (Map<String, Object> task : formRequestGenerationTasks) {
      String fileName = (String) task.get("fileName");
      String outputDir = (String) task.get("outputDir");
      Map<String, Object> data = (Map<String, Object>) task.get("data");

      // Generate FormRequest PHP code
      String content = generateFormRequestContent(data);

      // Write file
      File dir = new File(outputDir);
      if (!dir.exists()) {
        dir.mkdirs();
      }

      File file = new File(dir, fileName);
      try (FileWriter writer = new FileWriter(file)) {
        writer.write(content);
      } catch (IOException e) {
        throw new RuntimeException("Failed to write FormRequest file: " + fileName, e);
      }
    }
  }

  /**
   * Extract security schemes from OpenAPI specification
   */
  private void extractSecuritySchemes() {
    if (securitySchemesExtracted) {
      return; // Already extracted
    }

    // Don't set extracted flag yet - we may need to try again later if openAPI isn't ready
    if (openAPI == null) {
      return; // OpenAPI not available yet, skip for now
    }

    if (openAPI.getComponents() == null) {
      securitySchemesExtracted = true; // Mark as extracted even if no components
      return;
    }

    securitySchemesExtracted = true; // Now mark as extracted

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
        // Extract flows if needed
        if (scheme.getFlows() != null) {
          List<String> flowTypes = new ArrayList<>();
          if (scheme.getFlows().getAuthorizationCode() != null) flowTypes.add("authorizationCode");
          if (scheme.getFlows().getClientCredentials() != null) flowTypes.add("clientCredentials");
          if (scheme.getFlows().getImplicit() != null) flowTypes.add("implicit");
          if (scheme.getFlows().getPassword() != null) flowTypes.add("password");
          schemeData.put("flows", flowTypes);
        }
      }

      securitySchemes.add(schemeData);
    }
  }

  /**
   * Write security interface files (one per security scheme)
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

        // Load and process template
        String templatePath = "laravel-max/security-interface.mustache";
        InputStream templateStream = this.getClass().getClassLoader().getResourceAsStream(templatePath);

        if (templateStream == null) {
          throw new IOException("Template not found: " + templatePath);
        }

        String templateContent = new String(templateStream.readAllBytes(), StandardCharsets.UTF_8);

        // Process with mustache engine
        com.samskivert.mustache.Template template =
            com.samskivert.mustache.Mustache.compiler().compile(templateContent);

        String content = template.execute(templateData);

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

      // Load and process template
      String templatePath = "laravel-max/security-validator.mustache";
      InputStream templateStream = this.getClass().getClassLoader().getResourceAsStream(templatePath);

      if (templateStream == null) {
        throw new IOException("Template not found: " + templatePath);
      }

      String templateContent = new String(templateStream.readAllBytes(), StandardCharsets.UTF_8);

      // Process with mustache engine
      com.samskivert.mustache.Template template =
          com.samskivert.mustache.Mustache.compiler().compile(templateContent);

      String content = template.execute(templateData);

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

  /**
   * Write routes file with all collected operations
   */
  private void writeRoutesFile() {
    if (allOperations.isEmpty()) {
      return; // No operations to write
    }

    try {
      String content = generateRoutesContent();

      // Write file
      File routesDir = new File(outputFolder, "routes");
      if (!routesDir.exists()) {
        routesDir.mkdirs();
      }

      File routesFile = new File(routesDir, "api.php");
      try (FileWriter writer = new FileWriter(routesFile)) {
        writer.write(content);
      }
    } catch (Exception e) {
      throw new RuntimeException("Failed to write routes file", e);
    }
  }

  /**
   * Generate routes PHP content
   */
  private String generateRoutesContent() {
    StringBuilder sb = new StringBuilder();

    // PHP opening tag
    sb.append("<?php declare(strict_types=1);\n\n");

    // License header
    String version = (String) additionalProperties.getOrDefault("appVersion", "1.0.0");
    sb.append("/**\n");
    sb.append(" * Auto-generated by OpenAPI Generator (https://openapi-generator.tech)\n");
    sb.append(" * OpenAPI spec version: ").append(version).append("\n");
    sb.append(" * API version: ").append(version).append("\n");
    sb.append(" *\n");
    sb.append(" * DO NOT EDIT - This file was generated by the laravel-max generator\n");
    sb.append(" */\n\n");

    sb.append("use Illuminate\\Support\\Facades\\Route;\n");

    // Add use statements for all controllers (deduplicated)
    Set<String> controllerNames = new LinkedHashSet<>();
    for (CodegenOperation op : allOperations) {
      String controllerName = toModelName(op.operationId) + "Controller";
      controllerNames.add(controllerName);
    }
    for (String controllerName : controllerNames) {
      sb.append("use ").append(apiPackage).append("\\Http\\Controllers\\").append(controllerName).append(";\n");
    }

    sb.append("\n/**\n");
    sb.append(" * Auto-generated API Routes\n");
    sb.append(" *\n");
    sb.append(" * Generated from OpenAPI spec: ").append(version).append("\n");
    sb.append(" */\n\n");

    // Add route definitions
    for (CodegenOperation op : allOperations) {
      String controllerName = toModelName(op.operationId) + "Controller";
      String httpMethod = op.httpMethod.toLowerCase();

      sb.append("// ").append(op.httpMethod).append(" ").append(op.path);
      if (op.summary != null && !op.summary.isEmpty()) {
        sb.append(" - ").append(op.summary);
      }
      sb.append("\n");

      sb.append("Route::").append(httpMethod).append("('").append(op.path).append("', ");
      sb.append(controllerName).append("::class)");

      sb.append("\n    ->name('").append(op.operationId).append("')");

      // Add flexible middleware group if auth is required
      if (op.authMethods != null && !op.authMethods.isEmpty()) {
        sb.append("\n    ->middleware('api.security.").append(op.operationId).append("')");
      }

      sb.append(";\n\n");
    }

    return sb.toString();
  }

  /**
   * Generate FormRequest PHP content with validation rules from OpenAPI schema
   */
  private String generateFormRequestContent(Map<String, Object> data) {
    StringBuilder sb = new StringBuilder();

    // PHP opening tag with strict_types (must be first statement)
    sb.append("<?php declare(strict_types=1);\n\n");

    // License header
    sb.append("/**\n");
    sb.append(" * Auto-generated by OpenAPI Generator (https://openapi-generator.tech)\n");
    sb.append(" * OpenAPI spec version: ").append(data.get("appVersion")).append("\n");
    sb.append(" * API version: ").append(data.get("appVersion")).append("\n");
    sb.append(" *\n");
    sb.append(" * DO NOT EDIT - This file was generated by the laravel-max generator\n");
    sb.append(" */\n\n");

    sb.append("namespace ").append(data.get("apiPackage")).append("\\Http\\Requests;\n\n");
    sb.append("use Illuminate\\Foundation\\Http\\FormRequest;\n\n");

    // Class doc
    sb.append("/**\n");
    sb.append(" * ").append(data.get("classname")).append("\n");
    sb.append(" *\n");
    sb.append(" * Auto-generated FormRequest for ").append(data.get("operationId")).append(" operation\n");
    sb.append(" * Validation rules extracted from OpenAPI schema\n");
    sb.append(" */\n");

    // Class declaration
    sb.append("class ").append(data.get("classname")).append(" extends FormRequest\n");
    sb.append("{\n");

    // authorize() method
    sb.append("    /**\n");
    sb.append("     * Determine if the user is authorized to make this request.\n");
    sb.append("     */\n");
    sb.append("    public function authorize(): bool\n");
    sb.append("    {\n");
    sb.append("        return true;  // Authorization logic should be implemented in middleware\n");
    sb.append("    }\n\n");

    // rules() method
    sb.append("    /**\n");
    sb.append("     * Get the validation rules that apply to the request.\n");
    sb.append("     *\n");
    sb.append("     * @return array<string, \\Illuminate\\Contracts\\Validation\\ValidationRule|array<mixed>|string>\n");
    sb.append("     */\n");
    sb.append("    public function rules(): array\n");
    sb.append("    {\n");
    sb.append("        return [\n");

    // Generate validation rules from schema vars
    List<CodegenProperty> vars = (List<CodegenProperty>) data.get("vars");
    List<CodegenProperty> requiredVars = (List<CodegenProperty>) data.get("requiredVars");

    if (vars != null) {
      for (CodegenProperty var : vars) {
        List<String> rules = new ArrayList<>();

        // Check if required
        boolean isRequired = requiredVars != null && requiredVars.stream()
            .anyMatch(rv -> rv.baseName.equals(var.baseName));
        if (isRequired) {
          rules.add("required");
        } else {
          rules.add("sometimes");
        }

        // Add type-based rules
        rules.addAll(getLaravelValidationRules(var));

        sb.append("            '").append(var.baseName).append("' => [");
        for (int i = 0; i < rules.size(); i++) {
          sb.append("'").append(rules.get(i)).append("'");
          if (i < rules.size() - 1) {
            sb.append(", ");
          }
        }
        sb.append("],\n");
      }
    }

    sb.append("        ];\n");
    sb.append("    }\n");
    sb.append("}\n");

    return sb.toString();
  }

  /**
   * Convert OpenAPI property constraints to Laravel validation rules
   */
  private List<String> getLaravelValidationRules(CodegenProperty prop) {
    List<String> rules = new ArrayList<>();

    // Type-based rules
    if (prop.isString) {
      rules.add("string");
      if (prop.minLength != null) {
        rules.add("min:" + prop.minLength);
      }
      if (prop.maxLength != null) {
        rules.add("max:" + prop.maxLength);
      }
      if (prop.pattern != null) {
        // Escape pattern for Laravel regex rule
        String escapedPattern = prop.pattern.replace("/", "\\/");
        rules.add("regex:/" + escapedPattern + "/");
      }
    } else if (prop.isInteger || prop.isLong) {
      rules.add("integer");
      if (prop.minimum != null) {
        rules.add("min:" + prop.minimum);
      }
      if (prop.maximum != null) {
        rules.add("max:" + prop.maximum);
      }
    } else if (prop.isNumber || prop.isFloat || prop.isDouble) {
      rules.add("numeric");
      if (prop.minimum != null) {
        rules.add("min:" + prop.minimum);
      }
      if (prop.maximum != null) {
        rules.add("max:" + prop.maximum);
      }
    } else if (prop.isBoolean) {
      rules.add("boolean");
    } else if (prop.isArray) {
      rules.add("array");
      if (prop.minItems != null) {
        rules.add("min:" + prop.minItems);
      }
      if (prop.maxItems != null) {
        rules.add("max:" + prop.maxItems);
      }
    } else if (prop.isModel) {
      rules.add("array");  // Objects are validated as arrays in Laravel
    }

    // Format-based rules
    if (prop.dataFormat != null) {
      switch (prop.dataFormat) {
        case "email":
          rules.add("email");
          break;
        case "uuid":
          rules.add("uuid");
          break;
        case "uri":
        case "url":
          rules.add("url");
          break;
        case "date":
          rules.add("date");
          break;
        case "date-time":
          rules.add("date");
          break;
        case "ip":
          rules.add("ip");
          break;
        case "ipv4":
          rules.add("ipv4");
          break;
        case "ipv6":
          rules.add("ipv6");
          break;
      }
    }

    // Enum validation
    if (prop.isEnum && prop.allowableValues != null && prop.allowableValues.get("values") != null) {
      List<String> enumValues = (List<String>) prop.allowableValues.get("values");
      if (!enumValues.isEmpty()) {
        String inRule = "in:" + String.join(",", enumValues);
        rules.add(inRule);
      }
    }

    // Also check if the property's dataType references a known enum model
    // This handles cases where the property uses $ref to an enum schema
    if (!prop.isEnum && prop.dataType != null) {
      // Try both the simple class name and the fully qualified name
      List<String> enumValues = null;
      if (enumModels.containsKey(prop.dataType)) {
        enumValues = enumModels.get(prop.dataType);
      } else {
        // Extract simple class name from fully qualified name (e.g., \TictactoeApi\Models\GameMode -> GameMode)
        String simpleName = prop.dataType;
        if (simpleName.contains("\\")) {
          simpleName = simpleName.substring(simpleName.lastIndexOf("\\") + 1);
        }
        if (enumModels.containsKey(simpleName)) {
          enumValues = enumModels.get(simpleName);
        }
      }

      if (enumValues != null && !enumValues.isEmpty()) {
        String inRule = "in:" + String.join(",", enumValues);
        rules.add(inRule);
      }
    }

    return rules;
  }

  /**
   * Provides an opportunity to inspect and modify operation data before the code is generated.
   *
   * CRITICAL: Generate one Resource file per operation+response combination
   * This implements the laravel-max pattern where each operation+response gets its own Resource
   * with hardcoded HTTP status code and header validation.
   */
  @Override
  public OperationsMap postProcessOperationsWithModels(OperationsMap objs, List<ModelMap> allModels) {

    OperationsMap results = super.postProcessOperationsWithModels(objs, allModels);

    // Extract security schemes from OpenAPI spec (first time only)
    extractSecuritySchemes();

    OperationMap ops = results.getOperations();
    List<CodegenOperation> opList = ops.getOperation();

    // Enrich operation data for controller templates
    for(CodegenOperation op : opList){

      // Explicitly set all template variables for controllers
      op.vendorExtensions.put("operationId", op.operationId);
      op.vendorExtensions.put("operationIdCamelCase", toModelName(op.operationId));
      op.vendorExtensions.put("httpMethod", op.httpMethod);
      op.vendorExtensions.put("path", op.path);
      op.vendorExtensions.put("hasPathParams", op.pathParams != null && !op.pathParams.isEmpty());
      op.vendorExtensions.put("hasBodyParam", op.bodyParam != null);
      op.vendorExtensions.put("hasFormParams", op.formParams != null && !op.formParams.isEmpty());
      op.vendorExtensions.put("hasAuthMethods", op.authMethods != null && !op.authMethods.isEmpty());

      // Ensure all parameters have proper data
      if (op.allParams != null) {
        for (CodegenParameter param : op.allParams) {
          if (param.dataType == null || param.dataType.isEmpty()) {
            param.dataType = "mixed";
          }
        }
      }

      // Fix bodyParam for imports - strip duplicate namespace if present
      // bodyParam.dataType may already include namespace like "App\Models\CreateGameRequest"
      // We need just "CreateGameRequest" for the use statement
      if (op.bodyParam != null && op.bodyParam.dataType != null) {
        String dataType = op.bodyParam.dataType;

        // Check if dataType already contains namespace separator
        if (dataType.contains("\\")) {
          // Extract just the class name (last part after final backslash)
          String className = dataType.substring(dataType.lastIndexOf("\\") + 1);
          // Store clean class name without namespace for use statement
          op.bodyParam.vendorExtensions.put("x-importClassName", className);
        } else {
          // dataType is just the class name, use it as-is
          op.bodyParam.vendorExtensions.put("x-importClassName", dataType);
        }
      }

      // Generate one Controller file per operation
      // Collect tasks for custom processing (not using template mechanism)
      String controllerClassName = toModelName(op.operationId) + "Controller";
      String controllerFileName = controllerClassName + ".php";

      // Get API class name from operations map
      String apiClassName = ops.getClassname() + "Api";

      Map<String, Object> controllerData = new HashMap<>();
      controllerData.put("classname", controllerClassName);
      controllerData.put("apiClassName", apiClassName);
      controllerData.put("operationId", op.operationId);
      controllerData.put("operationIdCamelCase", toModelName(op.operationId));
      controllerData.put("httpMethod", op.httpMethod);
      controllerData.put("path", op.path);
      controllerData.put("summary", op.summary);
      controllerData.put("notes", op.notes);
      controllerData.put("apiPackage", apiPackage);
      controllerData.put("modelPackage", modelPackage);
      controllerData.put("appVersion", apiVersion);
      controllerData.put("hasPathParams", op.pathParams != null && !op.pathParams.isEmpty());
      controllerData.put("hasBodyParam", op.bodyParam != null);
      controllerData.put("hasFormParams", op.formParams != null && !op.formParams.isEmpty());
      controllerData.put("pathParams", op.pathParams);
      controllerData.put("allParams", op.allParams);

      // Add bodyParam with import info
      if (op.bodyParam != null) {
        controllerData.put("bodyParam", op.bodyParam);

        // Generate FormRequest class name for this operation if bodyParam has a baseType
        if (op.bodyParam.baseType != null && !op.bodyParam.baseType.isEmpty()) {
          String formRequestClassName = toModelName(op.operationId) + "FormRequest";
          controllerData.put("formRequestClassName", formRequestClassName);
        }
      }

      Map<String, Object> controllerTask = new HashMap<>();
      controllerTask.put("outputDir", outputFolder + "/app/Http/Controllers");
      controllerTask.put("fileName", controllerFileName);
      controllerTask.put("data", controllerData);

      controllerGenerationTasks.add(controllerTask);

      // Collect operation for routes generation
      allOperations.add(op);

      // Generate FormRequest for operations with body parameters
      // FormRequests encapsulate validation logic
      if (op.bodyParam != null && op.bodyParam.baseType != null && !op.bodyParam.baseType.isEmpty()) {
        String formRequestClassName = toModelName(op.operationId) + "FormRequest";
        String formRequestFileName = formRequestClassName + ".php";

        Map<String, Object> formRequestData = new HashMap<>();
        formRequestData.put("classname", formRequestClassName);
        formRequestData.put("operationId", op.operationId);
        formRequestData.put("apiPackage", apiPackage);
        formRequestData.put("appVersion", apiVersion);

        // Get the schema model for validation rules
        CodegenModel schemaModel = null;
        if (allModels != null) {
          for (ModelMap modelMap : allModels) {
            CodegenModel model = modelMap.getModel();
            if (model.classname != null && model.classname.equals(op.bodyParam.baseType)) {
              schemaModel = model;
              break;
            }
          }
        }

        if (schemaModel != null) {
          formRequestData.put("vars", schemaModel.vars);
          formRequestData.put("requiredVars", schemaModel.requiredVars);
        }

        Map<String, Object> formRequestTask = new HashMap<>();
        formRequestTask.put("outputDir", outputFolder + "/app/Http/Requests");
        formRequestTask.put("fileName", formRequestFileName);
        formRequestTask.put("data", formRequestData);

        formRequestGenerationTasks.add(formRequestTask);
      }

      // Generate one Resource file per operation+response
      // Collect tasks for custom processing (not using SupportingFile)
      for(CodegenResponse response : op.responses) {

        // Generate Resource name: {OperationId}{Code}Resource
        // Example: CreateGame201Resource, GetGame200Resource
        String resourceClassName = toModelName(op.operationId) + response.code + "Resource";
        String resourceFileName = resourceClassName + ".php";

        // Create a data map to pass to the resource template
        Map<String, Object> resourceData = new HashMap<>();
        resourceData.put("classname", resourceClassName);
        resourceData.put("operationId", op.operationId);
        resourceData.put("code", response.code);
        resourceData.put("message", response.message);
        resourceData.put("baseType", response.baseType != null ? response.baseType : "mixed");
        resourceData.put("apiPackage", apiPackage);
        resourceData.put("modelPackage", modelPackage);
        resourceData.put("appVersion", apiVersion);

        // Add headers if present
        if (response.headers != null && !response.headers.isEmpty()) {
          resourceData.put("headers", response.headers);
        }

        // Add response schema vars if present
        if (response.schema != null) {
          // Try to get vars from the corresponding model
          String schemaName = response.baseType;
          if (schemaName != null && allModels != null) {
            for (ModelMap modelMap : allModels) {
              CodegenModel model = modelMap.getModel();
              if (model.classname != null && model.classname.equals(schemaName)) {
                resourceData.put("vars", model.vars);
                break;
              }
            }
          }
        }

        // Create generation task
        Map<String, Object> task = new HashMap<>();
        task.put("templateName", "resource.mustache");
        task.put("outputDir", outputFolder + "/app/Http/Resources");
        task.put("fileName", resourceFileName);
        task.put("data", resourceData);

        resourceGenerationTasks.add(task);
      }
    }

    // Write all collected Resource files
    // Note: This may be called multiple times (once per API), but that's OK
    // The files will be rewritten with the same content
    writeResourceFiles();

    // Write all collected Controller files
    // One controller per operation pattern
    writeControllerFiles();

    // Write all collected FormRequest files
    // One FormRequest per operation with body parameters
    writeFormRequestFiles();

    // Write security interface files (one per security scheme)
    writeSecurityInterfaceFiles();

    // Write SecurityValidator file
    writeSecurityValidatorFile();

    // Write routes file with all operations
    writeRoutesFile();

    return results;
  }

  /**
   * Override to prevent parent from adding default supporting files that we don't have templates for.
   */
  @Override
  public void processOpts() {
    super.processOpts();

    // Fix modelPackage and apiPackage if they have leading backslashes
    // PHP namespace declarations cannot have leading backslash
    if (modelPackage != null && modelPackage.startsWith("\\")) {
      modelPackage = modelPackage.substring(1);
    }
    if (apiPackage != null && apiPackage.startsWith("\\")) {
      apiPackage = apiPackage.substring(1);
    }

    // Fix double-escaped backslashes in packages for templates
    // PHP namespace declarations need single backslashes, not double
    if (modelPackage != null) {
      String fixedModelPackage = modelPackage.replace("\\\\", "\\");
      additionalProperties.put("modelPackage", fixedModelPackage);
    }
    if (apiPackage != null) {
      String fixedApiPackage = apiPackage.replace("\\\\", "\\");
      additionalProperties.put("apiPackage", fixedApiPackage);
    }

    // Clear any supporting files added by parent that we don't want
    supportingFiles.clear();

    // Note: routes/api.php is generated manually in writeRoutesFile()
    // No supporting files needed currently
  }

  /**
   * Returns human-friendly help for the generator.  Provide the consumer with help
   * tips, parameters here
   *
   * @return A string value for the help message
   */
  public String getHelp() {
    return "Generates a laravel-max client library.";
  }

  public LaravelMaxGenerator() {
    super();

    // set the output folder here
    outputFolder = "generated-code/laravel-max";

    // Clear ALL parent supporting files first to avoid missing template errors
    this.supportingFiles.clear();

    /**
     * Models: Generate DTOs using model.mustache
     * Clear defaults from parent first
     */
    modelTemplateFiles.clear();
    modelTemplateFiles.put(
      "model.mustache",     // Standard template name
      ".php");              // PHP extension

    /**
     * Api classes: Generate API interfaces
     * NOTE: Controllers are now generated via custom Java code (one file per operation)
     * Clear defaults from parent first
     */
    apiTemplateFiles.clear();
    // Controllers are generated via custom Java code in postProcessOperationsWithModels()
    apiTemplateFiles.put(
      "api-interface.mustache", // API interface with union types
      "Api.php");               // e.g., GameManagementApiApi.php

    /**
     * Template Location: laravel-max templates directory
     */
    embeddedTemplateDir = templateDir = "laravel-max";

    /**
     * Api Package: Laravel namespace for controllers
     * DEFAULT: Empty string (will be set from config options)
     * This prevents double namespace issues - config sets full namespace
     */
    apiPackage = "";

    /**
     * Model Package: Laravel namespace for models/DTOs
     * DEFAULT: Empty string (will be set from config options)
     */
    modelPackage = "";

    /**
     * Invoice package: needed by AbstractPhpCodegen
     * DEFAULT: Empty string (will be set from config options)
     */
    invokerPackage = "";

    /**
     * Additional Properties: Available in all templates
     */
    additionalProperties.put("apiVersion", apiVersion);

    /**
     * Disable documentation and test generation (not needed for PoC)
     */
    modelDocTemplateFiles.clear();
    apiDocTemplateFiles.clear();
    apiTestTemplateFiles.clear();
    modelTestTemplateFiles.clear();

    /**
     * Supporting Files: Clear defaults, add only what we need
     * Note: routes/api.php is generated manually in writeRoutesFile()
     */
    supportingFiles.clear();
  }

  /**
   * Escapes a reserved word as defined in the `reservedWords` array. Handle escaping
   * those terms here.  This logic is only called if a variable matches the reserved words
   *
   * @return the escaped term
   */
  @Override
  public String escapeReservedWord(String name) {
    return "_" + name;  // add an underscore to the name
  }

  /**
   * Override setModelPackage to handle cases where full namespace is provided.
   *
   * When users pass --additional-properties=apiPackage=App,modelPackage=App\\Models,
   * AbstractPhpCodegen prepends apiPackage to modelPackage, causing double namespace: App\App\\Models.
   *
   * This override strips the apiPackage prefix if modelPackage already starts with it.
   *
   * @param modelPackage the model package namespace
   */
  @Override
  public void setModelPackage(String modelPackage) {
    if (modelPackage == null || modelPackage.isEmpty()) {
      super.setModelPackage(modelPackage);
      return;
    }

    // Remove leading backslash if present (AbstractPhpCodegen adds it, but namespace declarations can't have it)
    if (modelPackage.startsWith("\\")) {
      modelPackage = modelPackage.substring(1);
    }

    // If modelPackage starts with apiPackage prefix, strip it to avoid double namespace
    // Example: modelPackage="App\\Models" with apiPackage="App" becomes "Models"
    if (apiPackage != null && !apiPackage.isEmpty()) {
      String prefix = apiPackage + "\\";
      if (modelPackage.startsWith(prefix)) {
        // Strip the apiPackage prefix (AbstractPhpCodegen will add it back)
        modelPackage = modelPackage.substring(prefix.length());
      }
    }

    super.setModelPackage(modelPackage);
  }


  /**
   * Converts package name to proper PHP namespace import.
   *
   * AbstractPhpCodegen uses dots (.) as namespace separators, but PHP uses backslashes (\).
   * This override ensures generated use statements have correct PHP syntax.
   *
   * @param name the package name or fully qualified class name
   * @return the fully qualified class name with backslashes
   */
  @Override
  public String toModelImport(String name) {
    if (name == null || name.isEmpty()) {
      return null;
    }

    // If name already contains namespace separator (either . or \), convert dots to backslashes
    if (name.contains(".") || name.contains("\\")) {
      return name.replace(".", "\\");
    }

    // If name is just a class name (no namespace), prepend modelPackage
    // Example: "Game" -> "App\Models\Game"
    if (modelPackage != null && !modelPackage.isEmpty()) {
      return modelPackage + "\\" + name;
    }

    return name;
  }

  /**
   * Post-process parameters to fix PHP type declarations.
   *
   * PHP doesn't support array type hints like `string[]` in function parameters.
   * Convert all array types to `array` for valid PHP syntax.
   *
   * @param parameter the parameter to post-process
   */
  @Override
  public void postProcessParameter(CodegenParameter parameter) {
    super.postProcessParameter(parameter);

    // Fix array type hints: string[] -> array, int[] -> array, etc.
    if (parameter.dataType != null && parameter.dataType.endsWith("[]")) {
      parameter.dataType = "array";
    }
  }

  /**
   * Location to write model files: app/Models/ directory (Laravel standard)
   */
  public String modelFileFolder() {
    return outputFolder + "/app/Models";
  }

  /**
   * Location to write api files: app/Api/ directory
   * API interfaces go in Api/, not Http/Controllers/
   */
  @Override
  public String apiFileFolder() {
    return outputFolder + "/app/Api";
  }

  /**
   * Location to write resource files: app/Http/Resources/ directory (relative to output folder)
   */
  public String resourceFileFolder() {
    return "app/Http/Resources";
  }

  /**
   * override with any special text escaping logic to handle unsafe
   * characters so as to avoid code injection
   *
   * @param input String to be cleaned up
   * @return string with unsafe characters removed or escaped
   */
  @Override
  public String escapeUnsafeCharacters(String input) {
    //TODO: check that this logic is safe to escape unsafe characters to avoid code injection
    return input;
  }

  /**
   * Escape single and/or double quote to avoid code injection
   *
   * @param input String to be cleaned up
   * @return string with quotation mark removed or escaped
   */
  public String escapeQuotationMark(String input) {
    //TODO: check that this logic is safe to escape quotation mark to avoid code injection
    return input.replace("\"", "\\\"");
  }

  /**
   * Post-process supporting file data to add apiInfo for routes generation
   *
   * @param bundle Bundle containing supporting file data
   * @return the modified bundle with apiInfo added
   */
  @Override
  public Map<String, Object> postProcessSupportingFileData(Map<String, Object> bundle) {
    // Call parent implementation first
    bundle = super.postProcessSupportingFileData(bundle);

    // The parent class should have already added apiInfo
    // Just ensure it's available for routes.mustache
    return bundle;
  }

  /**
   * Convert enum value to valid PHP enum case name
   * PHP enum case names must be valid identifiers (alphanumeric + underscore)
   *
   * @param value The enum value from OpenAPI spec
   * @return A valid PHP enum case name
   */
  private String toEnumCaseName(String value) {
    if (value == null || value.isEmpty()) {
      return "EMPTY";
    }

    // Special cases
    if (value.equals(".")) {
      return "EMPTY";
    }

    // Convert to UPPER_SNAKE_CASE
    // Replace non-alphanumeric characters with underscores
    String caseName = value.toUpperCase()
      .replaceAll("[^A-Z0-9_]", "_")
      .replaceAll("_+", "_")  // Replace multiple underscores with single
      .replaceAll("^_|_$", ""); // Remove leading/trailing underscores

    // Ensure it doesn't start with a number
    if (caseName.matches("^[0-9].*")) {
      caseName = "CASE_" + caseName;
    }

    // If empty after sanitization, use default
    if (caseName.isEmpty()) {
      caseName = "VALUE";
    }

    return caseName;
  }
}
